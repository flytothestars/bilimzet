<template>
    <div>
        <div class="error" v-if="errorText">{{ errorText }}</div>

        <h4>{{ $lang.choice_classification }}</h4>
        <div class="classification" v-if="classificationsIsLoaded">
            <span @click="setActive(classification.id, $event); getCourseDetails(classification.id, 'classification')"
                  v-for="classification in classificationsList"
                  :key="classification.id">
                {{ classification.name }}
            </span>
        </div>
        <div v-else class="olympic-data-loader"></div>
        <h4>{{ $lang.choice_member }}</h4>
        <div class="member" v-if="membersIsLoaded">
            <span @click="getSubjects(member.id); setActive(member.id, $event); getCourseDetails(member.id, 'member')"
                  v-for="member in membersList"
                  :key="member.id">
                {{ member.name }}
            </span>
        </div>
        <div v-else class="olympic-data-loader"></div>
        <div class="subject" v-if="subjectsIsLoaded">
            <h4>{{ $lang.choice_direction }}</h4>
            <span @click="setActive(subject.id, $event); getCourseDetails(subject.id, 'subject')"
                  v-for="subject in subjectsList"
                  :key="subject.id">
                {{ subject.name }}
            </span>
        </div>

        <div v-if="courseDetails.length > 0" class="courses-details box-shadow">
            <h4>{{ $lang.choice_olympic }}</h4>
            <ul>
                <li v-for="course in courseDetails" @click.prevent="setActive(course.id, $event); getCourseDetails(course.id, 'course')">{{ course.title }}</li>
            </ul>
        </div>
        <div v-if="courseDetails.price" class="course-details box-shadow">
            <h4>{{ $lang.info_olympic }} - {{ courseDetails.title }}</h4>
            <ul>
<!--                <li>{{ $lang.price }}: {{ courseDetails.price }}</li>-->
                <li>{{ $lang.questions_count }}: {{ courseDetails.questions_count }}</li>
            </ul>
            <div class="user-data-form">
                <input type="text" :placeholder="$lang.surname" name="lastname" autofocus v-model="lastname" ref="lastname">
                <input type="text" :placeholder="$lang.name" name="name" v-model="name" ref="name">
                <input type="text" :placeholder="$lang.last_name" name="surname" v-model="surname" ref="surname">
            </div>
            <div v-if="member_id === 2">
                <h5>{{ $lang.teacher_name }}</h5>
                <div class="user-data-form">
                    <input type="text" placeholder="Фамилия" name="mentor_lastname" autofocus v-model="mentor_lastname" ref="mentor_lastname">
                    <input type="text" placeholder="Имя" name="mentor_name" v-model="mentor_name" ref="mentor_name">
                    <input type="text" placeholder="Отчество" name="mentor_surname" v-model="mentor_surname" ref="mentor_surname">
                </div>
            </div>
            <div class="button-block">
<!--                <a href="/profile" class="btn-o info">{{ $lang.add_money }}</a>-->
                <a @click.prevent="startOlympic" href="#" class="btn-o success">{{ $lang.start_olympic }}</a>
            </div>
        </div>
        <div v-else-if="courseDetails.length === 0" class="course-details box-shadow">
            <h4>{{ $lang.no_info }}</h4>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                classificationsList: [],
                membersList: [],
                subjectsList: [],
                courseDetails: {
                    id: 0,
                    price: 0,
                    questions_count: 0,
                    loaded: false,
                    url: '',
                },
                classificationsIsLoaded: false,
                membersIsLoaded: false,
                subjectsIsLoaded: false,
                member_id: 0,
                isActive: false,
                errorText: '',
                selectedVariants: {},
                name: '',
                lastname: '',
                surname: '',
                mentor_name: '',
                mentor_lastname: '',
                mentor_surname: '',
                defaultLocale: window.default_locale !== 'ru' ? '/' + window.default_locale : '' ,
            }
        },
        mounted() {
            window.axios.defaults.headers.common = {
                'X-CSRF-TOKEN': this.csrf,
                'X-Requested-With': 'XMLHttpRequest'
            };

            // Get classifications
            axios.get(this.defaultLocale + '/olympics/getClassificationsList')
                .then(response => {
                    this.classificationsList = response.data;
                    this.classificationsIsLoaded = true;
                })
                .catch(errors => console.log(errors));

            // Get members
            axios.get(this.defaultLocale + '/olympics/getMembersList')
                .then(response => {
                    this.membersList = response.data;
                    this.membersIsLoaded = true;
                })
                .catch(errors => console.log(errors));
        },
        methods: {
            getSubjects(member_id) {
                this.selectedVariants.course = 0;

                // Get classifications
                axios.get(this.defaultLocale + '/olympics/getSubjectsList', {
                    params: {
                        member_id: member_id,
                    }
                })
                    .then(response => {
                        this.subjectsList = response.data;
                        this.subjectsIsLoaded = true;
                    })
                    .catch(errors => console.log(errors));
            },
            setActive(id, e) {
                let parentEl = e.target.parentElement;

                for (let i = 0; i < parentEl.children.length; i++) {
                    parentEl.children[i].classList.remove('active')
                }

                e.target.classList.add('active');
            },
            getCourseDetails(variantId, variantName) {
                if (variantName === 'classification') {
                    this.selectedVariants.classification = variantId;
                } else if (variantName === 'member') {
                    this.selectedVariants.member = variantId;
                } else if (variantName === 'subject') {
                    this.selectedVariants.subject = variantId;
                    this.selectedVariants.course = 0;
                } else if (variantName === 'course') {
                    this.selectedVariants.course = variantId;
                }

                if (this.selectedVariants.classification && this.selectedVariants.member && this.selectedVariants.subject) {
                    this.member_id = this.selectedVariants.member;

                    axios.get(this.defaultLocale + '/olympics/getCourseDetail', {
                        params: {
                            classification_id: this.selectedVariants.classification,
                            member_id: this.selectedVariants.member,
                            subject_id: this.selectedVariants.subject,
                            course_id: this.selectedVariants.course,
                        }
                    })
                        .then(response => {
                            this.errorText = response.data.status === 'error' ? response.data.text : '';
                            this.courseDetails = response.data;
                            this.courseDetails.url = '/olympics/start/' + response.data.id;
                            this.courseDetails.loaded = this.selectedVariants.course > 0;
                        })
                        .catch(errors => console.log(errors));
                }
            },
            startOlympic() {
                if (this.lastname.length === 0) {
                    this.$refs.lastname.classList.add('has-error');
                }

                if (this.name.length === 0) {
                    this.$refs.name.classList.add('has-error');
                }

                if (this.member_id === 2) {
                    if (this.mentor_lastname.length === 0) {
                        this.$refs.mentor_lastname.classList.add('has-error');
                    }

                    if (this.mentor_name.length === 0) {
                        this.$refs.mentor_name.classList.add('has-error');
                    }
                }

                /*if (this.surname.length === 0) {
                    this.$refs.surname.classList.add('has-error');
                }*/

                if (this.name.length > 0 && this.lastname.length > 0) { //&& this.surname.length > 0) {
                    if (this.member_id === 2 && (this.mentor_name.length <= 0 || this.mentor_lastname.length <= 0)) {
                        return false;
                    }

                    axios.post(this.defaultLocale + '/olympics/getToken', {
                        course_id: this.courseDetails.id,
                        name: this.name,
                        lastname: this.lastname,
                        surname: this.surname,
                        mentor_name: this.mentor_name,
                        mentor_lastname: this.mentor_lastname,
                        mentor_surname: this.mentor_surname,
                    })
                        .then(response => {
                            if (response.data.not_enough_money === true) {
                                this.errorText = 'Недостаточно средств, пожалуйста пополните счет'
                            } else {
                                window.location.href = response.data.url
                            }
                        })
                        .catch(errors => console.log(errors))
                }
            }
        },
        watch: {
            name: function(value) {
                if (value.length > 0) {
                    this.$refs.name.classList.remove('has-error');
                }
            },
            lastname: function(value) {
                if (value.length > 0) {
                    this.$refs.lastname.classList.remove('has-error');
                }
            },
            mentor_name: function(value) {
                if (value.length > 0) {
                    this.$refs.mentor_name.classList.remove('has-error');
                }
            },
            mentor_lastname: function(value) {
                if (value.length > 0) {
                    this.$refs.mentor_lastname.classList.remove('has-error');
                }
            },
            /*surname: function(value) {
                if (value.length > 0) {
                    this.$refs.surname.classList.remove('has-error');
                }
            }*/
        }
    }
</script>
<style scoped>
    h5 {
        font-weight: 700;
        width: 100%;
        color: #202020;
        text-align: center;
    }
</style>

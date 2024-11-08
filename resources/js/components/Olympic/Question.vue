<template>
    <div>
        <div v-if="!endCourseData.duration">
            <div class="header">
                <ul>
                    <li
                            v-for="(question, key) in questions"
                            :key="question.id"
                            @click.prevent="changeQuestion(question.id)"
                            :class="[question.id === currentQuestion.id ? 'active' : '', answeredQuestionsId.indexOf(question.id) > -1 ? 'answered' : '']">
                        {{ key + 1}}
                    </li>
                </ul>

            </div>

            <ul class="vuejs-countdown" v-if="!endCourseData.duration">
                <li>
                    <p class="digit">00</p>
                </li>
                <li>
                    <p class="digit">{{ minutes | twoDigits }}</p>
                </li>
                <li>
                    <p class="digit">{{ seconds | twoDigits }}</p>
                </li>
            </ul>

            <div class="question-block">
                <h3>{{ currentQuestion.question }}</h3>
                <ul class="answers">
                    <li
                            v-for="answer in currentQuestion.answers"
                            :key="answer.id"
                            @click.prevent.once="setAnswer(answer.question_id, answer.id)">
                        {{ answer.answer }}
                    </li>
                </ul>
            </div>
        </div>
        <div v-if="endCourseData.duration" class="olympic-is-end">
            <olympic-end :end-course-data="endCourseData"></olympic-end>
        </div>
    </div>
</template>
<script>
    import OlympicEnd from './EndCourse.vue'

    let interval = null;

    export default {
        components: {
            OlympicEnd,
        },
        props: {
            tokenKey: {
              type: String,
              required: true,
            },
            remainingMinutes: {
                type: String,
                required: true,
            },
            remainingSeconds: {
                type: String,
                required: true,
            },
        },
        data() {
            return {
                token: this.tokenKey,
                minutes: this.remainingMinutes,
                seconds: this.remainingSeconds,
                currentQuestion: {},
                answeredQuestionsId: [],
                questions: [],
                answered: [],
                endCourseData: {
                    duration: ''
                },
            }
        },
        created() {
            interval = setInterval(() => {
                this.seconds -= 1;
            }, 1000);
        },
        mounted() {
            // Get results
            axios.get('/olympics/getResults', {
                params: {
                    token: this.token
                }
            })
                .then(response => {
                    if (response.data.length > 0) {
                        response.data.forEach(e => {
                            this.answered.push(e);
                            this.answeredQuestionsId.push(e.question_id);
                        });
                    }

                })
                .catch(errors => console.log(errors));

            // Get first question
            axios.get('/olympics/getQuestion', {
                params: {
                    token: this.token
                }
            })
                .then(response => {
                    if (response.data.last_question) {
                        this.CourseHasOver(response.data.token);
                    } else {
                        this.currentQuestion = response.data.currentQuestion;
                        this.questions = response.data.questions;
                        this.token = response.data.token;
                    }
                })
                .catch(errors => console.log(errors));
        },
        methods: {
            setAnswer(question_id, answer_id) {
                if (this.isAlreadyAnswered(question_id)) {
                    return false;
                }

                this.answered.push({
                    question_id: question_id,
                    answer_id: answer_id,
                });

                this.answeredQuestionsId.push(question_id);

                axios.post('/olympics/setAnswer', {
                    answered: this.answered,
                    token: this.token,
                })
                    .then(response => {
                        if (!response.data.last_question) {
                            this.changeQuestion(this.findNextQuestionId());
                        } else {
                            this.CourseHasOver(response.data.token);
                        }
                    });
            },
            changeQuestion(question_id) {
                if (this.isAlreadyAnswered(question_id)) {
                    return false;
                }

                if (this.currentQuestion.id !== question_id) {
                    axios.get('/olympics/getQuestion', {
                        params: {
                            token: this.token,
                            question_id: question_id
                        }
                    })
                        .then(response => {
                            this.currentQuestion = response.data.currentQuestion;
                            this.questions = response.data.questions;
                        })
                        .catch(errors => console.log(errors));
                }
            },
            findNextQuestionId() {
                let questions_answered = this.answered.map(e => e.question_id);
                let all_questions_id = this.questions.map((e => e.id));

                // Remove from array already answered question id and then get min number question id
                return Math.min(...all_questions_id.filter(val => !questions_answered.includes(val)))
            },
            isAlreadyAnswered(question_id) {
                let is_answered = this.answered.findIndex(item => item.question_id === question_id);

                return is_answered > -1;
            },
            CourseHasOver(token) {
                axios.get('/olympics/end', {
                    params: {
                        token: token
                    }
                })
                    .then(response => {
                        this.endCourseData = response.data;
                        clearInterval(interval);
                    })
                    .catch(errors => console.log(errors));
            }
        },
        watch: {
            seconds(value) {
                if (value === -1){
                    this.minutes -= 1;
                    this.seconds = 59;
                }

                if (parseInt(this.minutes) === 0 && value === 0) {
                    this.CourseHasOver(this.token);
                    clearInterval(interval);
                }
            },
        },
        filters: {
            twoDigits(value) {
                if ( value.toString().length <= 1 ) {
                    return '0'+value.toString()
                }
                return value.toString()
            }
        },
    }
</script>
<style scoped>
    .vuejs-countdown {
        padding: 0;
        margin: 0;
    }
    .vuejs-countdown li {
        display: inline-block;
        margin: 0 8px;
        text-align: center;
        position: relative;
    }
    .vuejs-countdown li p {
        margin: 0;
    }
    .vuejs-countdown li:after {
        content: ":";
        position: absolute;
        top: 0;
        right: -13px;
        font-size: 32px;
    }
    .vuejs-countdown li:first-of-type {
        margin-left: 0;
    }
    .vuejs-countdown li:last-of-type {
        margin-right: 0;
    }
    .vuejs-countdown li:last-of-type:after {
        content: "";
    }
    .vuejs-countdown .digit {
        font-size: 32px;
        font-weight: 600;
        line-height: 1.4;
        margin-bottom: 0;
    }
    .vuejs-countdown .text {
        text-transform: uppercase;
        margin-bottom: 0;
        font-size: 10px;
    }
</style>
<template>
    <div>
        <div class="certificate" v-if="endCourseData.results.length !== 0">
            <img :src="endCourseData.certificate_image">
            <img :src="endCourseData.letter_image" v-if="endCourseData.letter_image">
        </div>
        <div class="results">
            <h1>{{ $lang.result }}</h1>
            <span class="duration">{{ $lang.duration }}: {{ endCourseData.duration }}</span>
            <div
                    v-for="(result, key) in endCourseData.results"
                    :key="key"
                    class="question">
                <h3>{{ result.questionText }}</h3>
                <ul>
                    <li>{{ $lang.right_answer }} {{ result.correctAnswerText }}</li>
                    <li :class="{ correctAnswer: result.isCorrectAnswer, 'incorrectAnswer': !result.isCorrectAnswer }">{{ $lang.own_answer }} {{ result.userAnswer }}</li>
                </ul>
            </div>
            <div v-if="endCourseData.results.length === 0" class="no-results">{{ $lang.no_answers }}</div>
        </div>
    </div>
</template>
<script>
   export default {
       props: {
           endCourseData: {
               type: Object,
               required: true,
           }
       }
   }
</script>
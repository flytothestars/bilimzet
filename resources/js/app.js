import Lang from 'vue-lang';

require('./bootstrap');

window.Vue = require('vue');

Vue.component('chat', require('./components/Chat.vue').default);
Vue.component('message', require('./components/Message.vue').default);

// Olympic vue components
Vue.component('olympic-main-list', require('./components/Olympic/MainList.vue').default);
Vue.component('olympic-question', require('./components/Olympic/Question.vue').default);

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

const default_locale = window.default_locale;

const locales = {
    'kz': require('./langs/kz.json'),
    'ru': require('./langs/ru.json'),
}

Vue.use(Lang, {lang: default_locale, locales: locales});

const app = new Vue({
	el: '#app'
});

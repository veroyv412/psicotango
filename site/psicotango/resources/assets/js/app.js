/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated.js';

/*
Object.defineProperties(Vue.prototype, {
    "$form": {
        value: new Form(),
        writable: true
    },
    "$errors": {
        value: new Errors(),
        writable: true
    },
});*/

Vue.use(VueInternationalization);
const i18n = new VueInternationalization({
    locale: window.Laravel.lang,
    messages: Locale
});

const replaceCenterSpaceUnderscore = function(value) {
    return value.replace(' ', '_');
}

Vue.filter('replaceCenterSpaceUnderscore', replaceCenterSpaceUnderscore);

Vue.component('featured-books', require('./components/FeaturedBooks.vue'));
Vue.component('testimonials', require('./components/Testimonials.vue'));
Vue.component('index-lessons', require('./components/IndexLessons.vue'));
Vue.component('lesson-box', require('./components/LessonBox.vue'));
Vue.component('lesson-view', require('./components/LessonView.vue'));
Vue.component('login', require('./components/Login.vue'));
Vue.component('signup', require('./components/Signup.vue'));
Vue.component('select-plan', require('./components/SelectPlan.vue'))
Vue.component('payment', require('./components/Payment.vue'))
Vue.component('profile-settings', require('./components/ProfileSettings.vue'));

Vue.filter('replaceSpaceUnderscore', function(text){
    return text.replace(text, ' ', '_');
});

const app = new Vue({
    i18n,
    loggedUser: window.loggedUser,
    delimiters: ['{{{', '}}}'],
    el: '.application',
});
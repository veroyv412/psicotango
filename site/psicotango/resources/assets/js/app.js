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
//import VueFilter from 'vue-filter'; //https://github.com/wy-ei/vue-filter#trim

Vue.use(VueInternationalization);
//Vue.use(VueFilter);

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
//Vue.component('owl-slider', require('./components/OwlSlider.vue'));
//Vue.component('ad-slider', require('./components/AdSlider.vue'));
//Vue.component('featured-one-box', require('./components/FeaturedOneBox.vue'));
//Vue.component('featured-one-boxes', require('./components/FeaturedOneBoxes.vue'));
//Vue.component('featured-two-box', require('./components/FeaturedTwoBox.vue'));
//Vue.component('featured-two-boxes', require('./components/FeaturedTwoBoxes.vue'));
//Vue.component('search-deal', require('./components/SearchDeal.vue'));
//Vue.component('search-deals', require('./components/SearchDeals.vue'));
//Vue.component('business-form', require('./components/BusinessForm.vue'));
//Vue.component('upload-image', require('./components/UploadImage.vue'));

Vue.filter('replaceSpaceUnderscore', function(text){
    return text.replace(text, ' ', '_');
});

const app = new Vue({
    i18n,
    loggedUser: window.loggedUser,
    delimiters: ['{{{', '}}}'],
    el: '.application',
});
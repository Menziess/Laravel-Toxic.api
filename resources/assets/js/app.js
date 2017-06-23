
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./logging');

window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Background from './components/Background.vue';
import NewPost from './components/input/NewPost.vue';
import Manager from './components/Manager.vue';
import Post from './components/post/Post.vue';

import Example from './components/Example.vue'; // Just an example

/**
 * Custom components.
 */
Vue.component('background', Background);
Vue.component('manager', Manager);
Vue.component('newpost', NewPost);
Vue.component('post', Post);

Vue.component('example', Example); // Just an example

/**
 * Vue app.
 */
const app = new Vue({
    el: '#app'
});
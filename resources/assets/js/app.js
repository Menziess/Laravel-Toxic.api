
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./logging');

import NewPost from './components/input/NewPost.vue';
import Posts from './components/Posts.vue';
import Post from './components/post/Post.vue';

import router from './router';
import store from './store';

window.Vue = require('vue');

/**
 * Custom components.
 */
Vue.component('newpost', NewPost);
Vue.component('posts', Posts);
Vue.component('post', Post);

/**
 * Vue app.
 */
const app = new Vue({
    router,
		store
}).$mount('#app');
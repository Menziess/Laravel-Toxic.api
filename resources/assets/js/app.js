
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./logging');

import VueRouter from 'vue-router';
import NewPost from './components/input/NewPost.vue';
import Posts from './components/Posts.vue';
import Post from './components/post/Post.vue';

window.Vue = require('vue');

Vue.use(VueRouter);

/**
 * Custom components.
 */
Vue.component('newpost', NewPost);
Vue.component('posts', Posts);
Vue.component('post', Post);

/**
 * Route components.
 */
const routes = [
  { 
		path: '/',
		component: Posts 
	}, { 
		path: '/u', 
		component: { template: '<div>Users</div>' } 
	}
];

/**
 * Router.
 */
const history = domain_ext.content === "";
const router = new VueRouter({
	mode: history ? 'history' : '',
  routes: routes
});

/**
 * Vue app.
 */
const app = new Vue({
    router
}).$mount('#app');
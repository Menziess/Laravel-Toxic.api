
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./logging');

import Application from './components/Application.vue';
import Background from './components/Background.vue';
import PostNew from './components/post/PostNew.vue';
import Landing from './components/Landing.vue';
import Subject from './components/nav/Subject.vue';
import Navbar from './components/nav/Navbar.vue';
import Trends from './components/Trends.vue';
import Posts from './components/Posts.vue';
import User from './components/User.vue';

import VueRouter from 'vue-router';
import store from './store';

/**
 * Setting up Vue.
 */
window.Vue = require('vue');
Vue.use(VueRouter);

/**
 * Custom components.
 */
Vue.component('application', Application);
Vue.component('background', Background);
Vue.component('postnew', PostNew);
Vue.component('landing', Landing);
Vue.component('subject', Subject);
Vue.component('navbar', Navbar);
Vue.component('trends', Trends);
Vue.component('posts', Posts);
Vue.component('user', User);

/**
 * Route components.
 */
const routes = [

	{ path: '/t/:slug/:id?', name: 'post', component: Posts, props: true },

	{ path: '/u/:slug?', name: 'user', component: User,
		children: [
			{ path: 'posts', component: { template: '<div><h1>User Posts</h1></div>'} },
		]
	},

  { path: '/landing', name: 'landing', component: Landing }, 

  { path: '/trends', name: 'trends', component: Trends }, 

  { path: '/', name: 'home', component: Posts }, 

	{ path: '*', component: { template: '<div><h1>404</h1></div>' } }
	
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
    router,
		store
}).$mount('#app');
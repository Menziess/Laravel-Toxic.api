
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./logging');

import Application from './components/Application.vue';
import Background from './components/Background.vue';
import Settings from './components/user/Settings.vue';
import PostNew from './components/post/PostNew.vue';
import Landing from './components/Landing.vue';
import Navbar from './components/nav/Navbar.vue';
import Trends from './components/Trends.vue';
import Posts from './components/Posts.vue';
import ErrorPage from './components/ErrorPage.vue';
import Right from './components/nav-sides/Right.vue';
import User from './components/User.vue';
import Left from './components/nav-sides/Left.vue';

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
Vue.component('settings', Settings);
Vue.component('postnew', PostNew);
Vue.component('landing', Landing);
Vue.component('navbar', Navbar);
Vue.component('trends', Trends);
Vue.component('posts', Posts);
Vue.component('right', Right);
Vue.component('error', ErrorPage);
Vue.component('user', User);
Vue.component('left', Left);

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

	{ path: '/settings', name: 'settings', component: Settings },

  { path: '/landing', name: 'landing', component: Landing }, 

  { path: '/trends', name: 'trends', component: Trends }, 

	{ path: '/error', name: 'error', component: ErrorPage },

  { path: '/', name: 'home', component: Posts }, 

	{ path: '*', name: '404', redirect: 'error' }
	
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
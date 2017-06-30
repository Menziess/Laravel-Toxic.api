
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
import Navbar from './components/nav/Navbar.vue';
import Posts from './components/Posts.vue';
import Post from './components/Post.vue';

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
Vue.component('navbar', Navbar);
Vue.component('posts', Posts);
Vue.component('posts', Post);

/**
 * Route components.
 */
const routes = [

  { path: '/', component: Posts }, 

  { path: '/t/:slug', component: Posts, props: true }, //@TODO include child route /t/slug

	{ path: '/t/:slug/:id', component: Post, props: true },

	{ path: '/u/:slug', component: { template: '<div><h1>User {{ $route.params.slug }}</h1></div>' } },

  { path: '/landing', component: Landing }, 

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
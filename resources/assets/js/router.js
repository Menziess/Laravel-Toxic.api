import Vue from 'vue';
import VueRouter from 'vue-router'; 

Vue.use(VueRouter);

/**
 * Route components.
 */
const routes = [
  { path: '/', component: Posts }, 
	{ path: '/t/:slug/:id?', component: Posts, props: true },
	{ path: '/u/:slug', component: { template: '<div><h1>User {{ $route.params.slug }}</h1></div>' } },
	{ path: '*', component: { template: '<div><h1>404</h1></div>' } }
];

/**
 * Router.
 */
const history = domain_ext.content === "";

export const router = new VueRouter({
	mode: history ? 'history' : '',
  routes: routes
});
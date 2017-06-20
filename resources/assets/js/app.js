
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Example from './components/box/Example.vue';
import Editbox from './components/box/Editbox.vue';


/**
 * Custom components.
 */
Vue.component('example', Example);
Vue.component('editbox', Editbox);

const app = new Vue({
    el: '#app'
});


/**
 * Session Storage API Token
 */
const api_token = document.getElementById("api_token");
if (api_token) {
    window.sessionStorage.setItem("api_token", api_token.content);
}
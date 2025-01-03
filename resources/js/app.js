/**
* First we will load all of this project's JavaScript dependencies which
* includes Vue and other libraries. It is a great starting point when
* building robust, powerful web applications using Vue and Laravel.
*/

require("./bootstrap");

// var Turbolinks = require("turbolinks");
// Turbolinks.start();

window.Vue = require("vue").default;

import $ from "jquery";
window.$ = window.jQuery = $;


import "lightbox2/dist/js/lightbox.js";

import "ckeditor4";
window.CKEDITOR = CKEDITOR;

import "@fortawesome/fontawesome-free/js/all.js";












/**
* The following block of code may be used to automatically register your
* Vue components. It will recursively scan this directory for the Vue
* components and automatically register them with their "basename".
*
* Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
*/

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
"example-component",
require("./components/ExampleComponent.vue").default
);
Vue.component(
"table-component",
require("./components/TableComponent.vue").default
);

// import router from "./routers11/router";
/**
* Next, we will create a fresh Vue application instance and attach it to
* the page. Then, you may begin adding components to this application
* or customize the JavaScript scaffolding to fit your unique needs.
*/

const app = new Vue({
el: "#app",
});

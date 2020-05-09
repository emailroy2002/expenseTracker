/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

import Vue from "vue";
window.Vue = Vue;

// Load the Vue router
import VueRouter from "vue-router";
Vue.use(VueRouter);

// Import components
//import messages from "./views/Messages.vue";
//import page2Component from './page-2.vue';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context("./", true, /\.vue$/i);
files
    .keys()
    .map(key =>
        Vue.component(key.split("/").pop().split(".")[0], files(key).default)
    );

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const routes = [
    //{ path: '/', component: require('./views/index.vue').default },
    {
        path: "messages",
        name: "messages",
        component: require("./views/Messages.vue").default
    },
    {
        path: "about-us",
        name: "about-us",
        component: require("./views/About-Us.vue").default
    }
];

var router = new VueRouter({
    routes: routes,
    mode: "history"
});

window.onload = function() {
    const app = new Vue({
        el: "#app",
        router: router
    });
};
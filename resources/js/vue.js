import Vue from "vue";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import Vuelidate from "vuelidate";

import Chartkick from 'vue-chartkick'
import Chart from 'chart.js'
 


//import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'




try {
    window.Vue = Vue;
    
    // Install BootstrapVue
    Vue.use(BootstrapVue)
    // Optionally install the BootstrapVue icon components plugin
    Vue.use(IconsPlugin)

    Vue.use(Vuelidate);

    Vue.use(Chartkick.use(Chart));

    Vue.config.productionTip = false;

    
    //Vue Components Loader 
    const files = require.context("./", true, /\.vue$/i);
    files.keys().map(key => Vue.component(key.split("/").pop().split(".")[0], files(key).default));   
  

    //Initilize #App
    window.onload = function() {        
        const app = new Vue({
            el: "#app",
            router: window.router
        });
    };   
    
} catch (e) {}



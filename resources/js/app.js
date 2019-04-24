require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue';
// import User from './helpers/User';
import Vuetify from 'vuetify'
// import router from './router/router.js';

window.Vue = new Vue;
window.EventBus = new Vue;
Vue.use(Vuetify);

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app'
    // router
});



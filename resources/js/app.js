require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue';
import Vuetify from 'vuetify';
import nd2 from './functions/helpers';
window.nd2 = nd2;


// import router from './router/router.js';
// npm install material-design-icons-iconfont -D
import 'material-design-icons-iconfont/dist/material-design-icons.css' // Ensure you are using css-loader
// npm install @mdi/font -D
// import '@mdi/font/css/materialdesignicons.css'
window.Vue = new Vue;
window.EventBus = new Vue;
Vue.use(Vuetify, {
  iconfont: 'md'
  // iconfont: 'md'
});

import VueScrollTo from 'vue-scrollto';
Vue.use(VueScrollTo, {
  container: "body",
  duration: 500,
  easing: "ease",
  offset: -200,
  force: true,
  cancelable: true,
  onStart: false,
  onDone: false,
  onCancel: false,
  x: false,
  y: true
});

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('new-orders', require('./components/NewOrders.vue').default);



const app = new Vue({
    el: '#app'
    // router
});



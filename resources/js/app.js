require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue';
// import User from './helpers/User';
import Vuetify from 'vuetify'
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

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('new-orders', require('./components/NewOrders.vue').default);

const app = new Vue({
    el: '#app'
    // router
});



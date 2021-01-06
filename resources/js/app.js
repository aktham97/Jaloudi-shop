
// require('./bootstrap');

// window.Vue = require('vue');
// import VueRouter from 'vue-router'
// import Myheader from './components/Myheader'
// import routes from './routes'
//
// Vue.use(VueRouter);
import Vue from 'vue';
import App from './App';
import router from './routes';
import store from './store'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';
import BootstrapVue from 'bootstrap-vue';
import FlashMessage from '@smartweb/vue-flash-message';


// const router = new VueRouter({
//     // mode:'history',
//     routes // short for `routes: routes`
// });
Vue.use(BootstrapVue);
Vue.use(FlashMessage);
new Vue({
    el: '#app',
    router,
    store,
    render: h =>h(App)
    // components:{
    //     Myheader
    // }
});

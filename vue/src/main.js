import Vue from 'vue'
import 'es6-promise/auto'
import axios from 'axios'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import App from './App.vue'
import auth from './auth'
import router from './router'
import store from './vuex/store'
import './assets/app.scss';
import './icons'
import VueSocketIO from 'vue-socket.io'
import SocketIO from "socket.io-client"

// Set Vue globally
window.Vue = Vue

Vue.use(new VueSocketIO({
  debug: true,
  connection: SocketIO('http://messenger.test:3000')
})
);

// Set Vue router
Vue.router = router
Vue.use(VueRouter)
// Set Vue authentication
Vue.use(VueAxios, axios)
axios.defaults.baseURL = `http://messenger.test/api/`
Vue.use(VueAuth, auth)

Vue.config.productionTip = false

new Vue({
  router,
  render: h => h(App),
  store
}).$mount('#app')

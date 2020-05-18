import Vue from 'vue'
import 'es6-promise/auto'
import axios from 'axios'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import App from './App.vue'
import auth from './auth'
import router from './router'
import './assets/app.scss';

// Set Vue globally
window.Vue = Vue
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
  
}).$mount('#app')

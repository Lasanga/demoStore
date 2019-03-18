import Vue from 'vue'
import App from './App.vue'
import axios from 'axios';
import VueSession from 'vue-session'
import VueRouter from 'vue-router'
import SignUp from './components/SignUp.vue'
import SignIn from './components/SignIn.vue'
import Welcome from './components/Welcome.vue'
import Logic from './components/Logic.vue'
import Product from './components/Product.vue'
import Image from './components/Images.vue'
import SignOut from './components/SignOut.vue'
import Sale from './components/Sale.vue'

let options = {
  persist: true
}

Vue.use(VueRouter);
Vue.use(VueSession, options)
window.axios = axios;

window.token = localStorage.getItem('accessToken');

axios.defaults.baseURL = "http://demostore.dev.com/api";
axios.defaults.headers.common['Authorization'] = "Bearer "+ token;
axios.defaults.headers.post['Content-type'] = "application/json";

const routes = [
  { path: '/', component: Welcome },
  { path: '/signup', component: SignUp },
  { path: '/signin', component: SignIn },
  { path: '/logic', component: Logic },
  { path: '/product', component: Product },
  { path: '/product/:id', component: Image },
  { path: '/signout', component: SignOut },
  { path: '/sale', component: Sale }
];

const router = new VueRouter({
  routes,
  mode: 'history'
});

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
  router,
}).$mount('#app')

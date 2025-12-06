import HomePage from './components/Pages/HomePage.vue';
import WebLogin from './components/Auth/WebLogin.vue';
import WebSignup from './components/Auth/WebSignup.vue';
import ShopPage from './components/Pages/shop.vue';

export const routes = [
  {path: '/',name: 'Home',component: HomePage},
  {path:'/login',name: 'Login',component: WebLogin},
  {path:'/signup',name: 'Signup',component: WebSignup},
  {path:'/shop',name: 'Shop',component: ShopPage},
]
import HomePage from './components/Pages/HomePage.vue';
import WebLogin from './components/Auth/WebLogin.vue';
import WebSignup from './components/Auth/WebSignup.vue';
import ShopPage from './components/Pages/shop.vue';
import BrandPage from './components/Pages/BrandPage.vue';
import DetailPage from './components/Pages/DetailPage.vue';
import CartPage from './components/Pages/CartPage.vue'
import OrderPage from './components/Pages/OrderPage.vue';
import SearchPage from './components/Pages/SearchPage.vue';
import FavoritePage from './components/Pages/FavoritePage.vue';
import UserPage from './components/Pages/UserPage.vue'

export const routes = [
  {path: '/',name: 'Home',component: HomePage},
  {path:'/login',name: 'Login',component: WebLogin},
  {path:'/signup',name: 'Signup',component: WebSignup},
  {path:'/shop',name: 'Shop',component: ShopPage},
  {path:'/brand/:id',name: 'Brand',component: BrandPage},
  {path:'/detail/:id',name: 'Detail',component: DetailPage},
  {path:'/cart/:id', name:'Cart', component:CartPage},
  {path:'/order', name:'Order', component:OrderPage},
  {path:'/search', name:'Search', component:SearchPage},
  {path:'/favorite', name:'Favorite', component:FavoritePage},
  {path:'/user/:component?', name:'UserPage', component: UserPage,props: true  }
]
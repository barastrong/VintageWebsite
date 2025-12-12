<template>
  <!-- 1. Tambahkan class flexbox dan min-height 100% pada div utama -->
  <div class="d-flex flex-column min-vh-100">
    
    <!-- Bagian Header -->
    <NavbarLoggedIn v-if="isLoggedIn && !isAuthPage" />
    <WebHeader v-else :isAuthPage="isAuthPage" />

    <!-- 2. Bungkus router-view dengan div flex-grow-1 -->
    <!-- Ini akan mendorong footer ke bawah jika kontennya sedikit -->
    <div class="flex-grow-1">
      <router-view></router-view>
    </div>

    <!-- Bagian Footer -->
    <WebFooter/>
  </div>
</template>

<script>
import { computed, ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import WebHeader from './components/Headers/WebHeader.vue';
import NavbarLoggedIn from './components/Headers/NavbarLoggedIn.vue';
import WebFooter from './components/Footer/WebFooter.vue';

export default {
  components: {
    WebHeader,
    NavbarLoggedIn,
    WebFooter
  },
  setup() {
    const route = useRoute()
    const isLoggedIn = ref(false)
    
    const isAuthPage = computed(() => {
      return route.path === '/login' ||  route.path === '/signup'
    })
    
    onMounted(() => {
      const user = localStorage.getItem('user')
      isLoggedIn.value = !!user
    })
    
    return { isAuthPage, isLoggedIn }
  }
}
</script>
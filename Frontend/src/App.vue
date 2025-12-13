<template>
  <div id="app-container">
    <NavbarLoggedIn v-if="isAuthenticated && !isAuthPage" />
    <WebHeader v-else :isAuthPage="isAuthPage" />
    
    <!-- Konten utama yang akan mengisi ruang kosong -->
    <main class="flex-grow-1">
      <router-view></router-view>
    </main>
    
    <WebFooter/>
  </div>
</template>

<script>
import { computed, ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import WebHeader from './components/Headers/WebHeader.vue';
import NavbarLoggedIn from './components/Headers/NavbarLoggedIn.vue';
import WebFooter from './components/Footer/WebFooter.vue';
import { useAuth } from './stores/auth'; // <-- IMPORT useAuth

export default {
  components: {
    WebHeader,
    NavbarLoggedIn,
    WebFooter
  },
  setup() {
    const route = useRoute()
    const { isAuthenticated, checkAuth } = useAuth(); 
    
    const isAuthPage = computed(() => {
      return route.path === '/login' ||  route.path === '/signup'
    })
    
    onMounted(() => {
      checkAuth(); 
    })
    
    return { isAuthPage, isAuthenticated } 
  }
}
</script>

<style>
#app-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.flex-grow-1 {
  flex-grow: 1;
}
</style>
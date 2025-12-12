<template>
  <div id="app-container">
    <NavbarLoggedIn v-if="isLoggedIn && !isAuthPage" />
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
      // Check if user is logged in from localStorage
      const user = localStorage.getItem('user')
      isLoggedIn.value = !!user
    })
    
    return { isAuthPage, isLoggedIn }
  }
}
</script>

<style>
#app-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh; /* Pastikan container mengisi seluruh tinggi viewport */
}

.flex-grow-1 {
  flex-grow: 1;
}
</style>
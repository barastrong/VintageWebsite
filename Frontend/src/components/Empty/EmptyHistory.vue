

<template>
  <div class="container d-flex align-items-center justify-content-center">
    <div class="text-center py-5">
      <!-- Shopping Bag Icon -->
      <div class="">
        <!-- SVG Icon: Dikonversi langsung dari JSX ke template HTML/SVG -->
        <svg 
          width="120" 
          height="120" 
          viewBox="0 0 120 120" 
          fill="none" 
          xmlns="http://www.w3.org/2000/svg" 
          class="mx-auto"
        >
          <!-- Lock handle -->
          <path 
            d="M45 35 C45 25 50 20 60 20 C70 20 75 25 75 35" 
            stroke="#8BC4C9" 
            stroke-width="6" 
            fill="none"
            stroke-linecap="round"
          />
          
          <!-- Lock body -->
          <rect 
            x="35" 
            y="40" 
            width="50" 
            height="50" 
            rx="8" 
            fill="#17a2b8"
          />
          
          <!-- Lock dots/eyes -->
          <circle cx="50" cy="60" r="4" fill="white"/>
          <circle cx="70" cy="60" r="4" fill="white"/>
        </svg>
      </div>

      <!-- Message -->
      <h3 class="fw-bold mb-3">No orders yet</h3>
      <p class="text-muted mb-4" style="max-width: 400px; margin: 0 auto;">
        When you buy an item, your order about it will appear here.
      </p>

      <!-- Shop Now Button -->
      <button 
        @click="handleShopNow"
        class="btn btn-lg text-white fw-semibold px-5"
        :style="{ backgroundColor: '#17a2b8', border: 'none' }"
      >
        Shop now
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter()

const handleShopNow = () => {
  console.log('Shop now clicked');
  router.push('/shop')
};
</script>

<style scoped>
/* Menambahkan gaya untuk min-vh-100 karena ini adalah kelas non-default Bootstrap */
.min-vh-100 {
  min-height: 100vh;
}
</style>
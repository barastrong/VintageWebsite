<template>
  <div class="container d-flex align-items-center justify-content-center">
    <div class="text-center py-5">
      <!-- Folder with Heart Icon -->
      <div class="mb-4">
        <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto">
          <!-- Folder tab -->
            <path 
            d="M20 30 L50 30 L60 10 L100 10 C105 10 110 15 110 30 L110 35 L20 35 Z" 
            fill="#8BC4C9"
            />
          
          <!-- Folder body -->
          <rect 
            x="15" 
            y="35" 
            width="90" 
            height="55" 
            rx="5" 
            fill="#17a2b8"
          />
          
          <!-- Heart icon -->
          <path 
            d="M60 55 C60 55 50 48 45 48 C40 48 37 51 37 55 C37 62 45 70 60 80 C75 70 83 62 83 55 C83 51 80 48 75 48 C70 48 60 55 60 55 Z" 
            fill="white"
          />
        </svg>
      </div>

      <!-- Message -->
      <h3 class="fw-bold mb-3">No favorite items yet</h3>
      <p class="text-muted mb-4" style="max-width: 350px; margin: 0 auto">
        When add item to favorite, the item will appear on the favorite list.
      </p>

      <!-- Find Products Button -->
      <button 
        @click="handleFindProducts"
        class="btn btn-lg text-white fw-semibold px-5"
        style="background-color: #17a2b8; border: none"
      >
        Find Products
      </button>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const handleFindProducts = () => {
  router.push('/shop')
}
</script>
<template>
  <div class="text-center py-5">
    
    <!-- Shopping Cart Icon -->
    <div>
      <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto">
        <!-- Cart handle -->
        <path 
          d="M20 15 L25 15 C27 15 28 16 28.5 18 L45 65 C45.5 67 47 68 49 68 L85 68 C87 68 88.5 67 89 65 L100 35 C100.5 33 99.5 31 97.5 31 L35 31" 
          stroke="#8BC4C9" 
          stroke-width="5" 
          fill="none"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
        
        <!-- Cart body -->
        <rect x="30" y="38" width="60" height="35" rx="4" fill="#17a2b8"/>
        
        <!-- Cart top part -->
        <rect x="30" y="30" width="60" height="8" rx="2" fill="#8BC4C9"/>
        
        <!-- Wheel 1 -->
        <circle cx="45" cy="85" r="8" fill="#17a2b8"/>
        <circle cx="45" cy="85" r="5" fill="white"/>
        
        <!-- Wheel 2 -->
        <circle cx="75" cy="85" r="8" fill="#17a2b8"/>
        <circle cx="75" cy="85" r="5" fill="white"/>
      </svg>
    </div>

    <!-- Message -->
    <h3 class="fw-bold mb-3">Your cart still empty</h3>
    <p class="text-muted mb-4" style="max-width: 350px; margin: 0 auto">
      Find your favorite items and add to cart before check out.
    </p>

    <!-- Find Products Button -->
    <BaseButton 
      @click="handleFindProducts"
      variant="primary"
      custom-class="btn-lg fw-semibold px-5"
      custom-style="background-color: #17a2b8; border-color: #17a2b8"
    >
      Find Products
    </BaseButton>

  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import BaseButton from '@/components/ui/BaseButton.vue'

const router = useRouter()

const handleFindProducts = () => {
  router.push('/shop')
}
</script>

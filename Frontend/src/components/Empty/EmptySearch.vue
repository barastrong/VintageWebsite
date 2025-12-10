<template>
  <!-- Empty State -->
  <div class="text-center py-5 my-5">
      <!-- Shopping Bag Icon -->
      <div class="mb-4">
        <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto">
          <circle cx="60" cy="60" r="60" fill="#E8F8F9"/>
          
          <!-- Bag body -->
          <path d="M35 45 C35 42 37 40 40 40 L80 40 C83 40 85 42 85 45 L80 85 C80 88 78 90 75 90 L45 90 C42 90 40 88 40 85 L35 45 Z" fill="#17a2b8"/>
          
          <!-- Bag handle -->
          <path d="M47 40 C47 32 52 27 60 27 C68 27 73 32 73 40" stroke="#17a2b8" stroke-width="4" fill="none" stroke-linecap="round"/>
          
          <!-- Lock circle -->
          <circle cx="60" cy="65" r="12" fill="#0F8C9C"/>
          
          <!-- X mark inside lock -->
          <path d="M55 60 L65 70 M65 60 L55 70" stroke="white" stroke-width="3" stroke-linecap="round"/>
        </svg>
      </div>

      <!-- Message -->
      <h3 class="fw-bold mb-3">Product not found</h3>
      <p class="text-muted mb-4" style="max-width: 400px; margin: 0 auto">
        We cannot find what you looking for, try to use other keywords or reset keyword.
      </p>

      <!-- Reset Button -->
      <button 
        @click="handleResetKeyword"
        class="btn btn-lg text-white fw-semibold px-5"
        style="background-color: #17a2b8; border: none"
      >
        Reset Keyword
      </button>
    </div>
</template>

<script setup>
defineProps({
  searchQuery: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['reset', 'removeFilter'])

const handleResetKeyword = () => {
  emit('reset')
}

const removeFilter = () => {
  emit('removeFilter')
}
</script>
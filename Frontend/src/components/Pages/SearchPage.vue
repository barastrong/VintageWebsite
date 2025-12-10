<template>
  <div class="container py-4" style="min-height: 80vh">
    <!-- Header with Search Query -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold mb-0">Items</h2>
      
      <div v-if="searchQuery" class="d-flex align-items-center">
        <span 
          class="badge bg-light text-dark px-3 py-2 d-flex align-items-center gap-2"
          style="font-size: 0.9rem; font-weight: normal"
        >
          "{{ searchQuery }}"
          <button 
            class="btn-close" 
            style="font-size: 0.7rem"
            @click="clearSearch"
            aria-label="Close"
          ></button>
        </span>
      </div>
    </div>

    <hr class="mt-4" style="color: gray;">

    <!-- Loading State -->
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <!-- No Results -->
    <EmptySearch 
      v-if="products.length === 0 && searchQuery" 
      :searchQuery="searchQuery"
      @reset="clearSearch"
      @removeFilter="clearSearch"
    />

    <!-- Products Grid -->
    <div v-else class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-4">
      <ProductCard 
        v-for="product in products" 
        :key="product.id" 
        :product="product" 
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import ProductCard from '@/components/Card/ProductCard.vue'
import EmptySearch from '../Empty/EmptySearch.vue'

const route = useRoute()
const router = useRouter()
const searchQuery = ref('')
const products = ref([])
const loading = ref(false)

const searchProducts = async (query) => {
  if (!query.trim()) {
    products.value = []
    return
  }
  
  loading.value = true
  try {
    const response = await fetch(`http://localhost/FinalTest/Backend/search_products.php?q=${encodeURIComponent(query)}`)
    const data = await response.json()
    
    if (data.success) {
      products.value = data.data
    }
  } catch (error) {
    console.error('Search error:', error)
    products.value = []
  } finally {
    loading.value = false
  }
}

const clearSearch = () => {
  // Emit event to clear search in header
  window.dispatchEvent(new CustomEvent('clearSearch'))
  router.push('/')
}

onMounted(() => {
  searchQuery.value = route.query.q || ''
  if (searchQuery.value) {
    searchProducts(searchQuery.value)
  }
})

watch(() => route.query.q, (newQuery) => {
  searchQuery.value = newQuery || ''
  if (searchQuery.value) {
    searchProducts(searchQuery.value)
  } else {
    products.value = []
  }
})
</script>
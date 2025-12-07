<template>
  <div class="container-fluid py-5">
    <div class="mx-auto" style="max-width: 1700px; padding: 0 2rem">
      <h2 class="fw-semibold mb-4">Items</h2>
      <hr style="color: #A6A6A6;">
      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-4 mt-2">
        <ProductCard 
          v-for="product in products" 
          :key="product.id" 
          :product="product" 
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import ProductCard from '@/components/Card/ProductCard.vue'

const products = ref([])

const fetchProducts = async () => {
  try {
    const response = await fetch('http://localhost/FinalTest/Backend/get_products.php?type=all')
    const data = await response.json()
    if (data.success) {
      products.value = data.data
    }
  } catch (error) {
    console.error('Error fetching products:', error)
  }
}

onMounted(() => {
  document.title = 'Shop - Vintage'
  fetchProducts()
})
</script>

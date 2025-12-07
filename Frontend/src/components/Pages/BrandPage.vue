<template>
  <div class="container-fluid py-5">
    <div class="mx-auto" style="max-width: 1700px; padding: 0 2rem">
      <h2 class="fw-semibold mb-4">{{ brandName }} Items</h2>
      
      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-4">
        <ProductCard 
          v-for="product in products" 
          :key="product.id" 
          :product="product" 
        />
      </div>
      
      <div v-if="products.length === 0" class="text-center py-5">
        <p class="text-muted">Tidak ada produk untuk brand ini</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import ProductCard from '@/components/Product/ProductCard.vue'

const route = useRoute()
const products = ref([])
const brandName = ref('')

const fetchProductsByBrand = async () => {
  try {
    const brandId = route.params.id
    const response = await fetch(`http://localhost/FinalTest/Backend/get_products_by_brand.php?brand_id=${brandId}`)
    const data = await response.json()
    if (data.success) {
      products.value = data.data
      brandName.value = data.brand_name || 'Brand'
    }
  } catch (error) {
    console.error('Error fetching products:', error)
  }
}

onMounted(() => {
  document.title = `${brandName.value} - Vintage`
  fetchProductsByBrand()
})
</script>

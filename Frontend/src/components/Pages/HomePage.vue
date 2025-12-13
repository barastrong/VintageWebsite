<template>
  <div>
    <!-- Hero Section -->
    <div 
      class="position-relative" 
      style="height: 750px; overflow: hidden"
    >
      <img 
        src="@/assets/HeaderBanner.jpg" 
        alt="Hero Banner" 
        class="position-absolute w-100 h-100"
        style="object-fit:cover; object-position: center"
      />
      <div class="position-absolute w-100 h-100 d-flex align-items-center" style="background: rgba(0,0,0,0.2)">
        <div class="container-fluid px-5">
          <div class="row">
            <div class="col-md-4 col-lg-3" style="margin-left: 5rem">
              <div class="bg-white p-4 shadow-sm" style="border-radius: 8px">
                <h2 class="fw-bold mb-3" style="font-size: 1.75rem">
                  Ready to declutter<br />you closet?
                </h2>
                <router-link to="/shop" style="text-decoration: none">
                  <BaseButton 
                    variant="primary"
                    custom-class="w-100 fw-semibold"
                    custom-style="background-color: #009499; border: none"
                  >
                    Shop Now
                  </BaseButton>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Popular Items Section -->
    <div class="container-fluid py-5">
      <div class="mx-auto" style="max-width: 1700px; padding: 0 2rem">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-semibold mb-0">Popular items</h3>
        <router-link to="/shop" class="text-decoration-none" style="color: #009499">
          See all
        </router-link>
      </div>

      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-4 mb-4">
        <ProductCard 
          v-for="product in popularItems" 
          :key="product.id" 
          :product="product" 
        />
        
        <!-- See All Card -->
        <router-link to="/shop" style="text-decoration: none">
        <div class="col">
          <div 
            class="card h-100 border-0 d-flex align-items-center justify-content-center"
            style="background-color: #E8F8F9; min-height: 300px; border-radius: 8px; cursor: pointer"
          >
            <div class="text-center">
              <a href="#" class="text-decoration-none" style="color: #009499">
                <div class="fw-semibold">See All</div>
                <div class="fw-semibold">Product</div>
              </a>
            </div>
          </div>
        </div>
        </router-link>
      </div>

      <!-- Shop by Brand Section -->
      <div class="mb-5">
        <h3 class="fw-semibold mb-4">Shop by brand</h3>
        <div class="d-flex flex-wrap gap-2">
          <router-link
            v-for="brand in brands"
            :key="brand.id"
            :to="`/brand/${brand.id}`"
            class="btn btn-outline-secondary rounded-3 px-4 py-2"
            style="font-size: 0.9rem; text-decoration: none"
          >
            {{ brand.name }}
          </router-link>
        </div>
      </div>

      <!-- New Product Section -->
      <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="fw-semibold mb-0">New Product</h3>
          <router-link to="/shop" class="text-decoration-none" style="color: #009499">
            See all
          </router-link>
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-4">
          <ProductCard 
            v-for="product in newProducts" 
            :key="product.id" 
            :product="product" 
          />
          
          <!-- See All Card -->
        <router-link to="/shop" style="text-decoration: none">
        <div class="col">
          <div 
            class="card h-100 border-0 d-flex align-items-center justify-content-center"
            style="background-color: #E8F8F9; min-height: 300px; border-radius: 8px; cursor: pointer"
          >
            <div class="text-center">
              <a href="#" class="text-decoration-none" style="color: #009499">
                <div class="fw-semibold">See All</div>
                <div class="fw-semibold">Product</div>
              </a>
            </div>
          </div>
        </div>
        </router-link>
        </div>
      </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import BaseButton from '@/components/ui/BaseButton.vue'
import ProductCard from '@/components/Card/ProductCard.vue'

const popularItems = ref([])
const newProducts = ref([])
const brands = ref([])
const BASE_URL = 'http://localhost/FinalTest/Backend'

onMounted(() => {
  document.title = 'Discover Your Timeless Style'
  fetchPopularItems()
  fetchProducts()
  fetchBrands()
})

const fetchPopularItems = async () => {
  try {
    const response = await fetch(`${BASE_URL}/get_popular.php`)
    const data = await response.json()
    if (data.success) {
      popularItems.value = data.data
    }
  } catch (error) {
    console.error('Error fetching popular items:', error)
  }
}

const fetchProducts = async () => {
  try {
    const response = await fetch(`${BASE_URL}/get_products.php`)
    const data = await response.json()
    if (data.success) {
      newProducts.value = data.data.slice(0, 5)
    }
  } catch (error) {
    console.error('Error fetching products:', error)
  }
}

const fetchBrands = async () => {
  try {
    const response = await fetch(`${BASE_URL}/get_brand.php`)
    const data = await response.json()
    if (data.success) {
      brands.value = data.data
    }
  } catch (error) {
    console.error('Error fetching brands:', error)
  }
}
</script>
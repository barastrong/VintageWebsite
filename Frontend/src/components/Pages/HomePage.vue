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
                    custom-style="background-color: #0D6B6F; border: none"
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
        <a href="#" class="text-decoration-none" style="color: #17a2b8">
          See all
        </a>
      </div>

      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-4 mb-4">
        <ProductCard 
          v-for="product in popularItems" 
          :key="product.id" 
          :product="product" 
        />
        
        <!-- See All Card -->
        <div class="col">
          <div 
            class="card h-100 border-0 d-flex align-items-center justify-content-center"
            style="background-color: #E8F8F9; min-height: 300px; border-radius: 8px; cursor: pointer"
          >
            <div class="text-center">
              <a href="#" class="text-decoration-none" style="color: #17a2b8">
                <div class="fw-semibold">See All</div>
                <div class="fw-semibold">Product</div>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Shop by Brand Section -->
      <div class="mb-5 px-3">
        <h3 class="fw-semibold mb-4">Shop by brand</h3>
        <div class="d-flex flex-wrap gap-2">
          <button
            v-for="(brand, index) in brands"
            :key="index"
            class="btn btn-outline-secondary rounded-pill px-4 py-2"
            style="font-size: 0.9rem"
          >
            {{ brand }}
          </button>
        </div>
      </div>

      <!-- New Product Section -->
      <div class="px-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="fw-semibold mb-0">New Product</h3>
          <a href="#" class="text-decoration-none" style="color: #17a2b8">
            See all
          </a>
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-4">
          <ProductCard 
            v-for="product in newProducts" 
            :key="product.id" 
            :product="product" 
          />
          
          <!-- See All Card -->
          <div class="col">
            <div 
              class="card h-100 border-0 d-flex align-items-center justify-content-center"
              style="background-color: #E8F8F9; min-height: 300px; border-radius: 8px; cursor: pointer"
            >
              <div class="text-center">
                <a href="#" class="text-decoration-none" style="color: #17a2b8">
                  <div class="fw-semibold">See All</div>
                  <div class="fw-semibold">New Product</div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import BaseButton from '@/components/ui/BaseButton.vue'
import ProductCard from '@/components/Product/ProductCard.vue'

const popularItems = ref([
  { id: 1, name: 'Vintage chicago cubs white crewneck', price: 'Rp200.000', size: '8 / M', likes: 12, image: '#E8E8E8' },
  { id: 2, name: 'Red Crewneck', price: 'Rp200.000', size: '8 / M', likes: 12, image: '#1C1C1C' },
  { id: 3, name: 'Necklace', price: 'Rp200.000', size: '8 / M', likes: 12, image: '#4A4A4A' },
  { id: 4, name: 'Necklace', price: 'Rp200.000', size: '8 / M', likes: 12, image: '#6BAED6' },
  { id: 5, name: 'Necklace', price: 'Rp200.000', size: '8 / M', likes: 12, image: '#FFD700' }
])

const newProducts = ref([
  { id: 1, name: 'Vintage chicago cubs white crewneck', price: 'Rp200.000', size: '8 / M', likes: 12, image: '#FFD700' },
  { id: 2, name: 'Red Crewneck', price: 'Rp200.000', size: '8 / M', likes: 12, image: '#1C1C1C' },
  { id: 3, name: 'Necklace', price: 'Rp200.000', size: '8 / M', likes: 12, image: '#0F4C4C' },
  { id: 4, name: 'Necklace', price: 'Rp200.000', size: '8 / M', likes: 12, image: '#E8E8E8' },
  { id: 5, name: 'Necklace', price: 'Rp200.000', size: '8 / M', likes: 12, image: '#7B68EE' }
])

const brands = ref([
  'Vans', 'Bohoo', 'Mango', 'Reebok', 'Converse', 
  'Sandro', 'Nike', 'Adidas', 'Dior', 'Puma', 
  'Zara', 'Bershka', 'American Eagle'
])
</script>

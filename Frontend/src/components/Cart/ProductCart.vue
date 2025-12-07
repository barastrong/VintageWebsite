<template>
  <div class="container py-4">
    <div class="row g-4">
      <!-- Left Side - Cart Items -->
      <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="fw-bold mb-0">Cart</h2>
          <span class="text-muted fw-semibold" style="font-size: 1.1rem">{{ cartItems.length }} Items</span>
        </div>

        <!-- Shipping Address -->
        <div class="bg-light p-3 rounded mb-3 d-flex align-items-center mt-8">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-muted me-2" viewBox="0 0 16 16">
            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
          </svg>
          <span class="text-muted">Shipping to <strong>Kuta, Badung</strong></span>
        </div>

        <!-- Cart Items List -->
        <div class="d-flex flex-column gap-3">
          <CartCard 
            v-for="item in cartItems" 
            :key="item.id" 
            :product="item"
            @update-quantity="handleUpdateQuantity"
            @remove="handleRemove"
          />
        </div>
      </div>

      <!-- Right Side - Order Summary -->
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="fw-bold mb-0">Order Summary</h5>
              <span class="fw-bold mb-0" style="font-size: 1.25rem">Rp{{ totalPrice.toLocaleString('id-ID') }}</span>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
              <span class="text-muted">{{ cartItems.length }} Items</span>
              <span class="text-muted small">Not include shipping fee</span>
            </div>
            <hr style="color:grey;">
            <button 
              class="btn btn-lg text-white w-100 fw-semibold"
              style="background-color: #009499; border: none"
            >
              Checkout({{ cartItems.length }})
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Other Products Section -->
    <div class="mt-5">
      <h3 class="fw-semibold mb-4">Other Product</h3>
      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3" style="max-width: 66.666%">
        <ProductCard 
          v-for="product in otherProducts.slice(0, 8)" 
          :key="product.id" 
          :product="product" 
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import CartCard from '@/components/Card/CartCard.vue'
import ProductCard from '@/components/Card/ProductCard.vue'

const cartItems = ref([
  { id: 1, name: 'White crewneck', size: '8 / M', price: 'Rp200.000', quantity: 1, image: '#E8E8E8' },
  { id: 2, name: 'Red crewneck', size: '8 / M', price: 'Rp200.000', quantity: 1, image: '#FF6B6B' },
  { id: 3, name: 'Blue crewneck', size: '8 / M', price: 'Rp200.000', quantity: 1, image: '#6BAED6' },
  { id: 4, name: 'Black crewneck', size: '8 / M', price: 'Rp200.000', quantity: 1, image: '#1C1C1C' }
])

const otherProducts = ref([])

const totalPrice = computed(() => {
  return cartItems.value.reduce((sum, item) => {
    const price = parseInt(item.price.replace(/\D/g, ''))
    return sum + (price * item.quantity)
  }, 0)
})

const handleUpdateQuantity = ({ productId, quantity }) => {
  const item = cartItems.value.find(i => i.id === productId)
  if (item) {
    item.quantity = quantity
  }
}

const handleRemove = (productId) => {
  cartItems.value = cartItems.value.filter(item => item.id !== productId)
}

const fetchProducts = async () => {
  try {
    const response = await fetch('http://localhost/FinalTest/Backend/get_products.php')
    const data = await response.json()
    if (data.success) {
      otherProducts.value = data.data
    }
  } catch (error) {
    console.error('Error fetching products:', error)
  }
}

onMounted(() => {
  fetchProducts()
})
</script>

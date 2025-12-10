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
            v-for="item in displayedCartItems" 
            :key="item.id" 
            :product="item"
            @update-quantity="handleUpdateQuantity"
            @remove="handleRemove"
          />
          
          <!-- Show All Button -->
          <button 
            v-if="cartItems.length > 4 && !showAllItems"
            @click="showAllItems = true"
            class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-2"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
            </svg>
            Show All Items ({{ cartItems.length }})
          </button>
          
          <!-- Show Less Button -->
          <button 
            v-if="showAllItems && cartItems.length > 4"
            @click="showAllItems = false"
            class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-2"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
            </svg>
            Show Less
          </button>
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
import { useRoute } from 'vue-router'
import CartCard from '@/components/Card/CartCard.vue'
import ProductCard from '@/components/Card/ProductCard.vue'

const route = useRoute()

const cartItems = ref([])

const otherProducts = ref([])
const showAllItems = ref(false)

const displayedCartItems = computed(() => {
  return showAllItems.value ? cartItems.value : cartItems.value.slice(0, 4)
})

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

const handleRemove = async (cartId) => {
  try {
    const response = await fetch('http://localhost/FinalTest/Backend/remove_cart.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        cart_id: cartId
      })
    })
    
    const data = await response.json()
    
    if (data.success) {
      cartItems.value = cartItems.value.filter(item => item.id !== cartId)
      // Update cart count
      const { useCart } = await import('@/stores/cart')
      const { fetchCartCount } = useCart()
      fetchCartCount()
    }
  } catch (error) {
    console.error('Error removing cart item:', error)
  }
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

const fetchCartItems = async () => {
  try {
    const userId = route.params.id
    const response = await fetch(`http://localhost/FinalTest/Backend/get_cart.php?user_id=${userId}`)
    const data = await response.json()
    if (data.success) {
      cartItems.value = data.data
    }
  } catch (error) {
    console.error('Error fetching cart items:', error)
  }
}

onMounted(() => {
  fetchProducts()
  fetchCartItems()
})
</script>

<template>
  <div class="container py-4">
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-info" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="mt-2 text-muted">Fetching order details...</p>
    </div>

    <div v-else-if="!orderItems.length" class="text-center py-5">
      <p class="text-muted">No pending order found.</p>
    </div>

    <div v-else class="row g-4">
      <div class="col-lg-8">
        <OrderItems :orderItems="orderItems" />
        <ProductOrder />
      </div>

      <div class="col-lg-4">
        <div class="card border-0 shadow-sm sticky-top" style="top: 20px">
          <div class="card-body p-4">
            <h5 class="fw-semibold mb-4">Order summary</h5>
            
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted">Order</span>
              <span class="fw-semibold">Rp{{ orderTotal.toLocaleString('id-ID') }}</span>
            </div>
            
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted">Protection fee</span>
              <span class="fw-semibold">Rp{{ protectionFee.toLocaleString('id-ID') }}</span>
            </div>
            
            <div class="d-flex justify-content-between mb-4">
              <span class="text-muted">Shipping</span>
              <span class="fw-semibold">Rp{{ shippingFee.toLocaleString('id-ID') }}</span>
            </div>
            
            <hr class="my-3" />
            
            <div class="d-flex justify-content-between mb-4">
              <span class="fw-bold">Total to pay</span>
              <span class="fw-bold fs-5">Rp{{ totalToPay.toLocaleString('id-ID') }}</span>
            </div>

            <BaseButton 
              @click="handleOrderNow"
              variant="primary"
              custom-class="btn-lg w-100 fw-semibold"
              custom-style="background-color: #17a2b8; border-color: #17a2b8"
            >
              Order Now
            </BaseButton>
          </div>
        </div>
      </div>
    </div>

    <!-- Success Order Modal DIKEMBALIKAN -->
    <div v-if="showSuccessModal" class="position-fixed top-0 start-0 w-100 h-100" style="z-index: 9999; background-color: rgba(0,0,0,0.5)">
      <SuccessOrder @close="showSuccessModal = false" />
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import OrderItems from '../Order/OrderItems.vue'
import ProductOrder from '../Order/ProductOrder.vue'
import BaseButton from '../ui/BaseButton.vue'
import SuccessOrder from '../SuccessModal/SuccessOrder.vue' // Menggunakan nama yang benar

const route = useRoute()
const router = useRouter()
const BASE_URL = 'http://localhost/FinalTest/Backend' 
const IMAGE_BASE_URL = 'http://localhost/FinalTest/Backend/'

const loading = ref(true)
const orderItems = ref([])
const orderTotal = ref(0)
const protectionFee = ref(0)
const shippingFee = ref(0)
const showSuccessModal = ref(false) // State untuk Modal

const toLocaleString = (price) => {
  if (typeof price !== 'number' || isNaN(price)) return 0
  return price
}

const totalToPay = computed(() => {
  return toLocaleString(orderTotal.value) + toLocaleString(protectionFee.value) + toLocaleString(shippingFee.value)
})

const fetchOrderDetails = async () => {
  loading.value = true
  const userId = localStorage.getItem('id')
  
  if (!userId) {
    loading.value = false
    return
  }

  try {
    // Menggunakan get_order.php sesuai kode Anda sebelumnya
    const response = await fetch(`${BASE_URL}/get_order.php?user_id=${userId}`) 
    const data = await response.json()

    if (data.success && data.data.length > 0) {
      const pendingOrders = data.data
      
      orderItems.value = pendingOrders.map(item => {
        const imageUrl = item.product_image && !item.product_image.startsWith('http') 
          ? IMAGE_BASE_URL + item.product_image 
          : item.product_image || '#E8E8E8'

        return {
          id: item.id,
          name: item.name,
          size: item.product_size || 'N/A', 
          price: parseInt(item.price) / parseInt(item.quantity), 
          quantity: parseInt(item.quantity),
          image: imageUrl
        }
      })
      
      const firstItem = pendingOrders[0] 
      
      orderTotal.value = pendingOrders.reduce((sum, item) => sum + parseInt(item.price), 0)
      protectionFee.value = parseInt(firstItem.protection_price) 
      shippingFee.value = parseInt(firstItem.shipping_price)

    } else {
      orderItems.value = []
    }
  } catch (error) {
    console.error('Error fetching order details:', error)
  } finally {
    loading.value = false
  }
}

const handleOrderNow = async () => {
  const userId = localStorage.getItem('id')
  if (!userId) return

  try {
    const response = await fetch(`${BASE_URL}/confirm_order.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        user_id: userId
      })
    })
    
    const data = await response.json()

    if (data.success) {
      console.log('Order confirmed. Showing success modal.');
      
      // 1. Kosongkan data di frontend (menghilangkan tampilan Order Page)
      orderItems.value = [] 
      
      // 2. Tampilkan modal sukses
      showSuccessModal.value = true 
      
    } else {
      console.error('Order confirmation failed:', data.message)
    }

  } catch (error) {
    console.error('Network error during order confirmation:', error)
  }
}

onMounted(() => {
  fetchOrderDetails()
})
</script>
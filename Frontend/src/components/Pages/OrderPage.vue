<template>
  <div class="container py-4">
    <div class="row g-4">
      <!-- Left Side - Order Details -->
      <div class="col-lg-8">
        <OrderItems :orderItems="orderItems" />
        <ProductOrder />
      </div>

      <!-- Right Side - Order Summary -->
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

    <!-- Success Order Modal -->
    <div v-if="showSuccessModal" class="position-fixed top-0 start-0 w-100 h-100" style="z-index: 9999; background-color: rgba(0,0,0,0.5)">
      <SuccessOrder @close="showSuccessModal = false" />
    </div>
  </div>
</template>

<script>
import OrderItems from '../Order/OrderItems.vue'
import ProductOrder from '../Order/ProductOrder.vue'
import SuccessOrder from '../SuccessModal/SuccessOrder.vue'
import BaseButton from '../ui/BaseButton.vue'

export default {
  name: 'OrderPage',
  components: {
    OrderItems,
    ProductOrder,
    SuccessOrder,
    BaseButton
  },
  data() {
    return {
      orderItems: [
        { id: 1, name: 'White crewneck', size: '8 / M', price: 200000, quantity: 1, image: '#E8E8E8' },
        { id: 2, name: 'White crewneck', size: '8 / M', price: 200000, quantity: 1, image: '#E8E8E8' }
      ],
      orderTotal: 400000,
      protectionFee: 20000,
      shippingFee: 15000,
      showSuccessModal: false
    }
  },
  computed: {
    totalToPay() {
      return this.orderTotal + this.protectionFee + this.shippingFee
    }
  },
  methods: {
    handleOrderNow() {
      console.log('Processing order...')
      this.showSuccessModal = true
    }
  }
}
</script>
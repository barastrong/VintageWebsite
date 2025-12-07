<template>
  <div class="card border-0 shadow-sm">
    <div class="card-body p-3">
      <div class="row align-items-center g-3">
        <!-- Product Image -->
        <div class="col-auto">
          <div 
            class="rounded"
            :style="{ 
              backgroundColor: product.image || '#E8E8E8',
              width: '80px',
              height: '80px',
              backgroundImage: product.image && product.image.startsWith('http') ? `url(${product.image})` : 'none',
              backgroundSize: 'cover',
              backgroundPosition: 'center'
            }"
          />
        </div>

        <!-- Product Details -->
        <div class="col">
          <h6 class="mb-1 fw-semibold">{{ product.name }}</h6>
          <p class="text-muted mb-2 small">{{ product.size }}</p>
          <p class="fw-bold mb-0">{{ product.price }}</p>
        </div>

        <!-- Quantity Controls -->
        <div class="col-auto">
          <div class="d-flex align-items-center gap-2 border rounded p-1">
            <button 
              class="btn btn-sm border-0 d-flex align-items-center justify-content-center"
              @click="updateQuantity(-1)"
              style="width: 32px; height: 32px; padding: 0"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
              </svg>
            </button>
            
            <span class="fw-semibold" style="min-width: 30px; text-align: center">
              {{ quantity }}
            </span>
            
            <button 
              class="btn btn-sm border-0 d-flex align-items-center justify-content-center"
              @click="updateQuantity(1)"
              style="width: 32px; height: 32px; padding: 0"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Remove Button -->
      <div class="mt-3">
        <button 
          class="btn btn-link text-danger p-0 text-decoration-none"
          @click="handleRemove"
          style="font-size: 0.9rem"
        >
          Remove
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  product: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['update-quantity', 'remove'])

const quantity = ref(1)

const updateQuantity = (delta) => {
  quantity.value = Math.max(1, quantity.value + delta)
  emit('update-quantity', { productId: props.product.id, quantity: quantity.value })
}

const handleRemove = () => {
  emit('remove', props.product.id)
}
</script>

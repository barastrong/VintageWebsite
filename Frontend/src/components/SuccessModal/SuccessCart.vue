<template>
  <div v-if="isVisible" class="modal-overlay" @click.self="handleContinueShopping">
    <div class="card border-0 shadow-sm text-center" style="max-width: 500px; width: 100%">
      <div class="card-body p-5">
        <div class="mb-4 position-relative" style="height: 150px ; width: 150px; margin: 0 auto">
          <img 
            src="@/assets/SuccessCart.gif" 
            alt="Success Cart"
            class="mx-auto d-block"
            style="width: 120px; height: 120px; object-fit: contain"
          />
        </div>

        <h2 class="fw-bold mb-3" style="font-size: 1.75rem; font-family: 'Baskito - Typography', sans-serif">
          Product successfully added to cart
        </h2>
        
        <p class="text-muted mb-4" style="font-size: 1rem; line-height: 1.6; font-family: 'Baskito - Typography', sans-serif">
          "{{ productName }}" successfully added to cart. Check now on the cart or continue shopping.
        </p>

        <div class="d-grid gap-2">
          <BaseButton 
            @click="handleContinueShopping"
            variant="outline"
            custom-class="btn-lg fw-semibold"
            custom-style="border-color: #009499; color: #009499; border-width: 2px; font-family: 'Baskito - Typography', sans-serif"
          >
            Continue shopping
          </BaseButton>
          
          <BaseButton 
            @click="handleGoToCart"
            variant="primary"
            custom-class="btn-lg fw-semibold"
            custom-style="background-color: #009499; border-color: #009499; font-family: 'Baskito - Typography', sans-serif"
          >
            Go to cart
          </BaseButton>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import BaseButton from '@/components/ui/BaseButton.vue'

const props = defineProps({
  productName: {
    type: String,
    default: 'Product'
  }
})

const emit = defineEmits(['close'])
const router = useRouter()
const isVisible = ref(true)

const handleContinueShopping = () => {
  isVisible.value = false
  emit('close')
}

const handleGoToCart = () => {
  isVisible.value = false
  emit('close')
  const user = JSON.parse(localStorage.getItem('user') || '{}')
  const userId = user.id || 1
  router.push(`/cart/${userId}`)
}
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}


</style>

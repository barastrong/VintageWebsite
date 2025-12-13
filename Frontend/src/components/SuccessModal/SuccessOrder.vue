<template>
  <div class="container min-vh-100 d-flex align-items-center justify-content-center" @click="closeModal">
    <div class="card border-0 shadow-sm text-center" style="max-width: 500px; width: 100%" @click.stop>
      <div class="card-body p-5">
        <!-- Success GIF -->
        <div class="mb-4" style="height: 150px">
          <img 
            src="@/assets/SuccessOrder.gif" 
            alt="Success Order" 
            class="mx-auto d-block"
            style="max-height: 100%; max-width: 100%"
          />
        </div>

        <!-- Success Message -->
        <h2 class="fw-bold mb-3" style="font-size: 1.5rem">
          Order #{{ orderNumber }}<br />placed successfully
        </h2>
        
        <p class="text-muted mb-4" style="font-size: 1rem; line-height: 1.6">
          Thank you for do online shopping at Vintage. You can track and see your order on transaction history menu.
        </p>

        <!-- Action Buttons -->
        <div class="d-grid gap-2">
          <BaseButton 
            @click="handleContinueShopping"
            variant="outline"
            custom-class="btn-lg fw-semibold"
            custom-style="border-color: #009499; color: #009499; border-width: 2px"
          >
            Continue shopping
          </BaseButton>
          
          <BaseButton 
            @click="handleGoToHistory"
            variant="primary"
            custom-class="btn-lg fw-semibold"
            custom-style="background-color: #009499; border-color: #009499"
          >
            Go to History Transaction
          </BaseButton>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import BaseButton from '@/components/ui/BaseButton.vue'

const router = useRouter()
const orderNumber = ref('ORD-89123-823')
const emit = defineEmits(['close'])

const closeModal = () => {
  emit('close')
}

const handleContinueShopping = () => {
  router.push('/shop')
  closeModal()
}

const handleGoToHistory = () => {
  console.log('Go to transaction history')
  router.push('/user/history')
  closeModal()
}

// Auto redirect after 5 seconds
onMounted(() => {
  setTimeout(() => {
    router.push('/')
    closeModal()
  }, 1000)
})
</script>
<template>
  <div class="container py-4">
    <div class="row g-4 mb-5">
      <div class="col-lg-8">
        <div 
          class="w-100 rounded mb-4"
          :style="{ 
            backgroundColor: isColorCode ? product.image : '#D4C4B0',
            backgroundImage: isImageUrl ? `url(${product.image})` : 'none',
            backgroundSize: 'cover',
            backgroundPosition: 'center',
            paddingTop: '75%',
            position: 'relative',
            overflow: 'hidden'
          }"
        />
        
        <div class="mt-5">
          <h2 class="fw-semibold mb-4" style="font-family: 'Quicksand', sans-serif;">Other Items</h2>
          <div class="row row-cols-2 row-cols-md-4 g-4" style="align-items: stretch">
            <div v-for="item in otherProducts.slice(0, 8)" :key="item.id" class="d-flex">
              <ProductCard :product="item" style="width: 100%" />
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="border rounded p-4">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <h1 class="mb-0" style="font-family: 'Quicksand', sans-serif; font-weight: 800">{{ product.price }}</h1>
          <button 
            @click="toggleLike"
            class="btn btn-link p-0"
            :class="isLiked ? 'text-danger' : 'text-dark'"
            style="text-decoration: none"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" :fill="isLiked ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"/>
            </svg>
          </button>
        </div>

        <h4 class="mb-3">{{ product.name }}</h4>

        <div class="d-flex gap-2 mb-4">
          <span class="badge bg-light text-dark px-3 py-2">{{ product.size }}</span>
          <span class="badge bg-light text-dark px-3 py-2">{{ product.condition }}</span>
          <span class="badge bg-light text-dark px-3 py-2">{{ product.location }}</span>
        </div>

        <hr class="my-4">

        <div class="mb-4">
          <h6 class="fw-semibold mb-2">Item Description</h6>
          <p class="text-muted" style="font-size: 0.95rem">
            {{ product.description }}
          </p>
        </div>

        <div class="mb-3">
          <div class="row mb-3">
            <div class="col-5 text-muted">Category</div>
            <div class="col-7">{{ product.category }}</div>
          </div>
          <div class="row mb-3">
            <div class="col-5 text-muted">Size</div>
            <div class="col-7">{{ product.size }}</div>
          </div>
          <div class="row mb-3">
            <div class="col-5 text-muted">Condition</div>
            <div class="col-7">{{ product.condition }}</div>
          </div>
          <div class="row mb-3">
            <div class="col-5 text-muted">Color</div>
            <div class="col-7">{{ product.color }}</div>
          </div>
          <div class="row mb-3">
            <div class="col-5 text-muted">Uploaded</div>
            <div class="col-7">{{ product.uploaded }}</div>
          </div>
          <div class="row mb-3">
            <div class="col-5 text-muted">Shipping</div>
            <div class="col-7">Rp20.000</div>
          </div>
        </div>

        <hr class="my-4">

        <div class="d-grid gap-2">
          <BaseButton 
            variant="primary"
            custom-class="w-100 py-3 fw-semibold"
            custom-style="background-color: #009499; border: none"
          >
            Buy Now
          </BaseButton>
          <BaseButton 
            variant="outline"
            custom-class="w-100 py-3 fw-semibold"
            custom-style="border-color: #009499; color: #009499"
            @click="handleAddToCart"
          >
            Add to Cart
          </BaseButton>
        </div>

        <hr class="my-4">

        <div class="d-flex align-items-center p-3 border rounded">
          <div 
            class="rounded-circle bg-secondary me-3"
            style="width: 50px; height: 50px; overflow: hidden"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="white" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
            </svg>
          </div>
          <div class="flex-grow-1">
            <h6 class="mb-0">Jack on the corner</h6>
            <div class="text-warning">
              ★★★★★
              <span class="text-muted ms-2">(110)</span>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>

    <SuccessCart 
      v-if="showSuccessModal" 
      :product-name="product.name" 
      @close="closeSuccessModal" 
    />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuth } from '@/stores/auth'
import ProductCard from '@/components/Product/ProductCard.vue'
import BaseButton from '@/components/ui/BaseButton.vue'
import SuccessCart from '@/components/SuccessModal/SuccessCart.vue'

const route = useRoute()
const router = useRouter()
const { user, isAuthenticated, checkAuth } = useAuth()
const isLiked = ref(false)
const showSuccessModal = ref(false)

checkAuth()

const product = ref({
  id: 1,
  name: 'Vintage Chicago Cubs White Crewneck',
  price: 'Rp1.250.000',
  size: 'XL / L',
  condition: 'Very Good',
  location: 'Jakarta Selatan',
  description: 'Authentic vintage Chicago Cubs crewneck sweatshirt from the 90s. Size XL but fits more like L with a looser fit. Made from premium cotton blend material. Has a few minor marks on the sleeve (pictured) but overall in excellent vintage condition. Perfect for collectors and vintage enthusiasts.',
  category: 'Hoodies & Sweater',
  color: 'White',
  uploaded: '2 days ago',
  image: '#E8E8E8',
  likes: 45
})

const otherProducts = ref([])

const fetchOtherProducts = async () => {
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

const isColorCode = computed(() => {
  return product.value.image && product.value.image.startsWith('#')
})

const isImageUrl = computed(() => {
  return product.value.image && (product.value.image.startsWith('http') || product.value.image.includes('.'))
})

const toggleLike = async () => {
  if (!isAuthenticated.value) {
    router.push('/login')
    return
  }

  try {
    const response = await fetch('http://localhost/FinalTest/Backend/toggle_like.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        user_id: user.value.id,
        product_id: product.value.id
      })
    })
    
    const data = await response.json()
    
    if (data.success) {
      isLiked.value = data.liked
    }
  } catch (error) {
    console.error('Error toggling like:', error)
  }
}

const handleAddToCart = () => {
  showSuccessModal.value = true
}

const closeSuccessModal = () => {
  showSuccessModal.value = false
}

onMounted(() => {
  document.title = `${product.value.name} - Vintage`
  fetchOtherProducts()
})
</script>

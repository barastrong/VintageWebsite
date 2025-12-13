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
            @click="handleBuyNow"
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
            class="rounded-circle me-3 d-flex align-items-center justify-content-center"
            :style="{ 
              width: '50px', 
              height: '50px', 
              overflow: 'hidden',
              backgroundColor: product.seller_image ? 'transparent' : '#6c757d',
              backgroundImage: product.seller_image ? `url(${product.seller_image})` : 'none',
              backgroundSize: 'cover',
              backgroundPosition: 'center'
            }"
          >
            <span v-if="!product.seller_image" class="text-white fw-bold" style="font-size: 1.2rem">
              {{ getInitials(product.seller_name) }}
            </span>
          </div>
          <div class="flex-grow-1">
            <h6 class="mb-0">{{ product.seller_name || 'Unknown Seller' }}</h6>
            <div class="d-flex align-items-center">
              <span class="text-warning me-1">
                <span v-for="i in 5" :key="i">
                  <template v-if="i <= Math.floor(product.rating || 0)">★</template>
                  <template v-else-if="i === Math.ceil(product.rating || 0) && (product.rating || 0) % 1 !== 0">⯨</template>
                  <template v-else>☆</template>
                </span>
              </span>
              <span class="text-dark fw-semibold me-1">{{ (product.rating || 0).toFixed(1) }}</span>
              <span class="text-muted">({{ product.rating_count || 0 }})</span>
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
import { ref, onMounted, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuth } from '@/stores/auth'
import ProductCard from '@/components/Card/ProductCard.vue'
import BaseButton from '@/components/ui/BaseButton.vue'
import SuccessCart from '@/components/SuccessModal/SuccessCart.vue'

const route = useRoute()
const router = useRouter()
const { user, isAuthenticated, checkAuth } = useAuth()
const isLiked = ref(false)
const showSuccessModal = ref(false)

checkAuth()

const product = ref({})
const otherProducts = ref([])

watch(() => route.params.id, (newId) => {
  if (newId) {
    fetchProductDetail()
    fetchOtherProducts()
    window.scrollTo(0, 0)
  }
})

const fetchProductDetail = async () => {
  try {
    const productId = route.params.id
    const response = await fetch(`http://localhost/FinalTest/Backend/get_product_detail.php?id=${productId}`)
    const data = await response.json()
    if (data.success) {
      product.value = data.data
      document.title = `${product.value.name} - Vintage`
      
      if (isAuthenticated.value && user.value) {
        checkLikeStatus()
      }
    }
  } catch (error) {
    console.error('Error fetching product detail:', error)
  }
}

const checkLikeStatus = async () => {
  try {
    const response = await fetch(`http://localhost/FinalTest/Backend/check_like.php?user_id=${user.value.id}&product_id=${product.value.id}`)
    const data = await response.json()
    if (data.success) {
      isLiked.value = data.liked
    }
  } catch (error) {
    console.error('Error checking like status:', error)
  }
}

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

const handleBuyNow = async () => {
  if (!isAuthenticated.value) {
    router.push('/login')
    return
  }
  
  try {
    const response = await fetch('http://localhost/FinalTest/Backend/create_new_order.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        user_id: user.value.id,
        product_id: product.value.id,
      })
    });
    
    const rawResponse = await response.text();
    let data;
    try {
      data = JSON.parse(rawResponse);
    } catch (e) {
      console.error("PHP tidak kirim JSON valid! Isinya malah ini:", rawResponse);
      alert("Error: Server tidak mengirim format JSON yang benar. Cek console.");
      return;
    }
    
    if (data.success) {
      console.log('Order created for product ID:', product.value.id, 'New Order ID:', data.new_order_id);
      router.push('/order');
    } else {
      console.error('Failed to Buy Now:', data.message);
      alert(`Failed to Buy Now: ${data.message}`);
    }
  } catch (error) {
    console.error('Error during Buy Now process:', error);
    alert('Failed to Buy Now due to network or server error.');
  }
}

const handleAddToCart = async () => {
  if (!isAuthenticated.value) {
    router.push('/login')
    return
  }

  try {
    const response = await fetch('http://localhost/FinalTest/Backend/add_to_cart.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        user_id: user.value.id,
        product_id: product.value.id,
        product_name: product.value.name,
        quantity: 1
      })
    })
    
    const data = await response.json()
    
    if (data.success) {
      showSuccessModal.value = true
      const { useCart } = await import('@/stores/cart')
      const { fetchCartCount } = useCart()
      fetchCartCount()
    }
  } catch (error) {
    console.error('Error adding to cart:', error)
  }
}

const closeSuccessModal = () => {
  showSuccessModal.value = false
}

const getInitials = (name) => {
  if (!name) return 'U'
  const words = name.trim().split(' ')
  if (words.length === 1) {
    return words[0].substring(0, 2).toUpperCase()
  }
  return (words[0][0] + words[words.length - 1][0]).toUpperCase()
}

onMounted(() => {
  fetchProductDetail()
  fetchOtherProducts()
})
</script>

<style scoped>
.order-item-image {
  background-repeat: no-repeat;
}
</style>
<template>
  <div class="col">
    <router-link :to="`/detail/${product.id}`" style="text-decoration: none; color: inherit">
      <div class="card h-100 border-0" style="cursor: pointer">
        <div 
          class="position-relative"
          :style="{ 
            backgroundColor: isColorCode ? product.image : '#f5f5f5',
            backgroundImage: isImageUrl ? `url(${product.image})` : 'none',
            backgroundSize: 'cover',
            backgroundPosition: 'center',
            paddingTop: '100%',
            borderRadius: '8px'
          }"
        >
        </div>
        <div class="card-body px-0">
          <h4 class="mb-1" style="color: #0D6B6F; font-family: 'Quicksand', sans-serif; font-weight: 600">Rp {{ product.price }}</h4>
          <h4 class="card-title mb-1" style="font-size: 1.25rem; height: 3rem; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ product.name }}</h4>
        <div class="d-flex justify-content-between align-items-center">
          <p class="text-muted mb-0" style="font-size: 0.85rem">{{ product.size }}</p>
          <button @click="toggleLike" class="btn btn-link d-flex align-items-center p-0" :class="isLiked ? 'text-danger' : 'text-muted'" style="font-size: 0.85rem; text-decoration: none">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" :fill="isLiked ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
              <path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"/>
            </svg>
            {{ likesCount }}
          </button>
        </div>
      </div>
      </div>
    </router-link>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useAuth } from '@/stores/auth'
import { useRouter } from 'vue-router'

const props = defineProps({
  product: {
    type: Object,
    required: true
  }
})

const isColorCode = computed(() => {
  return props.product.image && props.product.image.startsWith('#')
})

const isImageUrl = computed(() => {
  return props.product.image && (props.product.image.startsWith('http') || props.product.image.includes('.'))
})

const { user, isAuthenticated, checkAuth } = useAuth()
const router = useRouter()
const likesCount = ref(props.product.likes)
const isLiked = ref(false)

onMounted(() => {
  checkAuth()
  if (isAuthenticated.value && user.value) {
    checkLikeStatus()
  }
})

const checkLikeStatus = async () => {
  try {
    const response = await fetch(`http://localhost/FinalTest/Backend/check_like.php?user_id=${user.value.id}&product_id=${props.product.id}`)
    const data = await response.json()
    if (data.success) {
      isLiked.value = data.liked
    }
  } catch (error) {
    console.error('Error checking like status:', error)
  }
}

const toggleLike = async (event) => {
  event.preventDefault()
  event.stopPropagation()
  
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
        product_id: props.product.id
      })
    })
    
    const data = await response.json()
    
    if (data.success) {
      likesCount.value = data.total_likes
      isLiked.value = data.liked
    }
  } catch (error) {
    console.error('Error toggling like:', error)
  }
}
</script>

<template>
  <div class="col">
    <div class="card h-100 border-0">
      <div 
        class="position-relative"
        :style="{ 
          backgroundColor: product.image, 
          paddingTop: '100%',
          borderRadius: '8px'
        }"
      >
        <button 
          class="btn btn-link position-absolute top-0 end-0 m-2 text-dark"
          style="text-decoration: none"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
          </svg>
        </button>
      </div>
      <div class="card-body px-0">
        <h3 class="mb-1" style="color: #0D6B6F; font-family: 'Quicksand', sans-serif; font-weight: 600">{{ product.price }}</h3>
        <h4 class="card-title mb-1" style="font-size: 1.25rem">{{ product.name }}</h4>
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

const likesCount = ref(props.product.likes)
const isLiked = ref(false)

const toggleLike = async () => {
  try {
    const response = await fetch('http://localhost/FinalTest/Backend/toggle_like.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        user_id: 1,
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

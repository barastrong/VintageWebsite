<template>
  <!-- STRUKTUR LAYOUT MENGIKUTI HOME -->
  <div class="container-fluid py-5">
    <!-- Wrapper Inner persis seperti Home -->
    <div class="mx-auto" style="max-width: 1700px; padding: 0 2rem">
      
      <!-- Header Section -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-semibold mb-0" style="color: #000;">Favorite items</h3>
        <span class="text-muted border rounded px-3 py-1">
          {{ itemCount > 0 ? `${itemCount} Items` : "You don't have any favorite item yet" }}
        </span>
      </div>

      <!-- State: Loading -->
      <div v-if="isLoading" class="text-center py-5">
        <div class="spinner-border text-secondary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>

      <!-- State: Error -->
      <div v-else-if="errorMsg" class="alert alert-danger text-center">
        {{ errorMsg }}
      </div>

      <!-- State: Data Ada -->
      <div v-else-if="favoriteItems.length > 0" class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-4">
        <ProductCard 
          v-for="item in favoriteItems" 
          :key="item.id" 
          :product="item"
          @toggle-like="handleToggleLike"
        />
      </div>

      <!-- State: Kosong -->
      <!-- <div v-else class="text-center py-5 text-muted" style="min-height: 400px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#dee2e6" class="bi bi-heart-break mb-3" viewBox="0 0 16 16">
          <path d="M8.867 14.41c13.308-9.322 4.79-16.563.064-13.824L7 3l1.5 4-2 3L8 15a38.094 38.094 0 0 0 .867-.59Zm-.303-1.01c6.164-4.4 6.91-7.982 6.22-9.921C14.031 1.37 11.447.42 9.587 1.368L8.136 3.18l1.3 3.468 4.893 6.963-4.252-2.902Zm-4.215-6.98L2.97 4.57 3.65 3.32l2.35 1.76-1.65 1.34Zm-2.6.4L1.75 6.82l.96 1.66 2.1-1.2-1.35-1.74Zm-1.75 2.1L.82 8.92l1.35 1.54 1.76-1.54-3.93-1.01Zm4.6-2.2-2.16-1.25-.66 1.15 2.82 1.65-.54-1.55Z"/>
        </svg>
        <h4 class="fw-semibold">No favorite items yet</h4>
        <p>Start exploring and add items you love!</p>
        <router-link to="/" class="btn btn-outline-dark mt-2 px-4 rounded-pill">Explore Now</router-link>
      </div> -->
      <EmptyFavorite v-else/>

    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import ProductCard from '../Card/ProductCard.vue';
import EmptyFavorite from '../Empty/EmptyFavorite.vue';

// 1. State
const favoriteItems = ref([]);
const isLoading = ref(true);
const errorMsg = ref('');

// 2. AMBIL USER ID
const getUserId = () => {
  try {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    return user.id || 1;
  } catch (e) {
    return 1;
  }
};
const currentUserId = getUserId();

// Computed Property
const itemCount = computed(() => favoriteItems.value.length);

// 3. Fungsi Fetch Data
const loadUserFavorites = async () => {
  try {
    isLoading.value = true;
    const response = await fetch(`http://localhost/FinalTest/Backend/get_likes.php?user_id=${currentUserId}`);
    const result = await response.json();

    if (result.success) {
      favoriteItems.value = result.data;
    } else {
      if (!result.data) {
         favoriteItems.value = [];
      } else {
         errorMsg.value = result.message;
      }
    }
  } catch (error) {
    console.error("Error fetching data:", error);
    errorMsg.value = 'Gagal terhubung ke server.';
  } finally {
    isLoading.value = false;
  }
};

// 4. Jalankan saat mounted
onMounted(() => {
  loadUserFavorites();
});

// 5. Handler Toggle Like
const handleToggleLike = async (productId) => {
  // Hapus dari UI langsung
  const index = favoriteItems.value.findIndex(item => item.id === productId);
  if (index !== -1) {
    favoriteItems.value.splice(index, 1);
  }

  // Sync ke Backend
  try {
    await fetch('http://localhost/FinalTest/Backend/toggle_like.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ 
        user_id: currentUserId, 
        product_id: productId 
      })
    });
  } catch (e) {
    console.error("Gagal sync ke server", e);
  }
};
</script>
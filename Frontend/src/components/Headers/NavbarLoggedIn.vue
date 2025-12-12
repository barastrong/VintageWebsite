<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3 shadow-sm">
    <div class="container-fluid px-5">
      <div class="d-flex justify-content-between align-items-center w-100">
        <!-- Logo and Brand -->
        <router-link to="/" class="navbar-brand d-flex align-items-center" style="margin-left: 8rem; text-decoration: none">
          <img src="@/assets/Logo Horizontal.png" alt="Vintage Logo" style="height: 40px" />
        </router-link>

        <!-- Search Bar -->
        <div class="me-2" style="width: 900px; margin-left: 3rem">
          <div class="input-group input-group-lg">
            <span class="input-group-text bg-white border-end-0">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-muted" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
              </svg>
            </span>
            <input 
              v-model="searchQuery"
              @keyup.enter="goToSearch"
              type="text" 
              class="form-control border-start-0 ps-0" 
              placeholder="Search for items"
              style="box-shadow: none"
            />
          </div>
        </div>

        <!-- Right side - Icons and Profile -->
        <div class="d-flex align-items-center" style="gap: 2.25rem; margin-right: 12rem">
        <!-- Cart Icon with Badge -->
        <router-link :to="`/cart/${getUserId()}`" style="text-decoration: none">
          <div class="position-relative">
            <button class="btn btn-link p-0 text-dark" style="text-decoration: none">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#616161" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart-icon lucide-shopping-cart"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
            </button>
            <span 
              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
              style="font-size: 0.7rem; padding: 0.25rem 0.5rem"
            >
              {{ cartCount }}
            </span>
          </div>
        </router-link>

        <!-- Favorite Icon with Badge -->
        <router-link to="/favorite" style="text-decoration: none">
        <div class="position-relative">
          <button class="btn btn-link p-0 text-dark" style="text-decoration: none">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#616161" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-icon lucide-heart"><path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"/></svg>
          </button>
          <span 
              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            style="font-size: 0.7rem; padding: 0.25rem 0.5rem"
          >
            {{ favoriteCount }}
          </span>
        </div>
        </router-link>

        <!-- Profile Dropdown -->
        <div class="dropdown">
          <button 
            class="btn btn-link p-0 d-flex align-items-center text-decoration-none" 
            type="button" 
            id="profileDropdown" 
            data-bs-toggle="dropdown" 
            aria-expanded="false"
          >
            <div 
              class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-2"
              style="width: 40px; height: 40px; overflow: hidden"
            >
              <span style="font-size: 16px; color: white; font-weight: 600">{{ userInitials }}</span>
            </div>
            <i class="fas fa-chevron-down text-dark"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown"><router-link to="/user/profile" style="text-decoration: none;">
            <li><a class="dropdown-item" href="#"><i class="far fa-user me-2"></i>Profile</a></li></router-link>
            <li><a class="dropdown-item" href="#"><i class="far fa-file-alt me-2"></i>Orders</a></li>
            <li><a class="dropdown-item text-danger" href="#" @click="showLogoutModal"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
          </ul>
        </div>

        <!-- Language Dropdown -->
        <div class="dropdown">
          <button 
            class="btn btn-light dropdown-toggle px-3 py-2" 
            type="button" 
            id="languageDropdown" 
            data-bs-toggle="dropdown" 
            aria-expanded="false"
          >
            EN
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
            <li><a class="dropdown-item" href="#">EN - English</a></li>
            <li><a class="dropdown-item" href="#">ID - Indonesian</a></li>
            <li><a class="dropdown-item" href="#">ES - Spanish</a></li>
          </ul>
        </div>
      </div>
    </div>
    </div>
  </nav>

  <!-- Logout Confirmation Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 380px">
      <div class="modal-content">
        <div class="modal-header border-0 pb-2">
          <h5 class="modal-title" id="logoutModalLabel">Logout</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pt-0">
          Are you sure want to logout from vintage?
        </div>
        <div class="modal-footer border-0">
          <BaseButton variant="light" custom-style="background-color: #EDEDED; color: #000" data-bs-dismiss="modal">Cancel</BaseButton>
          <BaseButton variant="danger" @click="handleLogout">Logout</BaseButton>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import BaseButton from '@/components/ui/BaseButton.vue'
import { useCart } from '@/stores/cart'
import { useFavorite } from '@/stores/favorite'

const router = useRouter()
const { cartCount, fetchCartCount } = useCart()
const { favoriteCount, fetchFavoriteCount } = useFavorite()
const searchQuery = ref('')

const goToSearch = () => {
  if (searchQuery.value.trim()) {
    router.push(`/search?q=${encodeURIComponent(searchQuery.value)}`)
  }
}

// Listen for clear search event
window.addEventListener('clearSearch', () => {
  searchQuery.value = ''
})

const userInitials = ref('')

const getUserInitials = () => {
  const user = JSON.parse(localStorage.getItem('user') || '{}')
  const username = user.username || ''
  const names = username.trim().split(' ')
  if (names.length >= 2) {
    return (names[0][0] + names[1][0]).toUpperCase()
  } else if (names.length === 1 && names[0]) {
    return names[0].substring(0, 2).toUpperCase()
  }
  return 'U'
}

const getUserId = () => {
  const user = JSON.parse(localStorage.getItem('user') || '{}')
  return user.id || 1
}

userInitials.value = getUserInitials()

onMounted(() => {
  fetchCartCount(),
  fetchFavoriteCount()
})

const showLogoutModal = () => {
  const modal = new bootstrap.Modal(document.getElementById('logoutModal'))
  modal.show()
}

const handleLogout = async () => {
  const modal = bootstrap.Modal.getInstance(document.getElementById('logoutModal'))
  if (modal) modal.hide()
  const user = JSON.parse(localStorage.getItem('user') || '{}')
  
  try {
    await fetch('http://localhost/FinalTest/Backend/logout.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        userId: user.id
      })
    })
  } catch (error) {
    console.error('Logout error:', error)
  }
  
  // Remove user from localStorage
  localStorage.removeItem('user')
  
  // Redirect to home and reload
  window.location.href = '/'
}
</script>

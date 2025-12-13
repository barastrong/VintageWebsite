<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3 shadow-sm">
    <div class="container-fluid px-5">
      <div class="d-flex justify-content-between align-items-center w-100">
        <router-link to="/" class="navbar-brand d-flex align-items-center" style="margin-left: 8rem; text-decoration: none">
          <img src="@/assets/Logo Horizontal.png" alt="Vintage Logo" style="height: 40px" />
        </router-link>

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

        <div class="d-flex align-items-center" style="gap: 2.25rem; margin-right: 12rem">
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
              <img 
                v-if="userImage" 
                :src="userImage" 
                alt="Profile" 
                style="width: 100%; height: 100%; object-fit: cover;"
              />
              <span v-else style="font-size: 16px; color: white; font-weight: 600">{{ userInitials }}</span>
            </div>
            <i class="fas fa-chevron-down text-dark"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end custom-z-index" aria-labelledby="profileDropdown"><router-link to="/user/profile" style="text-decoration: none;">
            <li><a class="dropdown-item" href="#"><i class="far fa-user me-2"></i>Profile</a></li></router-link>
            <router-link to="/user/history" style="text-decoration: none;"><li><a class="dropdown-item" href="#"><i class="far fa-file-alt me-2"></i>Orders</a></li></router-link>
            <li><a class="dropdown-item text-danger" href="#" @click="showLogoutModal"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
          </ul>
        </div>

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
import { ref, onMounted, computed, onUnmounted, watch } from 'vue' // Tambahkan watch
import { useRouter } from 'vue-router'
import BaseButton from '@/components/ui/BaseButton.vue'
import { useCart } from '@/stores/cart'
import { useFavorite } from '@/stores/favorite'
import { useAuth } from '@/stores/auth' // <-- Import useAuth

const API_BASE_URL = 'http://localhost/FinalTest/Backend/';
const API_GET_USER = API_BASE_URL + 'get_user.php';

const router = useRouter()
const { cartCount, fetchCartCount } = useCart()
const { favoriteCount, fetchFavoriteCount } = useFavorite()
const { user, checkAuth, logout } = useAuth() // <-- Gunakan useAuth
const searchQuery = ref('')

const userImage = ref(null);
const userStorageData = ref(JSON.parse(localStorage.getItem('user') || '{}')); // TETAP SIMPAN UNTUK INITIAL LOAD

// Computed Property untuk User ID yang reaktif
const currentUserId = computed(() => user.value ? user.value.id : null); 

const goToSearch = () => {
  if (searchQuery.value.trim()) {
    router.push(`/search?q=${encodeURIComponent(searchQuery.value)}`)
  }
}

window.addEventListener('clearSearch', () => {
  searchQuery.value = ''
})

const fetchProfileImage = async (userId) => {
    if (!userId) {
      userImage.value = null;
      return;
    }

    try {
        const response = await fetch(`${API_GET_USER}?id=${userId}`);
        const data = await response.json();

        if (data.success && data.data.image) {
            let imagePath = data.data.image; 
            
            // Logika penghapusan duplikasi path
            const redundantPrefix = 'uploads/users/';
            if (imagePath.startsWith(redundantPrefix) && imagePath.indexOf(redundantPrefix) !== imagePath.lastIndexOf(redundantPrefix)) {
                 imagePath = imagePath.substring(imagePath.indexOf(redundantPrefix) + redundantPrefix.length);
            }
            if (imagePath.startsWith('/')) {
                imagePath = imagePath.substring(1);
            }

            // Update userStorageData dan localStorage DENGAN PATH RELATIF
            const currentUser = JSON.parse(localStorage.getItem('user') || '{}');
            currentUser.image = imagePath;
            localStorage.setItem('user', JSON.stringify(currentUser));
            userStorageData.value = currentUser; // Update ref

            userImage.value = API_BASE_URL + imagePath; 
        } else {
            userImage.value = null;
        }
    } catch (error) {
        console.error('Failed to fetch profile image:', error);
        userImage.value = null;
    }
}

const loadUserFromStorage = () => {
    checkAuth(); // Pastikan store diinisialisasi
    const userId = currentUserId.value; // Ambil ID reaktif

    if (user.value && user.value.image) {
        let imagePath = user.value.image; // Gunakan image dari store (sudah diupdate)
        
        // Logika penghapusan duplikasi path
        const redundantPrefix = 'uploads/users/';
        if (imagePath.startsWith(redundantPrefix) && imagePath.indexOf(redundantPrefix) !== imagePath.lastIndexOf(redundantPrefix)) {
             imagePath = imagePath.substring(imagePath.indexOf(redundantPrefix) + redundantPrefix.length);
        }
        if (imagePath.startsWith('/')) {
             imagePath = imagePath.substring(1);
        }
        userImage.value = API_BASE_URL + imagePath;
    } else {
        // Jika tidak ada image di store, panggil fetchProfileImage
        fetchProfileImage(userId);
    }
    
    // Update initials data dari store
    userStorageData.value = user.value || {};
}

const userInitials = computed(() => {
    // Gunakan user dari store jika ada, jika tidak pakai userStorageData
    const userDisplay = user.value || userStorageData.value;
    const name = userDisplay.username || ''; 
    const names = name.trim().split(/\s+/);
    
    if (names.length >= 2) {
      const firstInitial = names[0].charAt(0);
      const lastInitial = names[names.length - 1].charAt(0);
      return (firstInitial + lastInitial).toUpperCase();
    } else if (names.length === 1 && names[0]) {
      return names[0].substring(0, 2).toUpperCase();
    }
    return 'U';
});

const getUserId = () => {
  return currentUserId.value || 1 // Gunakan ID reaktif
}

onMounted(() => {
    loadUserFromStorage();
    fetchCartCount();
    fetchFavoriteCount();
    window.addEventListener('profileUpdated', loadUserFromStorage);
});

onUnmounted(() => {
    window.removeEventListener('profileUpdated', loadUserFromStorage);
});

// WATCHER: Pastikan gambar dimuat jika user state berubah (misal setelah login)
watch(currentUserId, (newId) => {
    loadUserFromStorage();
});


const showLogoutModal = () => {
  const modal = new bootstrap.Modal(document.getElementById('logoutModal'))
  modal.show()
}

const handleLogout = async () => {
  const modal = bootstrap.Modal.getInstance(document.getElementById('logoutModal'))
  if (modal) modal.hide()
  const userToLogout = user.value // Ambil user dari store
  
  try {
    await fetch('http://localhost/FinalTest/Backend/logout.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        userId: userToLogout.id // Gunakan ID dari store
      })
    })
  } catch (error) {
    console.error('Logout error:', error)
  }
  
  // Panggil store logout
  logout(); 

  // Hapus localStorage.getItem('id') yang lama
  localStorage.removeItem('id') 
  
  window.location.href = '/'
}
</script>

<style>
.custom-z-index {
    z-index: 1030 !important; 
}
</style>
<template>
  <div class="card border-0 shadow-sm">
    <div class="card-body p-4 p-md-5">
      <h4 class="fw-semibold mb-4">Edit Profile</h4>

      <!-- Photo Upload Section -->
      <div class="mb-4">
        <label class="form-label fw-semibold">Photo</label>
        <div class="d-flex align-items-center gap-3">
          
          <!-- Tampilkan Inisial User Jika userImage Kosong -->
          <div 
            v-if="!userImage" 
            class="rounded-circle d-flex align-items-center justify-content-center text-white fs-3 fw-bold"
            style="width: 80px; height: 80px; background-color: #17a2b8;"
          >
            <!-- Menampilkan Inisial yang dihitung -->
            {{ userInitials }} 
          </div>
          
          <!-- Gambar Profil yang Sebenarnya -->
          <img 
            v-else 
            :src="userImage" 
            alt="User Profile" 
            class="rounded-circle"
            style="width: 80px; height: 80px; object-fit: cover;"
          >

          
          <button @click="handlePhotoUpload" class="btn btn-outline-secondary">
            Choose
          </button>
          
          <span class="text-muted small">JPG, JPEG or PNG, 1 MB max.</span>
          
          <button 
            @click="handleDeletePhoto"
            class="btn btn-link text-danger ms-auto"
            style="text-decoration: none;"
          >
            <!-- Trash Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Full Name Input -->
      <div class="mb-4">
        <label for="fullName" class="form-label fw-semibold">Full name</label>
        <input
          type="text"
          class="form-control form-control-lg"
          id="fullName"
          v-model="formData.fullName"
        />
      </div>

      <!-- Username Input -->
      <div class="mb-4">
        <label for="username" class="form-label fw-semibold">Username</label>
        <input
          type="text"
          class="form-control form-control-lg"
          id="username"
          v-model="formData.username"
        />
      </div>

      <!-- Email Input -->
      <div class="mb-4">
        <label for="email" class="form-label fw-semibold">Email</label>
        <input
          type="email"
          class="form-control form-control-lg"
          id="email"
          v-model="formData.email"
        />
      </div>

      <!-- Update Button -->
      <div class="d-flex justify-content-end">
        <button 
          @click="handleUpdateProfile"
          class="btn btn-lg text-white fw-semibold px-5"
          style="background-color: #17a2b8; border: none;"
        >
          Update Profile
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, onMounted, ref, computed } from 'vue'

const API_URL = 'http://localhost/FinalTest/Backend/get_user.php'; 
const userId = localStorage.getItem('id'); // Mengambil ID dari localStorage

const formData = reactive({
  fullName: '',
  username: '',
  email: ''
})

const userImage = ref(null); 

const userInitials = computed(() => {
    const name = formData.username;
    if (!name) return '';
    const parts = name.trim().split(/\s+/);

    if (parts.length >= 2) {
        const firstInitial = parts[0].charAt(0);
        const lastInitial = parts[parts.length - 1].charAt(0);
        return (firstInitial + lastInitial).toUpperCase();
    } else {
        return name.substring(0, 2).toUpperCase();
    }
});


const fetchUserData = async () => {
    if (!userId) {
        console.error('User ID not found in localStorage. Cannot fetch profile.');
        return;
    }
    
    try {
        // Mengirim ID via parameter query
        const response = await fetch(`${API_URL}?id=${userId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();

        if (data.success) {
            formData.fullName = data.data.fullname || ''; 
            formData.username = data.data.username || '';
            formData.email = data.data.email || '';
            
            if (data.data.image && data.data.image !== "") {
              userImage.value = data.data.image; 
            } else {
              userImage.value = null; 
            }

            console.log('User data successfully loaded:', data.data);
        } else {
            console.error('Failed to load user data:', data.message);
        }
    } catch (error) {
        console.error('Fetch error:', error);
    }
}

onMounted(() => {
    fetchUserData();
});


const handleUpdateProfile = () => {
  console.log('Update profile data:', formData)
  alert('Profile updated successfully! (Logic update ke backend belum diimplementasikan)');
}

const handlePhotoUpload = () => {
  console.log('Open file dialog...')
}

const handleDeletePhoto = () => {
  if(confirm('Are you sure want to remove photo?')) {
    userImage.value = null; 
    console.log('Photo deleted (Logic delete di backend belum diimplementasikan)')
  }
}
</script>
<template>
  <div class="card border-0 shadow-sm">
    <div class="card-body p-4 p-md-5">
      <h4 class="fw-semibold mb-4">Edit Profile</h4>

      <!-- Photo Upload Section -->
      <div class="mb-4">
        <label class="form-label fw-semibold">Photo</label>
        <div class="d-flex align-items-center gap-3">
          <!-- Avatar Circle -->
          <div 
            class="rounded-circle d-flex align-items-center justify-content-center"
            style="width: 80px; height: 80px; background-color: #0dcaf0;"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="white" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
            </svg>
          </div>
          
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
import { reactive } from 'vue'

// Reactive state untuk data form
const formData = reactive({
  fullName: 'Jack Daniel',
  username: 'jackdaniel',
  email: 'jack@email.com'
})

// Fungsi Handler
const handleUpdateProfile = () => {
  console.log('Update profile data:', formData)
  alert('Profile updated successfully!')
  // Di sini nanti tambahkan logic fetch ke Backend PHP
}

const handlePhotoUpload = () => {
  console.log('Open file dialog...')
  // Di sini logic trigger input file
}

const handleDeletePhoto = () => {
  if(confirm('Are you sure want to remove photo?')) {
    console.log('Photo deleted')
  }
}
</script>
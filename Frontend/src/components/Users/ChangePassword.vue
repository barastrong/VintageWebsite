<template>
  <div class="card border-0 shadow-sm">
    <div class="card-body p-4 p-md-5">
      <h4 class="fw-semibold mb-4">Change Password</h4>

      <form @submit.prevent="handleChangePassword">
        <!-- Current Password -->
        <div class="mb-4">
          <label class="form-label fw-semibold">Current Password</label>
          <input 
            type="password" 
            class="form-control form-control-lg"
            v-model="form.current"
            placeholder="Enter current password"
            required
          />
        </div>

        <!-- New Password -->
        <div class="mb-4">
          <label class="form-label fw-semibold">New Password</label>
          <input 
            type="password" 
            class="form-control form-control-lg"
            v-model="form.new"
            placeholder="Enter new password"
            required
          />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
          <label class="form-label fw-semibold">Confirm Password</label>
          <input 
            type="password" 
            class="form-control form-control-lg"
            v-model="form.confirm"
            placeholder="Repeat new password"
            required
          />
        </div>

        <!-- Button -->
        <div class="d-flex justify-content-end mt-5">
          <button 
            type="submit"
            class="btn btn-lg text-white fw-semibold px-5"
            style="background-color: #17a2b8; border: none;"
          >
            Update Password
          </button>
        </div>
      </form>

    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue'

const API_URL = 'http://localhost/FinalTest/Backend/change_password.php'

const form = reactive({
  current: '',
  new: '',
  confirm: ''
})

const handleChangePassword = async () => {
  const userId = localStorage.getItem('id')

  if (!userId) {
    alert('User ID not found. Please log in again.')
    return
  }

  if (form.new.length < 6) {
    alert('Password baru minimal 6 karakter.')
    return
  }

  if (form.new !== form.confirm) {
    alert('Password baru dan konfirmasi tidak sama!')
    return
  }
  
  try {
    const response = await fetch(API_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        userId: userId, // Kirim ID user dari localStorage
        currentPassword: form.current,
        newPassword: form.new
      })
    })

    const result = await response.json()

    if (result.success) {
      alert(result.message)
      // Reset form
      form.current = ''
      form.new = ''
      form.confirm = ''
    } else {
      alert(`Gagal: ${result.message}`)
    }

  } catch (error) {
    console.error('Error changing password:', error)
    alert('Gagal menghubungi server. Silakan coba lagi.')
  }
}
</script>
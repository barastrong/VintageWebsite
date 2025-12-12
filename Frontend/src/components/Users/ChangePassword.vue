<template>
  <div class="card border-0 shadow-sm">
    <div class="card-body p-4 p-md-5">
      <h4 class="fw-semibold mb-4">Change Password</h4>

      <form @submit.prevent="handleChangePassword">
        <!-- Current Password -->
        <BaseInput
          id="currentPassword"
          v-model="form.current"
          type="password"
          label="Current Password"
          placeholder="Enter current password"
          :required="true"
          size="lg"
        />

        <!-- New Password -->
        <BaseInput
          id="newPassword"
          v-model="form.new"
          type="password"
          label="New Password"
          placeholder="Enter new password"
          :required="true"
          size="lg"
        />

        <!-- Confirm Password -->
        <BaseInput
          id="confirmPassword"
          v-model="form.confirm"
          type="password"
          label="Confirm Password"
          placeholder="Repeat new password"
          :required="true"
          size="lg"
        />

        <!-- Button -->
        <div class="d-flex justify-content-end mt-5">
          <BaseButton 
            type="submit"
            variant="primary"
            size="lg"
            custom-class="text-white fw-semibold px-5"
            custom-style="background-color: #17a2b8; border: none;"
          >
            Update Password
          </BaseButton>
        </div>
      </form>

    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue'
// Import komponen BaseInput dan BaseButton
import BaseButton from '@/components/ui/BaseButton.vue' // Sesuaikan path jika berbeda
import BaseInput from '@/components/ui/BaseInput.vue'   // Sesuaikan path jika berbeda

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
        userId: userId, 
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
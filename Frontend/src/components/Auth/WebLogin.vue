<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white rounded-lg shadow-sm w-full p-8" style="max-width: 480px">
      <h2 class="text-2xl font-semibold mb-2">Login to vintage</h2>
      <p class="text-gray-600 mb-6">Enter your details below</p>

      <div>
        <!-- Email Field -->
        <BaseInput
          id="email"
          v-model="formData.email"
          type="email"
          label="Email"
          placeholder="Enter your email"
          :required="true"
          size="lg"
        />

        <!-- Password Field -->
        <BaseInput
          id="password"
          v-model="formData.password"
          :type="showPassword ? 'text' : 'password'"
          label="Password"
          placeholder="Enter your password"
          :required="true"
          :has-icon="true"
          size="lg"
        >
          <template #icon>
            <button
              type="button"
              @click="showPassword = !showPassword"
              class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-secondary"
              style="text-decoration: none; z-index: 10"
            >
              <svg v-if="showPassword" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
              </svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
              </svg>
            </button>
          </template>
        </BaseInput>

        <!-- Submit Button -->
        <BaseButton 
          @click="handleSubmit"
          variant="primary"
          custom-class="w-full py-3 font-semibold"
          custom-style="background-color: #17a2b8; border: none"
        >
          Continue
        </BaseButton>

        <!-- Sign up Link -->
        <div class="text-center mt-4">
          <span class="text-muted">Don't have an account? </span>
            <router-link to="/signup" class="text-decoration-none" style="color: #17a2b8">
              Sign up
            </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import BaseButton from '@/components/ui/BaseButton.vue'
import BaseInput from '@/components/ui/BaseInput.vue'

const router = useRouter()
const showPassword = ref(false)
const formData = ref({
  email: '',
  password: ''
})

const handleSubmit = async () => {
  if (!formData.value.email || !formData.value.password) {
    alert('Please fill in all fields')
    return
  }
  
  try {
    const response = await fetch('http://localhost/FinalTest/Backend/login.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        email: formData.value.email,
        password: formData.value.password
      })
    })
    
    const text = await response.text()
    console.log('Response:', text)
    
    let result
    try {
      result = JSON.parse(text)
    } catch (e) {
      alert('Server error. Please check if backend is running.')
      console.error('JSON Parse Error:', text)
      return
    }
    
    if (result.success) {
      // Save user to localStorage
      localStorage.setItem('user', JSON.stringify(result.user))
      
      // Redirect to home and reload
      window.location.href = '/'
    } else {
      alert(result.message)
    }
  } catch (error) {
    alert('Login failed. Please try again.')
    console.error('Error:', error)
  }
}
</script>

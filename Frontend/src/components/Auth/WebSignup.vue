<template>
  <div class="min-vh-100 d-flex align-items-center justify-content-center bg-light py-4">
    <!-- Success Modal Popup -->
    <SuccessRegister v-if="showSuccess" />

    <!-- Register Form -->
    <div class="card border-0 shadow-sm" style="max-width: 550px; width: 100%">
      <div class="card-body p-4 p-md-5">
        <!-- Header with Close Button -->
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h2 class="fw-semibold mb-0">Sign up</h2>
          <button 
            type="button" 
            class="btn-close"
            @click="handleClose"
            aria-label="Close"
          ></button>
        </div>
        
        <p class="text-muted mb-4">Enter your details below</p>

        <div>
          <!-- Full Name Field -->
          <BaseInput
            id="fullname"
            v-model="formData.fullname"
            type="text"
            label="Full name"
            placeholder="Enter your fullname"
            :required="true"
            size="lg"
          />

          <!-- Username Field -->
          <BaseInput
            id="username"
            v-model="formData.username"
            type="text"
            label="Username"
            placeholder="Enter your username"
            :required="true"
            size="lg"
          />

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
                class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-secondary"
                @click="showPassword = !showPassword"
                style="text-decoration: none; z-index: 10"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                  <path v-if="showPassword" d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                  <path v-else d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                </svg>
              </button>
            </template>
          </BaseInput>

          <!-- Confirmation Password Field -->
          <BaseInput
            id="confirmPassword"
            v-model="formData.confirmPassword"
            :type="showConfirmPassword ? 'text' : 'password'"
            label="Confirmation Password"
            placeholder="Enter your password"
            :required="true"
            :has-icon="true"
            size="lg"
          >
            <template #icon>
              <button
                type="button"
                class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-secondary"
                @click="showConfirmPassword = !showConfirmPassword"
                style="text-decoration: none; z-index: 10"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                  <path v-if="showConfirmPassword" d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                  <path v-else d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                </svg>
              </button>
            </template>
          </BaseInput>

          <!-- Terms and Conditions Checkbox -->
          <div class="mb-4">
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                id="agreeTerms"
                v-model="formData.agreeTerms"
                :style="{ 
                  width: '20px', 
                  height: '20px',
                  backgroundColor: formData.agreeTerms ? '#17a2b8' : 'white',
                  borderColor: '#17a2b8'
                }"
              />
              <label class="form-check-label ms-2" for="agreeTerms">
                By clicking sign up, I hereby agree and consent to 
                <a href="#" class="text-decoration-none" style="color: #17a2b8">
                  Term & Conditions
                </a>
                ; I confirm that I have read 
                <a href="#" class="text-decoration-none" style="color: #17a2b8">
                  Privacy policy
                </a>.
              </label>
            </div>
          </div>

          <!-- Submit Button -->
          <BaseButton 
            @click="handleSubmit"
            variant="primary"
            size="lg"
            custom-class="w-100 fw-semibold"
            custom-style="background-color: #17a2b8; border: none"
          >
            Sign up
          </BaseButton>

          <!-- Login Link -->
          <div class="text-center mt-3">
            <span class="text-muted">Already have an account? </span>
            <router-link to="/login" class="text-decoration-none" style="color: #17a2b8">
              Login
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import SuccessRegister from './SuccessRegister.vue'
import BaseButton from '@/components/ui/BaseButton.vue'
import BaseInput from '@/components/ui/BaseInput.vue'

const router = useRouter()
const showPassword = ref(false)
const showConfirmPassword = ref(false)
const showSuccess = ref(false)
const formData = ref({
  fullname: '',
  username: '',
  email: '',
  password: '',
  confirmPassword: '',
  agreeTerms: false
})

const handleSubmit = async () => {
  if (formData.value.password !== formData.value.confirmPassword) {
    alert('Passwords do not match!')
    return
  }
  if (!formData.value.agreeTerms) {
    alert('Please agree to the Terms & Conditions')
    return
  }
  
  try {
    const response = await fetch('http://localhost/FinalTest/Backend/register.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        username: formData.value.username,
        fullname: formData.value.fullname,
        email: formData.value.email,
        password: formData.value.password
      })
    })
    
    const result = await response.json()
    
    if (result.success) {
      // Save user to localStorage with id
      localStorage.setItem('user', JSON.stringify({
        id: result.userId,
        username: formData.value.username,
        email: formData.value.email
      }))
      
      showSuccess.value = true
      setTimeout(() => {
        window.location.href = '/'
      }, 10000)
    } else {
      alert(result.message)
    }
  } catch (error) {
    alert('Registration failed. Please try again.')
    console.error('Error:', error)
  }
}

const handleClose = () => {
  router.push('/')
}
</script>

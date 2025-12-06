<template>
  <div class="modal d-block" style="background-color: rgba(0,0,0,0.5)" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow">
        <div class="modal-body p-5 text-center">
          <!-- Animated GIF -->
          <div class="mb-4 d-flex justify-content-center">
            <img src="@/assets/SuccessRegister.gif" alt="Success" style="width: 120px; height: 120px" />
          </div>

          <!-- Success Message -->
          <h2 class="fw-bold mb-3" style="font-size: 1.75rem">
            Successfully Register
          </h2>
          
          <p class="text-muted mb-4" style="font-size: 1rem; line-height: 1.6">
            Thank you for register at vintage. Start find your favorite pre-loved product here.
          </p>

          <!-- Go to Home Button -->
          <router-link 
            to="/"
            class="btn btn-lg w-100 text-white fw-semibold"
            style="background-color: #17a2b8; border: none; text-decoration: none"
          >
            Go to Home Page
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
</script>

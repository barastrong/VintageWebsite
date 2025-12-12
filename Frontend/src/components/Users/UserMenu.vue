<template>
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <h5 class="fw-bold p-4 mb-0">Settings</h5>
      <ul class="list-group list-group-flush">
        <!-- Tab Profile -->
        <li 
          class="list-group-item border-0"
          :class="{ 'bg-light': activeTab === 'profile' }"
          style="cursor: pointer;"
          @click="$emit('update:activeTab', 'profile')"
        >
          <div class="d-flex align-items-center py-2">
            <span :class="{ 'fw-semibold': activeTab === 'profile' }">Profile details</span>
          </div>
        </li>

        <!-- Tab Password -->
        <li 
          class="list-group-item border-0"
          :class="{ 'bg-light': activeTab === 'password' }"
          style="cursor: pointer;"
          @click="$emit('update:activeTab', 'password')"
        >
          <div class="d-flex align-items-center py-2">
            <span :class="{ 'fw-semibold': activeTab === 'password' }">Change Password</span>
          </div>
        </li>

        <!-- Tab History -->
        <li 
          class="list-group-item border-0"
          :class="{ 'bg-light': activeTab === 'history' }"
          style="cursor: pointer;"
          @click="$emit('update:activeTab', 'history')"
        >
          <div class="d-flex align-items-center py-2">
            <span :class="{ 'fw-semibold': activeTab === 'history' }">Transaction History</span>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
// Menerima data dari parent component
defineProps({
  activeTab: {
    type: String,
    required: true
  }
})

// Mengirim event ke parent saat diklik
defineEmits(['update:activeTab'])
</script>
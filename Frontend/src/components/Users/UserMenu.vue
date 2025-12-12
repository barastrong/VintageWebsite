<template>
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <h5 class="fw-bold p-4 mb-0">Settings</h5>
      <ul class="list-group list-group-flush">
        
        <!-- Profile -->
        <li 
          class="list-group-item border-0"
          :class="{ 'bg-light': activeComponent === 'profile' }"
          style="cursor: pointer;"
          @click="$emit('changeComponent', 'profile')"
        >
          <div class="d-flex align-items-center py-2">
            <span :class="{ 'fw-semibold': activeComponent === 'profile' }">
              Profile details
            </span>
          </div>
        </li>

        <!-- Password -->
        <li 
          class="list-group-item border-0"
          :class="{ 'bg-light': activeComponent === 'password' }"
          style="cursor: pointer;"
          @click="$emit('changeComponent', 'password')"
        >
          <div class="d-flex align-items-center py-2">
            <span :class="{ 'fw-semibold': activeComponent === 'password' }">
              Change Password
            </span>
          </div>
        </li>

        <!-- History -->
        <li 
          class="list-group-item border-0"
          :class="{ 'bg-light': activeComponent === 'history' }"
          style="cursor: pointer;"
          @click="$emit('changeComponent', 'history')"
        >
          <div class="d-flex align-items-center py-2">
            <span :class="{ 'fw-semibold': activeComponent === 'history' }">
              Transaction History
            </span>
          </div>
        </li>

      </ul>
    </div>
  </div>
</template>

<script setup>
defineProps({
  activeComponent: {
    type: String,
    required: true,
    default: 'profile'
  }
})

defineEmits(['changeComponent'])
</script>
<template>
  <div class="container py-5">
    <div class="row g-4">
      <div class="col-lg-3 col-md-4">
        <UserMenu 
          :activeComponent="activeComponent" 
          @changeComponent="navigateToComponent" 
        />
      </div>
      <div class="col-lg-9 col-md-8">
        <component :is="activeComponentFile"></component>
      </div>

    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'

// Import Komponen
import UserMenu from '../Users/UserMenu.vue'
import PersonalInfo from '../Users/PersonalInfo.vue'
import ChangePassword from '../Users/ChangePassword.vue'
import TransactionHistory from '../Users/TransactionHistory.vue'

const route = useRoute()
const router = useRouter()

const componentsMap = {
    'profile': PersonalInfo,
    'password': ChangePassword,
    'history': TransactionHistory
}

const activeComponent = computed(() => {
    return route.params.component || 'profile';
})

const activeComponentFile = computed(() => {
    return componentsMap[activeComponent.value] || PersonalInfo;
})

const navigateToComponent = (componentName) => {
    router.push({
        name: 'UserPage',
        params: { component: componentName }
    })
}
</script>
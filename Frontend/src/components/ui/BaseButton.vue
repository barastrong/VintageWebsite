<template>
  <button 
    :type="type"
    :class="buttonClasses"
    :style="customStyle"
    :disabled="disabled"
    @click="$emit('click', $event)"
  >
    <slot></slot>
  </button>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  variant: {
    type: String,
    default: 'primary',
    validator: (value) => ['primary', 'secondary', 'danger', 'outline', 'light', 'link'].includes(value)
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md', 'lg'].includes(value)
  },
  type: {
    type: String,
    default: 'button'
  },
  disabled: {
    type: Boolean,
    default: false
  },
  customClass: {
    type: String,
    default: ''
  },
  customStyle: {
    type: String,
    default: ''
  }
})

defineEmits(['click'])

const buttonClasses = computed(() => {
  const classes = ['btn']
  
  // Variant classes
  const variantMap = {
    primary: 'btn-primary',
    secondary: 'btn-secondary',
    danger: 'btn-danger',
    outline: 'btn-outline-primary',
    light: 'btn-light',
    link: 'btn-link'
  }
  
  classes.push(variantMap[props.variant])
  
  // Size classes
  if (props.size === 'sm') classes.push('btn-sm')
  if (props.size === 'lg') classes.push('btn-lg')
  
  // Custom classes
  if (props.customClass) classes.push(props.customClass)
  
  return classes.join(' ')
})
</script>

<style scoped>
.btn-primary:hover {
  background-color: #17a2b8 !important;
  border-color: #17a2b8 !important;
}

.btn-outline-primary:hover {
  background-color: #17a2b8 !important;
  border-color: #17a2b8 !important;
  color: white !important;
}
</style>

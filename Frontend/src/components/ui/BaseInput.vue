<template>
  <div class="mb-3">
    <label v-if="label" :for="id" :class="labelClass">
      {{ label }} <span v-if="required" class="text-danger">*</span>
    </label>
    <div :class="{ 'position-relative': hasIcon }">
      <input
        :id="id"
        :type="inputType"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :placeholder="placeholder"
        :required="required"
        :disabled="disabled"
        :class="inputClasses"
        :style="customStyle"
      />
      <slot name="icon"></slot>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: {
    type: [String, Number],
    default: ''
  },
  type: {
    type: String,
    default: 'text'
  },
  label: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: ''
  },
  required: {
    type: Boolean,
    default: false
  },
  disabled: {
    type: Boolean,
    default: false
  },
  id: {
    type: String,
    required: true
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md', 'lg'].includes(value)
  },
  customClass: {
    type: String,
    default: ''
  },
  labelClass: {
    type: String,
    default: 'form-label'
  },
  customStyle: {
    type: String,
    default: ''
  },
  hasIcon: {
    type: Boolean,
    default: false
  }
})

defineEmits(['update:modelValue'])

const inputType = computed(() => props.type)

const inputClasses = computed(() => {
  const classes = ['form-control']
  
  if (props.size === 'lg') classes.push('form-control-lg')
  if (props.size === 'sm') classes.push('form-control-sm')
  if (props.hasIcon) classes.push('pe-5')
  if (props.customClass) classes.push(props.customClass)
  
  return classes.join(' ')
})
</script>

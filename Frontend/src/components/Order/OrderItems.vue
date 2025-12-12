<template>
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
      <h5 class="fw-semibold mb-4">Order</h5>
      
      <div 
        v-for="item in orderItems" 
        :key="item.id" 
        class="d-flex align-items-center mb-3 pb-3 border-bottom"
      >
        <div 
          class="rounded me-3 order-item-image"
          :style="{ 
            backgroundImage: item.image && item.image.startsWith('http') 
                             ? `url(${item.image})` 
                             : item.image.startsWith('#') 
                               ? `linear-gradient(135deg, ${item.image} 25%, transparent 25%, transparent 50%, ${item.image} 50%, ${item.image} 75%, transparent 75%, transparent)`
                               : `url(${item.image})`, /* Jika image adalah path, gunakan url() */
            backgroundSize: item.image.startsWith('#') ? '20px 20px' : 'cover',
            backgroundPosition: 'center'
          }"
        />
        <div class="flex-grow-1">
          <h6 class="mb-1">{{ item.name }}</h6>
          <p class="text-muted small mb-1">{{ item.size }}</p>
          <p class="fw-semibold mb-0">Rp{{ item.price.toLocaleString('id-ID') }}</p>
        </div>
        <div class="text-muted">
          x{{ item.quantity }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'OrderItems',
  props: {
    orderItems: {
      type: Array,
      required: true
    }
  }
}
</script>

<style scoped>
.order-item-image {
  width: 60px;
  height: 60px;
  background-repeat: no-repeat;
}
</style>
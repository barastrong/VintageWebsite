<template>
  <div class="container py-4">
    <h2 class="fw-bold mb-4">My Order</h2>
    
    <div v-for="order in orders" :key="order.id" class="card border-0 shadow-sm mb-3">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
          <div class="d-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#17a2b8" viewBox="0 0 16 16">
              <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
            </svg>
            <span class="fw-semibold">{{ order.status }}</span>
          </div>
          <span class="text-muted">{{ order.date }}</span>
          <span class="badge border border-success text-success bg-white px-3 py-2">
              {{ order.statusBadge }}
          </span>
          <span class="text-muted ms-auto">{{ order.orderNumber }}</span>
        </div>

        <!-- Perubahan di sini: align-items-start agar konten mulai dari atas -->
        <div class="row align-items-start mb-3">
          <div class="col">
            <div v-if="order.items.length > 0" class="d-flex align-items-start gap-3">
              <!-- Bagian Kiri: Gambar dan Teks Tambahan -->
              <div 
                class="d-flex flex-column align-items-start"
                style="flex-shrink: 0;"
              >
                <!-- Gambar Produk -->
                <div 
                  class="rounded"
                  :style="{ 
                    backgroundColor: order.items[0].image,
                    width: '80px',
                    height: '80px',
                  }"
                />
                <!-- Teks "+ X more products" di bawah gambar -->
                <p v-if="order.additionalItems > 0" class="text-muted mt-2 mb-0 small">
                  + {{ order.additionalItems }} more products
                </p>
                <p v-else class="text-muted mt-2 mb-0 small invisible">
                  &nbsp;
                </p>
              </div>

              <!-- Detail Produk Pertama -->
              <div class="flex-grow-1">
                <!-- JUDUL PRODUK -->
                <h6 class="mb-2">{{ order.items[0].name }}</h6> 
                <p class="text-muted mb-1 small">
                  {{ order.items[0].quantity }} product x Rp{{ formatPrice(order.items[0].price) }}
                </p>
                <p class="text-muted mb-0 small">{{ order.items[0].size }}</p>
              </div>
            </div>
            <EmptyHistory v-else />
          </div>
          
          <!-- Perubahan di sini: Tambahkan align-self-start untuk total harga -->
          <div class="col-auto text-end align-self-start">
            <p class="text-muted mb-1 small">Total price</p>
            <h5 class="fw-bold mb-0 product-title-aligned-price">Rp{{ formatPrice(order.totalPrice) }}</h5>
          </div>
        </div>

        <div class="d-flex justify-content-end pt-3 border-top">
          <button 
            @click="handleBuyAgain(order.id)"
            class="btn text-white fw-semibold px-4"
            :style="{ backgroundColor: '#17a2b8', border: 'none' }"
          >
            Buy Again
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import BaseButton from '@/components/ui/BaseButton.vue';
import EmptyHistory from '../Empty/EmptyHistory.vue';

const router = useRouter();

const formatPrice = (price) => {
  if (typeof price !== 'number' || isNaN(price)) {
    return '0';
  }
  return price.toLocaleString('id-ID');
};

const orders = ref([
  {
    id: 1,
    status: 'Shopping',
    date: 'Aug 23, 2023',
    statusBadge: 'Done',
    orderNumber: 'ORD-20230613/XXII/VI/192093O123',
    items: [
      {
        name: 'Too Busy To Care Crop Tee And Jogger Set - Heather Grey',
        quantity: 1,
        price: 200000,
        size: '8 / M',
        image: '#4A4A4A'
      }
    ],
    additionalItems: 2,
    totalPrice: 400000
  },
  {
    id: 2,
    status: 'Shopping',
    date: 'Aug 23, 2023',
    statusBadge: 'Done',
    orderNumber: 'ORD-20230613/XXII/VI/192093O123',
    items: [
      {
        name: "Can't Deny This Feeling Lace Top - Black",
        quantity: 1,
        price: 200000,
        size: '8 / M',
        image: '#87CEEB'
      }
    ],
    additionalItems: 0,
    totalPrice: 200000
  },
  {
    id: 3,
    status: 'Shopping',
    date: 'Aug 23, 2023',
    statusBadge: 'Done',
    orderNumber: 'ORD-20230613/XXII/VI/192093O123',
    items: [
      {
        name: 'Tiger Heart Swimsuit - White/combo',
        quantity: 1,
        price: 200000,
        size: '8 / M',
        image: '#FFD700'
      }
    ],
    additionalItems: 2,
    totalPrice: 400000
  },
  {
    id: 4,
    status: 'Shopping',
    date: 'Aug 23, 2023',
    statusBadge: 'Done',
    orderNumber: 'ORD-20230613/XXII/VI/192093O123',
    items: [
      {
        name: 'Olivia Office Chic Pants - Black',
        quantity: 1,
        price: 200000,
        size: '8 / M',
        image: '#2C5F2D'
      }
    ],
    additionalItems: 2,
    totalPrice: 400000
  },
  {
    id: 5,
    status: 'Shopping',
    date: 'Aug 23, 2023',
    statusBadge: 'Done',
    orderNumber: 'ORD-20230613/XXII/VI/192093O123',
    items: [
      {
        name: 'Sequin Face Mask - Black',
        quantity: 1,
        price: 200000,
        size: '8 / M',
        image: '#1C1C1C'
      }
    ],
    additionalItems: 2,
    totalPrice: 400000
  }
]);

const handleBuyAgain = (orderId) => {
  console.log('Buy again order:', orderId);
  alert('Adding items to cart...');
};
</script>
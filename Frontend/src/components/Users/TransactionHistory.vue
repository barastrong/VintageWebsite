<template>
  <div class="container py-4">
    <h2 class="fw-bold mb-4">My Order</h2>
    
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-info" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="mt-2 text-muted">Fetching order history...</p>
    </div>

    <EmptyHistory v-else-if="!orders.length" />

    <div v-else>
      <div v-for="order in orders" :key="order.orderId" class="card border-0 shadow-sm mb-3">
        <div class="card-body p-4">
          <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
            <div class="d-flex align-items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#17a2b8" viewBox="0 0 16 16">
                <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
              </svg>
              <span class="fw-semibold">{{ order.status }}</span>
            </div>
            <span class="text-muted">{{ order.date }}</span>
            <span :class="['badge', order.statusBadge.includes('Done') ? 'border border-success text-success bg-white' : 'bg-warning text-dark', 'px-3', 'py-2']">
                {{ order.statusBadge }}
            </span>
            <span class="text-muted ms-auto">{{ order.orderNumber }}</span>
          </div>

          <div class="row align-items-start mb-3">
            <div class="col">
              <div v-if="order.items.length > 0" class="d-flex align-items-start gap-3">
                <div 
                  class="d-flex flex-column align-items-start"
                  style="flex-shrink: 0;"
                >
                  <div 
                    class="rounded order-item-image"
                    :style="{ 
                      backgroundImage: order.items[0].image && !order.items[0].image.startsWith('#') ? `url(${order.items[0].image})` : order.items[0].image.startsWith('#') ? `linear-gradient(135deg, ${order.items[0].image} 25%, transparent 25%, transparent 50%, ${order.items[0].image} 50%, ${order.items[0].image} 75%, transparent 75%, transparent)` : 'none',
                      backgroundSize: order.items[0].image.startsWith('#') ? '20px 20px' : 'cover',
                      backgroundPosition: 'center',
                      width: '80px',
                      height: '80px',
                    }"
                  />
                  <p v-if="order.additionalItems > 0" class="text-muted mt-2 mb-0 small">
                    + {{ order.additionalItems }} more products
                  </p>
                  <p v-else class="text-muted mt-2 mb-0 small invisible">
                    &nbsp;
                  </p>
                </div>

                <div class="flex-grow-1">
                  <h6 class="mb-2">{{ order.items[0].name }}</h6> 
                  <p class="text-muted mb-1 small">
                    {{ order.items[0].quantity }} product x Rp{{ formatPrice(order.items[0].price) }}
                  </p>
                  <p class="text-muted mb-0 small">{{ order.items[0].size }}</p>
                </div>
              </div>
              <EmptyHistory v-else />
            </div>
            
            <div class="col-auto text-end align-self-start">
              <p class="text-muted mb-1 small">Total price</p>
              <h5 class="fw-bold mb-0 product-title-aligned-price">Rp{{ formatPrice(order.totalPrice) }}</h5>
            </div>
          </div>

          <div class="d-flex justify-content-end pt-3 border-top">
            <button 
              @click="handleBuyAgain(order.orderId)"
              class="btn text-white fw-semibold px-4"
              :style="{ backgroundColor: '#17a2b8', border: 'none' }"
            >
              Buy Again
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import EmptyHistory from '../Empty/EmptyHistory.vue';
import BaseButton from '../ui/BaseButton.vue'

const router = useRouter();
const BASE_URL = 'http://localhost/FinalTest/Backend';
const IMAGE_BASE_URL = 'http://localhost/FinalTest/Backend/';

const orders = ref([]);
const loading = ref(true);

const formatPrice = (price) => {
  if (typeof price !== 'number' || isNaN(price)) {
    return '0';
  }
  return price.toLocaleString('id-ID');
};

const generateOrderNumber = (orderId, dateString) => {
    const datePart = new Date(dateString).toISOString().slice(0, 10).replace(/-/g, '');
    return `ORD-${datePart}/${String(orderId).padStart(6, '0')}`;
};

const handleBuyAgain = async (orderId) => {
  const userId = localStorage.getItem('id'); 
  if (!userId) return;

  try {
    const response = await fetch(`${BASE_URL}/create_new_order.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        user_id: parseInt(userId),
        order_id: orderId,
      })
    });

    // AMBIL TEKS MENTAH DULU (Cuma boleh panggil .text() SEKALI)
    const rawResponse = await response.text();
    console.log("Raw Response dari PHP:", rawResponse);

    let data;
    try {
      data = JSON.parse(rawResponse); // Ubah teks ke JSON manual
    } catch (e) {
      console.error("PHP tidak kirim JSON valid! Isinya malah ini:", rawResponse);
      throw new Error("Server tidak mengirim format JSON yang benar. Cek console.");
    }

    if (data.success) {
      router.push('/order');
    } else {
      alert(`Gagal: ${data.message}`);
    }

  } catch (error) {
    console.error('Error Detail:', error);
    alert(`Error: ${error.message}`);
  }
};

const fetchOrderHistory = async () => {
  loading.value = true;
  const userId = localStorage.getItem('id');

  if (!userId) {
    loading.value = false;
    return;
  }

  try {
    const response = await fetch(`${BASE_URL}/history.php?user_id=${userId}`);
    const data = await response.json();

    if (data.success && data.data.length > 0) {
      // Ubah logika grouping: gunakan Map/Array untuk mempertahankan urutan dari API
      const groupedOrdersMap = new Map();

      data.data.forEach(item => {
        const orderId = item.id;

        if (!groupedOrdersMap.has(orderId)) {
          groupedOrdersMap.set(orderId, {
            orderId: orderId,
            status: 'Shopping', 
            // Pastikan Anda menampilkan waktu/tanggal dari updated_at untuk sorting yang benar
            date: new Date(item.updated_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }), 
            statusBadge: 'Done', 
            orderNumber: generateOrderNumber(orderId, item.updated_at),
            items: [],
            totalPrice: parseInt(item.grand_price), // Total price adalah grand_price per Order ID
            additionalItems: 0,
            updatedAtRaw: item.updated_at, // Simpan untuk sorting tambahan jika perlu
          });
        }
        
        const order = groupedOrdersMap.get(orderId);
        const itemPrice = parseInt(item.price) / parseInt(item.quantity);
        const imageUrl = item.product_image && !item.product_image.startsWith('http') 
          ? IMAGE_BASE_URL + item.product_image 
          : item.product_image || '#E8E8E8';

        order.items.push({
          name: item.name,
          quantity: parseInt(item.quantity),
          price: itemPrice,
          size: item.product_size || 'N/A',
          image: imageUrl
        });
      });

      const finalOrders = Array.from(groupedOrdersMap.values()).map(order => {
        order.additionalItems = order.items.length > 1 ? order.items.length - 1 : 0;
        return order;
      });
      
      finalOrders.sort((a, b) => new Date(b.updatedAtRaw) - new Date(a.updatedAtRaw));

      orders.value = finalOrders;

    } else {
      orders.value = [];
    }
  } catch (error) {
    console.error('Error fetching order history:', error);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchOrderHistory();
});
</script>

<style scoped>
.order-item-image {
  background-repeat: no-repeat;
}
</style>
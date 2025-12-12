<template>
  <div class="card border-0 shadow-sm">
    <div class="card-body p-4 p-md-5">
      <h4 class="fw-semibold mb-4">Transaction History</h4>

      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th scope="col">Order ID</th>
              <th scope="col">Date</th>
              <th scope="col">Item</th>
              <th scope="col">Total</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="trx in transactions" :key="trx.id">
              <td class="fw-bold">#{{ trx.orderId }}</td>
              <td class="text-muted">{{ trx.date }}</td>
              <td>{{ trx.item }}</td>
              <td class="fw-bold">Rp {{ trx.total }}</td>
              <td>
                <span 
                  class="badge rounded-pill"
                  :class="getStatusClass(trx.status)"
                >
                  {{ trx.status }}
                </span>
              </td>
              <td>
                <button class="btn btn-sm btn-outline-secondary">Detail</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <!-- Pesan jika kosong -->
      <div v-if="transactions.length === 0" class="text-center py-5 text-muted">
        <p>No transactions yet.</p>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

// Data Dummy
const transactions = ref([
  { id: 1, orderId: 'TRX-9981', date: '12 Oct 2023', item: 'Vintage Leather Jacket', total: '450.000', status: 'Completed' },
  { id: 2, orderId: 'TRX-9982', date: '15 Oct 2023', item: 'Denim Jeans 90s', total: '250.000', status: 'Pending' },
  { id: 3, orderId: 'TRX-9983', date: '20 Oct 2023', item: 'Retro Sunglasses', total: '120.000', status: 'Cancelled' },
])

const getStatusClass = (status) => {
  if (status === 'Completed') return 'bg-success'
  if (status === 'Pending') return 'bg-warning text-dark'
  if (status === 'Cancelled') return 'bg-danger'
  return 'bg-secondary'
}
</script>
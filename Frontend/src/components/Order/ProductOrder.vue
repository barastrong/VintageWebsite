<template>
  <div>
    <!-- Address -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body p-4">
        <h5 class="fw-semibold mb-3">Address</h5>
        
        <div class="d-flex align-items-start">
          <div class="me-3">
            <div 
              class="d-flex align-items-center justify-content-center rounded-circle"
              style="width: 40px; height: 40px; background-color: #e3f2fd"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#17a2b8" viewBox="0 0 16 16">
                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
              </svg>
            </div>
          </div>
          <div>
            <h6 class="fw-semibold mb-1">PT. Timedoor Indonesia</h6>
            <p class="text-muted mb-0" style="font-size: 0.95rem">
              Jl. Tukad Yeh Aya IX No.46, Renon, Denpasar Selatan, Kota Denpasar, Bali 80226
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Delivery Details -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body p-4">
        <h5 class="fw-semibold mb-3">Delivery details</h5>
        
        <div class="d-flex align-items-start">
          <div class="me-3">
            <div 
              class="d-flex align-items-center justify-content-center rounded-circle"
              style="width: 40px; height: 40px; background-color: #e3f2fd"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#009499" viewBox="0 0 16 16">
                <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
              </svg>
            </div>
          </div>
          <div class="flex-grow-1">
            <h6 class="fw-semibold mb-1">Fedex Express Shipping</h6>
            <p class="text-muted mb-2" style="font-size: 0.95rem">Rp20.000</p>
            <div class="d-flex align-items-center text-muted small">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
              </svg>
              Home delivery in 1-3 working days
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment Method -->
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4">
        <h5 class="fw-semibold mb-3">Payment Method</h5>
        
        <div class="d-flex align-items-center">
          <div class="me-3">
              <img 
                src="@/assets/visa2.png" 
                alt="VISA" 
                style="width: 75px; height: auto;"
              >
          </div>
          <div>
            <h6 class="mb-1">0819283210323</h6>
            <p class="text-muted mb-0 small">23/12 • 123</p>
            <div class="d-flex align-items-center text-muted small mt-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
              </svg>
              Jack Daniel Arya
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProductOrder'
}
</script>
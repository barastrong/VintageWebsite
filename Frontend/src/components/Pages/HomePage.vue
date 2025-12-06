<template>
  <!-- Hero Section -->
  <div class="bg-primary text-white py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h1 class="display-4 fw-bold mb-3">Welcome to Our App</h1>
          <p class="lead mb-4">Discover amazing features and build something great with Vue.js</p>
          <router-link to="/hello" class="btn btn-light btn-lg me-3">
            <i class="fas fa-rocket me-2"></i>Get Started
          </router-link>
          <button class="btn btn-outline-light btn-lg">
            <i class="fas fa-play me-2"></i>Watch Demo
          </button>
        </div>
        <div class="col-lg-6 text-center">
          <i class="fas fa-code display-1 opacity-75"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Features Section -->
  <div class="container py-5">
    <div class="row text-center mb-5">
      <div class="col-12">
        <h2 class="fw-bold mb-3">Why Choose Us?</h2>
        <p class="text-muted">Powerful features to help you build better applications</p>
      </div>
    </div>
    
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <i class="fas fa-bolt text-warning display-4 mb-3"></i>
            <h5 class="card-title">Fast Performance</h5>
            <p class="card-text text-muted">Lightning fast loading times and optimized performance for the best user experience.</p>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <i class="fas fa-shield-alt text-success display-4 mb-3"></i>
            <h5 class="card-title">Secure & Reliable</h5>
            <p class="card-text text-muted">Built with security in mind and reliable infrastructure to keep your data safe.</p>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <i class="fas fa-mobile-alt text-info display-4 mb-3"></i>
            <h5 class="card-title">Mobile Friendly</h5>
            <p class="card-text text-muted">Responsive design that works perfectly on all devices and screen sizes.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="bg-light py-5">
    <div class="container text-center">
      <h3 class="fw-bold mb-3">Ready to Get Started?</h3>
      <p class="text-muted mb-4">Join thousands of users who trust our platform</p>
      <router-link to="/hello" class="btn btn-primary btn-lg">
        <i class="fas fa-arrow-right me-2"></i>Start Now
      </router-link>
    </div>
  </div>
</template>

<style scoped>
.bg-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
  transition: transform 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
}
</style>
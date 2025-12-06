<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3 shadow-sm">
    <div class="container-fluid px-5">
      <!-- Logo and Brand -->
      <a class="navbar-brand d-flex align-items-center" style="margin-left: 8rem" href="#">
        <img src="@/assets/Logo Horizontal.png" alt="Vintage Logo" style="height: 40px" />
      </a>

      <!-- Search Bar -->
      <div class="me-2" style="width: 900px">
        <div class="input-group input-group-lg">
          <span class="input-group-text bg-white border-end-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-muted" viewBox="0 0 16 16">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
          </span>
          <input 
            type="text" 
            class="form-control border-start-0 ps-0" 
            placeholder="Search for items"
            style="box-shadow: none"
          />
        </div>
      </div>

      <!-- Right side buttons -->
      <div class="d-flex align-items-center gap-3 me-5">
        <button class="btn px-4 py-2" style="border-color: #0D6B6F; color: #0D6B6F">
          Login
        </button>
        <button class="btn text-white px-4 py-2" style="background-color: #0D6B6F; border-color: #0D6B6F">
          Sign up
        </button>
        
        <!-- Language Dropdown -->
        <div class="dropdown ms-3">
          <button 
            class="btn btn-light dropdown-toggle px-3 py-2" 
            type="button" 
            id="languageDropdown" 
            data-bs-toggle="dropdown" 
            aria-expanded="false"
          >
            EN
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
            <li><a class="dropdown-item" href="#">EN - English</a></li>
            <li><a class="dropdown-item" href="#">ID - Indonesian</a></li>
            <li><a class="dropdown-item" href="#">ES - Spanish</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
</script>
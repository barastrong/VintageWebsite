<template>
  <div class="card border-0 shadow-sm">
    <div class="card-body p-4 p-md-5">
      <h4 class="fw-semibold mb-4">Edit Profile</h4>

      <!-- Photo Upload Section -->
      <div class="mb-4">
        <label class="form-label fw-semibold">Photo</label>
        <div class="d-flex align-items-center gap-3">
          
          <!-- Tampilkan Inisial User Jika userImage Kosong -->
          <div 
            v-if="!userImage" 
            class="rounded-circle d-flex align-items-center justify-content-center text-white fs-3 fw-bold"
            style="width: 80px; height: 80px; background-color: #17a2b8;"
          >
            {{ userInitials }} 
          </div>
          
          <!-- Gambar Profil yang Sebenarnya -->
          <img 
            v-else 
            :src="userImage" 
            alt="User Profile" 
            class="rounded-circle"
            style="width: 80px; height: 80px; object-fit: cover;"
          >

          <!-- Input File Tersembunyi -->
          <input 
            type="file" 
            ref="fileInput" 
            @change="onFileChange" 
            accept="image/jpeg,image/png"
            style="display: none;"
          />
          
          <!-- Tombol Choose - Menggunakan BaseButton -->
          <BaseButton 
            @click="handlePhotoUpload" 
            variant="outline"
            custom-class="btn-outline-secondary"
          >
            Choose
          </BaseButton>
          
          <span class="text-muted small">JPG, JPEG or PNG, 1 MB max.</span>
          
          <!-- Tombol Delete Photo - Menggunakan BaseButton -->
          <BaseButton 
            @click="showDeleteModal"
            variant="link"
            custom-class="text-danger ms-auto"
            custom-style="text-decoration: none;"
          >
            <!-- Trash Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
            </svg>
          </BaseButton>
        </div>
      </div>

      <!-- Full Name Input -->
      <BaseInput
        id="fullName"
        v-model="formData.fullName"
        type="text"
        label="Full name"
        placeholder=""
        size="lg"
      />

      <!-- Username Input -->
      <BaseInput
        id="username"
        v-model="formData.username"
        type="text"
        label="Username"
        placeholder=""
        size="lg"
      />

      <!-- Email Input -->
      <BaseInput
        id="email"
        v-model="formData.email"
        type="email"
        label="Email"
        placeholder=""
        size="lg"
      />

      <!-- Update Button -->
      <div class="d-flex justify-content-end">
        <BaseButton 
          @click="handleUpdateProfile"
          variant="primary"
          size="lg"
          custom-class="text-white fw-semibold px-5"
          custom-style="background-color: #17a2b8; border: none;"
        >
          Update Profile
        </BaseButton>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deletePhotoModal" tabindex="-1" aria-labelledby="deletePhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 380px">
      <div class="modal-content">
        <div class="modal-header border-0 pb-2">
          <h5 class="modal-title" id="deletePhotoModalLabel">Remove Photo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pt-0">
          Are you sure want to remove photo?
        </div>
        <div class="modal-footer border-0">
          <BaseButton variant="light" custom-style="background-color: #EDEDED; color: #000" data-bs-dismiss="modal">Cancel</BaseButton>
          <BaseButton variant="danger" @click="confirmDeletePhoto">Remove</BaseButton>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, onMounted, ref, computed, watch, nextTick } from 'vue' 
import BaseButton from '@/components/ui/BaseButton.vue' 
import BaseInput from '@/components/ui/BaseInput.vue'   
import { useAuth } from '@/stores/auth' 

const { user, checkAuth } = useAuth(); 

const API_GET_URL = 'http://localhost/FinalTest/Backend/get_user.php'; 
const API_UPDATE_URL = 'http://localhost/FinalTest/Backend/update_user.php'; 
const API_DELETE_IMAGE = 'http://localhost/FinalTest/Backend/remove_image.php'; 

const currentUserId = computed(() => {
    return user.value ? user.value.id : localStorage.getItem('id') || null; 
});

const userImage = ref(null); 
const fileInput = ref(null); 
const fileToUpload = ref(null); 

const formData = reactive({
  // Pastikan properti form data match dengan key di BaseInput (v-model)
  fullName: '',
  username: '',
  email: ''
})

const userInitials = computed(() => {
    const name = formData.username; 
    if (!name) return '';
    const parts = name.trim().split(/\s+/);

    if (parts.length >= 2) {
        const firstInitial = parts[0].charAt(0);
        const lastInitial = parts[parts.length - 1].charAt(0);
        return (firstInitial + lastInitial).toUpperCase();
    } else {
        return name.substring(0, 2).toUpperCase();
    }
});

const fetchUserData = async (userId) => { 
    console.log('--- Fetching User Data ---');
    console.log('User ID being used:', userId);

    if (!userId) {
        console.warn('Skipping fetch: User ID is null or undefined.');
        return;
    }
    
    try {
        const url = `${API_GET_URL}?id=${userId}`;
        console.log('Fetching URL:', url);
        const response = await fetch(url);
        
        if (!response.ok) {
            console.error(`HTTP error! Status: ${response.status}`);
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();

        console.log('Backend Response Data:', data);

        if (data.success) {
            // **PENGISIAN FORM DATA INI HARUS BENAR DAN KONSISTEN**
            formData.fullName = data.data.fullname || ''; 
            formData.username = data.data.username || '';
            formData.email = data.data.email || '';
            console.log('Form data filled:', formData.fullName, formData.username, formData.email); // Tambahkan log

            if (user.value) {
                const updatedUser = {
                    ...user.value,
                    fullname: data.data.fullname,
                    username: data.data.username,
                    email: data.data.email,
                    image: data.data.image 
                };
                user.value = updatedUser;
                localStorage.setItem('user', JSON.stringify(updatedUser));
            }
            
            if (data.data.image && data.data.image !== "") {
              userImage.value = 'http://localhost/FinalTest/Backend/' + data.data.image; 
              console.log('User Image URL:', userImage.value);
            } else {
              userImage.value = null; 
            }

            console.log('User data successfully loaded and form filled.');
        } else {
            console.error('Failed to load user data (API Success: false):', data.message);
        }
    } catch (error) {
        console.error('Fetch error:', error);
    }
}

onMounted(async () => {
    checkAuth();
    
    // Tunggu nextTick untuk memastikan store diperbarui dari localStorage
    await nextTick();

    if (currentUserId.value) {
        fetchUserData(currentUserId.value);
    }
});

watch(currentUserId, (newId, oldId) => {
    if (newId && newId !== oldId) {
        fetchUserData(newId);
    }
}, { immediate: false }); 

const handlePhotoUpload = () => {
    fileInput.value.click();
}

const onFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        if (file.size > 1048576) { 
            alert('File terlalu besar. Maksimal 1 MB.');
            return;
        }
        fileToUpload.value = file;
        userImage.value = URL.createObjectURL(file); 
    }
}

const showDeleteModal = () => {
    const modal = new bootstrap.Modal(document.getElementById('deletePhotoModal'));
    modal.show();
}

const confirmDeletePhoto = async () => {
    const modal = bootstrap.Modal.getInstance(document.getElementById('deletePhotoModal'));
    if (modal) modal.hide();

    const userId = currentUserId.value; 
    if (!userId) {
        alert('User ID not found. Please log in again.');
        return;
    }
    
    try {
        const response = await fetch(API_DELETE_IMAGE, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ userId: userId })
        });
        
        if (!response.ok) {
            const errorResult = await response.json();
            alert(`Gagal hapus foto (Status ${response.status}): ${errorResult.message}`);
            return; 
        }

        const result = await response.json();

        if (result.success) {
            userImage.value = null; 
            fileToUpload.value = null;
            
            if (user.value) {
                user.value.image = null;
                localStorage.setItem('user', JSON.stringify(user.value));
            }
            window.dispatchEvent(new Event('profileUpdated'));
        } else {
            alert(`Gagal hapus foto: ${result.message}`);
        }

    } catch (error) {
        console.error('Delete photo error:', error);
        alert('Gagal menghubungi server untuk hapus foto.');
    }
}

const handleUpdateProfile = async () => {
    const userId = currentUserId.value; 
    if (!userId) {
        alert('User ID not found. Please log in again.');
        return;
    }

    const formDataUpdate = new FormData();
    formDataUpdate.append('userId', userId);
    formDataUpdate.append('fullName', formData.fullName);
    formDataUpdate.append('username', formData.username);
    formDataUpdate.append('email', formData.email);
    
    if (fileToUpload.value && fileToUpload.value !== 'DELETE') {
        formDataUpdate.append('image', fileToUpload.value);
    }

    try {
        const response = await fetch(API_UPDATE_URL, {
            method: 'POST',
            body: formDataUpdate 
        });

        if (!response.ok) {
            const errorResult = await response.json();
            alert(`Update Gagal (Status ${response.status}): ${errorResult.message}`);
            return; 
        }

        const result = await response.json();

        if (result.success) {
            fileToUpload.value = null; 
            
            if (user.value) {
                const newImagePath = result.imagePath ? ('uploads/users/' + result.imagePath) : user.value.image;

                const updatedUser = {
                    ...user.value,
                    fullname: formData.fullName,
                    username: formData.username,
                    email: formData.email,
                    image: newImagePath 
                };
                user.value = updatedUser;
                localStorage.setItem('user', JSON.stringify(updatedUser));
            
                window.dispatchEvent(new Event('profileUpdated'));

                if (result.imagePath) {
                    userImage.value = 'http://localhost/FinalTest/Backend/' + result.imagePath;
                }
            }
        } else {
            alert(`Update Gagal: ${result.message}`);
        }

    } catch (error) {
        console.error('Update profile error:', error);
        alert('Gagal menghubungi server untuk update profile. Cek koneksi dan URL.');
    }
}
</script>
// auth.js
import { ref } from 'vue'

const user = ref(null)
const isAuthenticated = ref(false)

export function useAuth() {
  const checkAuth = () => {
    const userData = localStorage.getItem('user')
    if (userData) {
      user.value = JSON.parse(userData)
      isAuthenticated.value = true
    }
  }

  const login = (userData) => {
    user.value = userData
    isAuthenticated.value = true
    localStorage.setItem('user', JSON.stringify(userData))
  }

  const logout = () => {
    user.value = null
    isAuthenticated.value = false
    localStorage.removeItem('user')
    localStorage.removeItem('id') 
  }

  return {
    user,
    isAuthenticated, // <-- INI YANG AKAN DIGUNAKAN APP.VUE
    checkAuth,
    login,
    logout
  }
}
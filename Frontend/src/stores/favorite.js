import { ref } from 'vue'

const favoriteCount = ref(0)

export function useFavorite() {
  const fetchFavoriteCount = async () => {
    try {
      const user = JSON.parse(localStorage.getItem('user') || '{}')
      if (!user.id) {
        favoriteCount.value = 0
        return
      }
      
      const response = await fetch(`http://localhost/FinalTest/Backend/get_likes.php?user_id=${user.id}`)
      const data = await response.json()
      
      if (data.success) {
        favoriteCount.value = data.data ? data.data.length : 0
      } else {
        favoriteCount.value = 0
      }
    } catch (error) {
      console.error('Error fetching cart count:', error)
      favoriteCount.value = 0
    }
  }

  const incrementFavoriteCount = () => {
    favoriteCount.value++
  }

  const decrementFavoriteCount = () => {
    if (favoriteCount.value > 0) {
      favoriteCount.value--
    }
  }

  return {
    favoriteCount,
    fetchFavoriteCount,
    incrementFavoriteCount,
    decrementFavoriteCount
  }
}

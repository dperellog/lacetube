import { defineStore } from 'pinia'
import Auth from '@/services/Auth'

export const useUserStore = defineStore('user', {
  state: () => ({
    user: JSON.parse(localStorage.getItem('lacetubeUser'))
  }),
  getters: {
    doubleCount: (state) => state.count * 2,
    isLogged: (state) => state.user !== null
  },
  actions: {
    getCurrentUser() {
      return this.user;
    },
    loginUser(user) {
      this.user = user;
      localStorage.setItem('lacetubeUser', JSON.stringify(user));

    },
    logout() {
      Auth.logout()
        .then(() => {
          this.user = null;
          localStorage.removeItem('lacetubeUser');
        })
        .catch((error) => {
          if (error.response.status == 401) {
            this.user = null;
            localStorage.removeItem('lacetubeUser');
          }
          console.log('error :>> ', error);
        })
    }
  },
})

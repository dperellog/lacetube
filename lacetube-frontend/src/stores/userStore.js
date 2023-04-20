import { defineStore } from 'pinia'
import Auth from '@/services/Auth'
import router from '@/router/index'

export const useUserStore = defineStore('user', {
  state: () => ({
    user: JSON.parse(localStorage.getItem('lacetubeUser'))
  }),
  getters: {
    currentUser: (state) => state.user,
    isLogged: (state) => state.user !== null
  },
  actions: {
    loginUser(user) {
      this.user = user;
      localStorage.setItem('lacetubeUser', JSON.stringify(user));
      router.push('/tauler')
    },
    logout() {
      Auth.logout()
        .then(() => {
          this.user = null;
          localStorage.removeItem('lacetubeUser');
        })
        .then(() => router.push('/'))
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

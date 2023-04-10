import { defineStore } from 'pinia'
import Auth from '@/services/Auth'

export const useUserStore = defineStore('user', {
  state: () => ({ 
    user: JSON.parse(localStorage.getItem('lacetubeUser')),
    isLogged: false
  }),
  getters: {
    doubleCount: (state) => state.count * 2,
  },
  actions: {
    loginUser(user){
      this.user = user;

      localStorage.setItem('lacetubeUser', JSON.stringify(user));
      this.isLogged = true;
    },

    logout(){
      Auth.logout()
      .then(() => {
        this.user = null;
        this.isLogged = false;
        localStorage.removeItem('lacetubeUser');
      })
      .catch((error) => {
        console.log('error :>> ', error);
      })
    }
  },
})

import { defineStore } from 'pinia'
import Auth from '@/services/Auth'
import router from '@/router/index'

export const useUserStore = defineStore('user', {
  state: () => ({
    user: JSON.parse(localStorage.getItem('lacetubeUser')),
    userCourses: null,
    userActivities: null,
    userVideos: null,
  }),
  getters: {
    currentUser: (state) => state.user,
    isLogged: (state) => state.user !== null,
    canAccessGestio: (state) => {
      if (state.user != null) {
        let roles = state.user.roles.filter(value => ['admin', 'teacher'].includes(value));
        return roles.length > 0;
      } else {
        return false
      }
     
    }
  },
  actions: {
    loginUser(user) {
      this.user = user;
      this.roles = user.role;
      localStorage.setItem('lacetubeUser', JSON.stringify(user));
      router.push('/tauler')
    },
    logout() {
      Auth.logout()
        .then(() => {

          this.userCourses = null;
          this.userActivities = null;
          this.userVideos = null;
          
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
    },
    updatePassword(passwordForm) {
      return Auth.updatePassword(passwordForm)
    },
    hasRole(role){
      let roles = this.user.roles.filter(value => [role].includes(value));
      return roles.length > 0;
    },
    refreshAvatar(avatarURL){
      let currentUser = this.currentUser;
      currentUser.avatar = avatarURL;
      localStorage.setItem('lacetubeUser', JSON.stringify(currentUser));
    },
    setUserCourses(courses){
      this.userCourses = courses;
    },
    getUserCourses(){
      return this.userCourses;
    },
    setUserActivities(activities){
      this.userActivities = activities;
    },
    getUserActivities(){
      return this.userActivities;
    },
    setUserVideos(videos){
      this.userVideos = videos;
    },
    getUserVideos(){
      return this.userVideos;
    }
  },
})
<template>

  <header-guest v-if="!userStore.isLogged"></header-guest>
  <header-user v-else
  @logoutUser="logout"
  ></header-user>

</template>

<script>
import HeaderGuest from './headers/HeaderGuest.vue';
import HeaderUser from './headers/HeaderUser.vue';
import { useUserStore } from '../stores/userStore';

export default {
  components: {
    HeaderGuest,
    HeaderUser
  },
  setup() {
    const userStore = useUserStore();

    return {
      userStore: userStore
    }
  },
  data() {
    return {
      
    }
  },
  methods : {
    logout(){
      this.userStore.logout();
    }
  }

}
</script>
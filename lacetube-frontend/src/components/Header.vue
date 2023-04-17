<template>
  <header class="pt-2 pb-3 mb-3 border-bottom fo-header">
  <header-guest v-if="!userStore.isLogged"></header-guest>
  <header-user v-else
  @logoutUser="logout"
  ></header-user>
</header>

</template>

<style scoped>
header {
  box-shadow: rgba(149, 157, 165, 0.223) 0px 0px 24px;
}
</style>

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
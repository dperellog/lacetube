<template>

  <header-guest v-if="!loggedIn"></header-guest>
  <header-user v-else></header-user>

</template>

<script>
import HeaderGuest from './headers/HeaderGuest.vue';
import HeaderUser from './headers/HeaderUser.vue';

export default {
  components: {
    HeaderGuest,
    HeaderUser
  },
  data() {
    return {
      'loggedIn' : false
    }
  }

}
</script>
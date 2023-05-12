<template>
  <header class="pt-2 pb-3 mb-3 border-bottom fo-header">
  <header-guest v-if="!userStore.isLogged"></header-guest>
  <header-user v-else
  @logoutUser="logout"
  ></header-user>
  <!-- Modal tancant sessió -->
  <div class="modal fade" id="tancantSessio" tabindex="-1" aria-labelledby="tancantSessio" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          Tancant sessió...
        </div>
        <div class="modal-body">
          <span class="text-secondary">S'està tancant la sessió... </span>
          <div class="spinner-border spinner-border-sm text-secondary me-1" role="status">
            <span class="visually-hidden">Tancant Sessió...</span>
          </div>
          <p class="h6 fw-bold">Si passat uns segons aquesta pantalla no desapareix, refresqueu la pàgina.</p>
        </div>
      </div>

    </div>
  </div>
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
import { useUserStore } from '@/stores/userStore';

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
  mounted(){
    this.logoutAlert = bootstrap.Modal.getOrCreateInstance('#tancantSessio');
  },
  data() {
    return {
      logoutAlert: null
    }
  },
  methods : {
    logout(){
      this.logoutAlert.show()
      this.userStore.logout();    }
  },
  beforeUnmount() {
    this.logoutAlert.hide()
  }

}
</script>
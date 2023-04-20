<template>
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-around">
        <router-link to="/" class="col-2 navbar-brand"><img src="@/assets/logos/logo-fo.png" class="header-img header-logo"></router-link>

        <form class="col-7 mt-3 mb-3 mb-lg-0 me-lg-3">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>

        <router-link to="/tauler" class="btn col-sm-2 col-lg-1 btn-warning mt-3 rounded-pill fw-bold">Tauler</router-link>

        <div class="dropdown col-1 text-end mt-4">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUsuari" data-bs-toggle="dropdown" aria-expanded="false">
            <avatar :url="userStore.currentUser.avatar" :size="'sm'"></avatar>
          </a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUsuari">
            <li><router-link to="/cursos" class="dropdown-item">Cursos</router-link></li>
            <li><a class="dropdown-item" href="#">Els meus videos</a></li>
            <li><a class="dropdown-item" href="#">El meu perfil</a></li>
            <li><a class="dropdown-item" href="#">Configuració</a></li>
            <div v-if="userStore.canAccessGestio">
              <li><hr class="dropdown-divider"></li>
              <li><router-link to="/gestio" class="dropdown-item">Panell de gestió</router-link></li>
            </div>
            <li><hr class="dropdown-divider"></li>
            <li><button @click="$emit('logoutUser')" class="dropdown-item" href="#">Tancar sessió</button></li>
          </ul>
        </div>
      </div>
    </div>
</template>

<script>
import { RouterLink, RouterView } from 'vue-router'
import { useUserStore } from '@/stores/userStore'
import Avatar from '../common/Avatar.vue';

export default {
  components: {
    RouterLink,
    Avatar
  },
  setup() {
    const userStore = useUserStore();

    return {
      userStore: userStore
    }
  },
  methods : {
  }

}
</script>

<style scoped>
.dropdown-toggle::after{
  vertical-align: 1.3em;
  margin-left: 0.5em;
}
</style>
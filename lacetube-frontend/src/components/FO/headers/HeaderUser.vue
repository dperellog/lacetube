<template>
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-around">
      <router-link to="/" class="col-2 navbar-brand"><img src="@/assets/logos/logo-fo.png"
          class="header-img header-logo"></router-link>

      <Search class="col-7 mt-3 mb-3 mb-lg-0 me-lg-3"></Search>

      <router-link to="/tauler" class="btn col-sm-2 col-lg-1 btn-warning mt-3 rounded-pill fw-bold">Tauler</router-link>

      <div class="dropdown col-1 text-end mt-4">
        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUsuari"
          data-bs-toggle="dropdown" aria-expanded="false">
          <avatar :url="userService.getAvatarURLByAvatar(userStore.currentUser.avatar)" :size="'sm'"></avatar>
        </a>
        <ul class="dropdown-menu text-small px-2" aria-labelledby="dropdownUsuari">
          <div class="px-2">
              <li class="text-secondary text-left">{{ userStore.currentUser.name }}</li>
                        <li class="text-secondary text-left">{{ userStore.currentUser.email }}</li>
          </div>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><router-link to="/cursos" class="dropdown-item"><i class="fa-solid fa-graduation-cap"></i>&nbsp;&nbsp;Cursos</router-link></li>
          <li><a class="dropdown-item" href="#"><i class="fa-solid fa-video"></i>&nbsp;&nbsp;Els meus videos</a></li>
          <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user"></i>&nbsp;&nbsp;El meu perfil</a></li>
          <li><a class="dropdown-item" href="#">Configuració</a></li>
          <div v-if="userStore.canAccessGestio">
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><router-link to="/gestio" class="dropdown-item"><i class="fa-solid fa-gears"></i>&nbsp;&nbsp;Panell de gestió</router-link></li>
          </div>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><button @click="$emit('logoutUser')" class="dropdown-item" href="#">Tancar sessió</button></li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { useUserStore } from '@/stores/userStore'
import userService from '@/services/User';
import Avatar from '@/components/common/Avatar.vue';
import Search from '@/components/common/Search.vue';

export default {
  components: {
    Avatar,
    Search
  },
  setup() {
    const userStore = useUserStore();

    return {
      userService: userService,
      userStore: userStore
    }
  },
  methods: {
  }

}
</script>

<style scoped>.dropdown-toggle::after {
  vertical-align: 1.3em;
  margin-left: 0.5em;
}</style>
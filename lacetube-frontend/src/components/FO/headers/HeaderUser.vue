<template>
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-around">

      <!-- Logo Lacetube -->
      <router-link to="/" class="col-2 navbar-brand mx-2"><img src="@/assets/logos/logo-fo.png"
          class="header-img header-logo"></router-link>

      <!-- Barra de cerca -->
      <Search class="searchbar col-sm-7 mt-3 mb-3 mb-lg-0 me-lg-3 mx-2" userAuthenticated></Search>

      <!-- Tauler -->
      <router-link to="/tauler"
        class="btn-tauler btn col-sm-2 col-lg-1 mx-2 btn-warning mt-3 rounded-pill fw-bold">Tauler</router-link>

      <!-- Dropdown -->
      <div class="user-dropdown dropdown col-sm-1 text-end mt-4 mx-2">
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
          <li><router-link to="/tauler"
              class="btn-tauler-dropdown btn btn-warning my-3 rounded-pill fw-bold">Tauler</router-link></li>
          <li><router-link to="/cursos" class="dropdown-item"><i
                class="fa-solid fa-graduation-cap"></i>&nbsp;&nbsp;Cursos</router-link></li>
          <li><router-link to="/videos" class="dropdown-item"><i class="fa-solid fa-video"></i>&nbsp;&nbsp;Els meus videos</router-link></li>
          <li><router-link :to="{ path: '/usuari/' + userStore.currentUser.id }" class="dropdown-item"><i class="fa-solid fa-user"></i>&nbsp;&nbsp;El meu perfil</router-link></li>
          <li><router-link :to="{ path: '/configuracio/' }" class="dropdown-item"><i class="fa-solid fa-wrench"></i>&nbsp;&nbsp;Configuració</router-link></li>
          <div v-if="userStore.canAccessGestio">
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><router-link to="/gestio" class="dropdown-item"><i class="fa-solid fa-gears"></i>&nbsp;&nbsp;Panell de
                gestió</router-link></li>
          </div>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><button @click="tancarSessio" class="dropdown-item" href="#">Tancar sessió</button></li>
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
  emits: ['logoutUser'],
  setup() {
    const userStore = useUserStore();

    return {
      userService: userService,
      userStore: userStore
    }
  },
  methods: {
    tancarSessio() {
      this.$emit('logoutUser')
    }
  },

}
</script>

<style scoped>
.dropdown-toggle::after {
  vertical-align: 1.3em;
  margin-left: 0.5em;
}

.btn-tauler-dropdown {
  display: none;
}

@media screen and (max-width: 990px) {
  .btn-tauler {
    display: none;
  }

  .btn-tauler-dropdown {
    display: block;
  }

  .searchbar {
    margin-top: 2rem !important;
  }
}

@media screen and (max-width: 767px) {
  .header-logo {
    max-height: 4rem;

  }

  .navbar-brand {
    order: 1;
    /* default is 0 */
  }

  .user-dropdown {
    order: 3;
    /* default is 0 */
  }


  .searchbar {
    order: 2;
    /* default is 0 */
  }
}

@media screen and (max-width: 545px) {
  .navbar-brand {
    order: 1;
    /* default is 0 */
  }

  .user-dropdown {
    order: 2;
    /* default is 0 */
  }


  .searchbar {
    order: 3;
    /* default is 0 */
  }
}
</style>
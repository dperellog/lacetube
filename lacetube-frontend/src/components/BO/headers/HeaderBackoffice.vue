<template>
  <header class="pt-2 pb-3 mb-3 border-bottom bg-primary fo-header">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-around">
        <router-link to="/gestio" class="navbar-brand"><img src="@/assets/logos/logo-bo.png"
            class="header-img header-logo"></router-link>

        <nav class="navbar navbar-expand-lg navbar-dark mt-3 col-7">
          <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02"
              aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor02">
              <ul class="navbar-nav me-auto">

                <!-- MENU USUARIS -->

                <li class="nav-item dropdown me-2" v-if="userStore.hasRole('admin')">
                  <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="true" aria-expanded="false">Gestio Usuaris</a>
                  <div class="dropdown-menu">
                    <router-link to="/gestio/usuaris" class="dropdown-item"><i
                        class="fa-solid fa-user"></i>&nbsp;&nbsp;Gestió d'usuaris</router-link>
                    <div class="dropdown-divider"></div>
                    <router-link to="/gestio/usuaris/crear" class="dropdown-item"><i
                        class="fa-solid fa-plus"></i>&nbsp;&nbsp;Crear usuaris</router-link>
                  </div>
                </li>

                <!-- MENU CURSOS -->

                <li class="nav-item dropdown me-2">
                  <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="true" aria-expanded="false">Cursos</a>
                  <div class="dropdown-menu">
                    <router-link to="/gestio/cursos" class="dropdown-item"><i
                        class="fa-solid fa-graduation-cap"></i>&nbsp;&nbsp;Gestió de cursos</router-link>
                    <router-link to="/gestio/activitats" class="dropdown-item"><i
                        class="fa-solid fa-paintbrush"></i>&nbsp;&nbsp;Gestió d'activitats</router-link>
                    <div class="dropdown-divider"></div>
                    <router-link class="dropdown-item" to="/gestio/cursos/crear"><i
                        class="fa-solid fa-plus"></i>&nbsp;&nbsp;Crear Curs</router-link>
                    <router-link class="dropdown-item" to="/gestio/activitats?crear=true"><i
                        class="fa-solid fa-plus"></i>&nbsp;&nbsp;Crear Activitat</router-link>
                  </div>
                </li>

              </ul>

            </div>
          </div>
        </nav>



        <router-link to="/tauler" class="btn btn-secondary mt-3 px-4 rounded-pill fw-bold">Tauler</router-link>

        <div class="dropdown text-end mt-4">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle useroptions" id="dropdownUsuari"
            data-bs-toggle="dropdown" aria-expanded="false">
            <avatar :url="userService.getAvatarURLByAvatar(userStore.currentUser.avatar)" :size="'sm'"></avatar>
          </a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUsuari">
            <li><router-link to="/cursos" class="dropdown-item"><i
                  class="fa-solid fa-graduation-cap"></i>&nbsp;&nbsp;Cursos</router-link></li>
            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-video"></i>&nbsp;&nbsp;Els meus videos</a></li>
            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user"></i>&nbsp;&nbsp;El meu perfil</a></li>
            <li><a class="dropdown-item" href="#">Configuració</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><button @click="logout" class="dropdown-item" href="#">Tancar Sessió</button></li>
          </ul>
        </div>
      </div>

      <!-- Modal tancant sessió -->
      <div class="modal fade" id="tancantSessio" tabindex="-1" aria-labelledby="tancantSessio" data-bs-backdrop="static"
        aria-hidden="true">
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

            </div>
          </div>

        </div>
      </div>
    </div>
  </header>
</template>

<script>
import { RouterLink, RouterView } from 'vue-router'
import { useUserStore } from '@/stores/userStore'
import Avatar from '@/components/common/Avatar.vue';
import userService from '@/services/User';

export default {
  components: {
    RouterLink,
    Avatar
  },
  setup() {
    const userStore = useUserStore();

    return {
      userService: userService,
      userStore: userStore
    }
  },
  mounted() {
    this.logoutAlert = bootstrap.Modal.getOrCreateInstance('#tancantSessio');
  },
  data() {
    return {
      logoutAlert: null
    }
  },
  methods: {
    logout() {
      this.logoutAlert.show()
      this.userStore.logout();
    }
  },
  beforeUnmount() {
    this.logoutAlert.hide()
  }

}
</script>

<style scoped>
.navbar {
  padding: 0
}
</style>
<style scoped>
.useroptions.dropdown-toggle::after {
  vertical-align: 1.3em;
  margin-left: 0.5em;
}

.nav-link {
  font-size: 1.12rem;
}
</style>
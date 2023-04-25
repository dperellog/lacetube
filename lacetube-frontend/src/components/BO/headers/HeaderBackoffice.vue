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

                <li class="nav-item dropdown me-2">
                  <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="true" aria-expanded="false">Gestio Usuaris</a>
                  <div class="dropdown-menu">
                    <router-link to="/gestio/usuaris" class="dropdown-item" href="#">Gestió d'usuaris</router-link>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Crear Usuaris</a>
                    <a class="dropdown-item" href="#">Modificar Usuaris</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <a class="dropdown-item" href="#">Separated link</a>
                  </div>
                </li>

                <!-- MENU CURSOS -->

                <li class="nav-item dropdown me-2">
                  <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="true" aria-expanded="false">Cursos</a>
                  <div class="dropdown-menu">
                    <router-link to="/gestio/cursos" class="dropdown-item" href="#">Gestió de cursos</router-link>
                    <a class="dropdown-item" href="#">Gestió d'activitats</a>
                    <div class="dropdown-divider"></div>
                    <router-link class="dropdown-item" to="/gestio/cursos/crear">Crear Curs</router-link>
                    <a class="dropdown-item" href="#">Crear Activitat</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                  </div>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="#">Features</a>
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
            <li><router-link to="/login" class="dropdown-item">Login</router-link></li>
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><button @click="userStore.logout" class="dropdown-item" href="#">Sign out</button></li>
          </ul>
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
  }

}
</script>

<style scoped>
.navbar {padding: 0 }

</style>
<style scoped>
.useroptions.dropdown-toggle::after{
  vertical-align: 1.3em;
  margin-left: 0.5em;
}

.nav-link {
  font-size: 1.12rem;
}
</style>
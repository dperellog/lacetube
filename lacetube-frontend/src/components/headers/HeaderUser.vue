<template>
<header class="pt-2 pb-3 mb-3 border-bottom fo-header">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-around">
        <router-link to="/" class="navbar-brand"><img src="@/assets/logos/logo-fo.png" class="header-img header-logo"></router-link>

        <form class="col-7 mt-3 mb-3 mb-lg-0 me-lg-3">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>

        <router-link to="/tauler" class="btn btn-warning mt-3 px-4 rounded-pill fw-bold">Tauler</router-link>

        <div class="dropdown text-end mt-2">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUsuari" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="mdo" class="rounded-circle header-img">
          </a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUsuari">
            <li><router-link to="/login" class="dropdown-item">Login</router-link></li>
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><button @click="$emit('logoutUser')" class="dropdown-item" href="#">Sign out</button></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
import { RouterLink, RouterView } from 'vue-router'

export default {
  components: {
    RouterLink
  },
  methods : {

  }

}
</script>
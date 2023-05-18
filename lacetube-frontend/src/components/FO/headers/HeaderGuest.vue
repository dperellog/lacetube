<template>
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-around">
        
        <!-- Logo Lacetube -->
        <router-link to="/" class="col-2 navbar-brand mx-2"><img src="@/assets/logos/logo-fo.png"
          class="header-img header-logo"></router-link>

       <!-- Barra de cerca -->
      <Search class="searchbar col-sm-7 mt-3 mb-3 mb-lg-0 me-lg-3 mx-2"></Search>

      <!-- Botó de login -->
      <router-link to="/login" class="btn login-button btn-warning mt-3">Iniciar Sessió</router-link>
      </div>
    </div>
</template>

<script>
import Search from '@/components/common/Search.vue';

export default {
components: {
  Search
}

}
</script>
<style scoped>
@media screen and (max-width: 990px) {
  .searchbar {
    margin-top: 2rem !important;
    margin-right: 1rem !important;
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

  .login-button {
    order: 2;
    /* default is 0 */
  }


  .searchbar {
    order: 3;
    width: 80%;
  }
}</style>
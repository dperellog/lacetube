<template>
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-around">
        <router-link to="/" class="navbar-brand"><img src="@/assets/logos/logo-fo.png" class="header-img header-logo"></router-link>

        <form class="col-7 mt-3 mb-3 mb-lg-0 me-lg-3">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>

        <router-link to="/login" class="btn btn-warning mt-3">Iniciar Sessió</router-link>
      </div>
    </div>
</template>

<script>


export default {


}
</script>
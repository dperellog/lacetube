<template>
  <Header></Header>


  <section class="mt-4">
    <div class="container-fluid">
      <div class="row d-flex justify-content-around align-items-center">
        <div class="col-sm-6">
          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" class="img-fluid"
            alt="Sample image">
        </div>
        <div class="col-sm-5">
          <LoginForm class="me-sm-5">
          </LoginForm>
        </div>
      </div>
    </div>
  </section>

  <Footer></Footer>
</template>

<script>
import Header from '@/components/FO/Header.vue';
import Footer from '@/components/FO/Footer.vue';
import LoginForm from '@/components/FO/LoginForm.vue';

export default {
  components: {
    LoginForm,
    Footer,
    Header
  }
}
</script>


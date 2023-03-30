<template>
  <form @submit.prevent="submitForm">

    <!-- Email -->
    <div class="form-outline mb-4">
      <label class="form-label h6 text-secondary" for="login-email">Correu electrònic:</label>
      <input type="email" id="login-email" class="form-control form-control"
        placeholder="nom@domini.cat" />
    </div>

    <!-- Contrasenya -->
    <div class="form-outline mb-4">
      <label class="form-label h6 text-secondary" for="login-passwd">Contrasenya:</label>
      <input type="password" id="login-passwd" class="form-control form-control" />
    </div>

    <div class="d-flex justify-content-between align-items-center">
      <!-- Checkbox -->
      <div class="form-check mb-0">
        <input class="form-check-input me-2" type="checkbox" value="" id="rememberMeBtn" />
        <label class="form-check-label text-primary" for="rememberMeBtn">
          Recorda'm
        </label>
      </div>
      <a href="#!" class="text-body">Contrasenya olvidada?</a>
    </div>

    <div class="text-center text-lg-start mt-4 pt-2">
      <button type="button" class="btn btn-warning btn px-4">Iniciar Sessió</button>
    </div>

  </form>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    submitForm() {
      // Aquí llamamos a nuestro método que maneja la llamada al backend
      this.submitLogin(this.email, this.password);
    },
    submitLogin(email, password) {
      // Aquí haremos la llamada al backend para validar el inicio de sesión
      // Usaremos la librería axios para realizar una petición POST al endpoint '/login'
      axios.post('/login', {
        email: email,
        password: password
      })
        .then(response => {
          // Si el servidor responde con éxito, hacemos algo con los datos recibidos
          console.log(response.data);
        })
        .catch(error => {
          // Si hay algún error, lo manejamos aquí
          console.log(error);
        });
    }
  }
}
</script>

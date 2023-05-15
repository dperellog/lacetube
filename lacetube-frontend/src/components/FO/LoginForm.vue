<template>
  <form @submit.prevent="login">

    <!-- Email -->
    <div class="form-outline mb-4">
      <label class="form-label h6 text-secondary" for="login-email">Correu electrònic:</label>
      <input v-model="formData.email" type="email" id="login-email" class="form-control form-control"
        placeholder="nom@domini.cat" />
    </div>

    <!-- Contrasenya -->
    <div class="form-outline mb-4">
      <label class="form-label h6 text-secondary" for="login-passwd">Contrasenya:</label>
      <input v-model="formData.password" type="password" id="login-passwd" class="form-control form-control" />
    </div>

    <div class="text-left text-lg-start mt-4 pt-2">
      <input type="submit" value="Iniciar Sessió" class="btn btn-warning btn px-4"
        :disabled="formStatus.loading || !formIsValid">
    </div>

    <div class="mt-2" v-if="formStatus.loading">
      <div class="spinner-border spinner-border-sm text-secondary me-1" role="status">
        <span class="visually-hidden">Logging in...</span>
      </div>
      <span class="text-secondary">Iniciant sessió... </span>
    </div>

    <div class="mt-2" v-if="formStatus.error">
      <div class="alert alert-dismissible alert-danger">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Hi ha hagut un error!</strong>
        <p class="mb-0">{{ formStatus.errorMsg }}</p>
      </div>
    </div>


  </form>
</template>

<script>
import Auth from '../../services/Auth';
import { useUserStore } from '@/stores/userStore';

export default {
  name: 'loginForm',
  inheritAttrs: false,
  setup() {
    const userStore = useUserStore();

    return {
      userStore: userStore
    }
  },
  data() {
    return {
      formData: {
        email: '',
        password: '',
      },
      formStatus: {
        error: false,
        errorMsg: '',
        loading: false,
        valid: false
      }
    }
  },
  computed: {
    formIsValid() {
      return this.formData.email != '' && this.formData.password != '';
    }
  },
  beforeMount() {
    //this.store.increment();
  },
  methods: {
    async login() {
      //Reset defaults:
      this.formStatus.loading = true;
      this.formStatus.error = false;
      this.formStatus.errorMsg = '';
      let component = this

      Auth.login(this.formData)
        .then(function (user) {
          //Login success:
          component.userStore.loginUser(user.data);

        })
        .catch(function (error) {
          //Login Failed:
          component.formStatus.error = true;
          component.formStatus.errorMsg = error.response.data.message
        })
        .finally(() => {
          //Update UI:

          component.formStatus.loading = false;
        })

    }
  }
}
</script>

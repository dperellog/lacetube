<template>
  <HeaderBackoffice></HeaderBackoffice>
  <div class="main-content-section container mt-4 px-4">
    <h1 class="fw-bold">Crear nous usuaris:</h1>
    <h2 class="text-secondary"></h2>
    <section class="mt-4">

      <!-- Formulari -->
      <form class="">
        <div class="card taula">
          <table class="card-table table">
            <thead class="card-header capcalera-taula">
              <tr>
                <th>Nom</th>
                <th>Correu electrònic</th>
                <th>Rol</th>
                <th>Contrasenya</th>
                <th></th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="(usuari, index) in usuaris" :key="index" class="error">
                <td>
                  <input type="text" class="form-control" :class="{'is-invalid' :  usuari.errors.name}" v-model="usuari.user.name">
                  <div class="invalid-feedback" v-if="usuari.errors.name">
                    {{ usuari.errors.name }}
                  </div>
                </td>
                <td>
                  <input type="email" class="form-control" :class="{'is-invalid' :  usuari.errors.email}" v-model="usuari.user.email">
                  <div class="invalid-feedback" v-if="usuari.errors.email">
                    {{ usuari.errors.email }}
                  </div>
                </td>
                <td>
                  <select class="form-select" :class="{'is-invalid' :  usuari.errors.role}" v-model="usuari.user.role">
                    <option value="student">Alumne</option>
                    <option value="teacher">Professor</option>
                    <option value="admin">Administrador</option>
                  </select>
                  <div class="invalid-feedback" v-if="usuari.errors.role">
                    {{ usuari.errors.role }}
                  </div>
                </td>
                <td class="input-group">
                  <input :type="usuari.viewPassword ? 'text' : 'password'" class="form-control" :class="{'is-invalid' :  usuari.errors.password}" v-model="usuari.user.password">
                  <i class="fa-solid text-secondary"
                    :class="{ 'fa-eye-slash': usuari.viewPassword, 'fa-eye': !usuari.viewPassword }" @click="usuari.viewPassword = !usuari.viewPassword" id="togglePassword"></i>
                  <button class="btn btn-outline-primary btn-small" title="Generar contrasenya" type="button"
                    @click="generarContrasenya(usuari)"><i class="fa-solid fa-rotate"></i></button>
                  <div class="invalid-feedback" v-if="usuari.errors.password">
                    {{ usuari.errors.password }}
                  </div>
                </td>
                <td>
                  <button v-if="index > 0" class="btn btn-outline-danger" @click.prevent="usuaris.splice(index, 1)"><i class="fa-solid fa-trash"></i></button>
                  <button v-else class="btn btn-outline-danger" disabled><i class="fa-solid fa-trash"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
          <!-- Botó afegir més usuris -->
          <a href="#" class="showMore text-center card-footer" @click.prevent="afegirUsuariLlista"><i
              class="fa-solid fa-plus"></i>&nbsp;&nbsp;Afegir més usuaris</a>
        </div>

        <div class="text-start">
          <button type="submit" class="btn btn-success mt-3" @click.prevent="crearUsuaris" :disabled="!formValidat">Crear
            usuaris</button>
        </div>

        <div class="mt-2" v-if="formStatus.loading">
          <div class="spinner-border spinner-border-sm text-secondary me-1" role="status">
            <span class="visually-hidden">Registrant usuaris...</span>
          </div>
          <span class="text-secondary">Registrant usuaris... </span>
        </div>

        <div class="mt-2" v-if="formStatus.error === true">
          <div class="alert alert-dismissible alert-danger">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Hi ha hagut un error!</strong>
            <p class="mb-0">{{ formStatus.errorMsg }}</p>
          </div>
        </div>
        <div class="mt-2" v-if="formStatus.error === false">
          <div class="alert alert-dismissible alert-success">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Registre completat: </strong>
            <p class="mb-0">Tots els usuaris s'han registrat exitosament!</p>
          </div>
        </div>
      </form>
    </section>

  </div>

  <FooterBackoffice></FooterBackoffice>
</template>
  
<script>
import HeaderBackoffice from '@/components/BO/headers/HeaderBackoffice.vue';
import FooterBackoffice from '@/components/BO/FooterBackoffice.vue';

import userService from '@/services/User';

export default {
  components: {
    HeaderBackoffice,
    FooterBackoffice,
  },
  data() {
    return {
      usuaris: [],
      usuariMotlle: {
        user: {
          name: '',
          email: '',
          role: 'student',
          password: ''
        },
        errors: {

        },
        viewPassword: false
      },
      formStatus: {
        error: null,
        errorMsg: '',
        loading: false,
        valid: false,
        usuarisErronis: [],
      },
      mostrarPassword: true
    }
  },
  computed: {
    formValidat() {
      let valid = true

      this.usuaris.forEach(usuari => {
        for (const clau in Object.keys(usuari)) {
          switch (clau) {
            case 'name':
              if (!usuari.name.test(/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/)) {
                valid = false;
              }
              break;

            default:
              break;
          }

        }


      })

      return valid
    }
  },
  async beforeMount() {
    this.usuaris.push(JSON.parse(JSON.stringify(this.usuariMotlle)));
  },

  methods: {
    afegirUsuariLlista() {
      //Afegir l'usuari del formulari al llistat
      this.usuaris.push(JSON.parse(JSON.stringify(this.usuariMotlle)));
    },
    async crearUsuaris() {
      //Reset defaults:
      this.formStatus.loading = true;
      this.formStatus.error = null;
      this.formStatus.errorMsg = '';
      let that = this;

      let usuaris = this.usuaris.map(usuari => usuari.user)

      userService.registerUsers(usuaris)
        .then(r => {
          console.log('r :>> ', r);
          that.formStatus.error = false;
        })
        .catch(e => {
          console.log('e :>> ', e);
          that.formStatus.error = true;
          if (e.response.status == 409) {
            that.formStatus.errorMsg = "No s'han pogut crear tots els usuaris!";
            that.usuaris = e.response.data.data;
          } else {
            that.formStatus.errorMsg = e.message
          }


        })
        .finally(() => {
          //Update UI:
          that.formStatus.loading = false;
        })
    },
    generarContrasenya(usuari) {
      var longitut = Math.floor(Math.random() * 3) + 12; //Entre 12 i 14 caràcters.
      var caracters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]:;?><,./-=";
      var contrasenya = '';
      for (var i = 0; i < longitut; i++) {
        let caracterAleatori = caracters.charAt(Math.floor(Math.random() * caracters.length));
        contrasenya += caracterAleatori;
      }

      usuari.user.password = contrasenya;
    }


  }
}
</script>
<style scoped>
#togglePassword {
  position: absolute;
  right: 3.7rem;
  top: 1.1rem;
  cursor: pointer;
  z-index: 8;
}
</style>
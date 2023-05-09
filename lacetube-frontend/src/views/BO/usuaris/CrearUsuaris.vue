<template>
  <HeaderBackoffice></HeaderBackoffice>
  <div class="container mt-4 px-4">
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
              </tr>
            </thead>

            <tbody>
              <tr v-for="(usuari, index) in usuaris" :key="index" class="error">
                
                <td>
                  <input type="text" class="form-control is-invalid" v-model="usuari.name">
                  <div class="invalid-feedback">
                    Missatge d'error
                  </div>
                </td>
                <td>
                  <input type="email" class="form-control" v-model="usuari.email">
                </td>
                <td>
                  <select class="form-select" v-model="usuari.role">
                    <option value="student">Alumne</option>
                    <option value="teacher">Professor</option>
                    <option value="admin">Administrador</option>
                  </select>
                </td>
                <td class="input-group">
                  <input type="password" class="form-control" v-model="usuari.password">
                  <button class="btn btn-outline-primary btn-small" type="button"><i
                      class="fa-solid fa-rotate"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
          <!-- Botó afegir més usuris -->
          <a href="#" class="showMore text-center card-footer" @click.prevent="afegirUsuariLlista"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Afegir més usuaris</a>
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
        name: '',
        email: '',
        role: 'student',
        password: ''
      },
      formStatus: {
        error: null,
        errorMsg: '',
        loading: false,
        valid: false,
        usuarisErronis: [],
      }
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
    this.usuaris.push({ ...this.usuariMotlle })
  },

  methods: {
    afegirUsuariLlista() {
      //Validar que les dades
      //Afegir l'usuari del formulari al llistat
      this.usuaris.push({ ...this.usuariMotlle })
      this.validarUsuaris()
    },
    async crearUsuaris() {
      //Reset defaults:
      this.formStatus.loading = true;
      this.formStatus.error = null;
      this.formStatus.errorMsg = '';
      let that = this;

      userService.registerUsers(this.usuaris)
        .then(r => {
          console.log('r :>> ', r);
          that.formStatus.error = false;
        })
        .catch(e => {
          console.log('e :>> ', e);
          that.formStatus.error = true;
          if (e.response.status == 409) {
            that.formStatus.errorMsg = "No s'han pogut crear tots els usuaris!";
            that.formStatus.usuarisErronis = e.response.data.data;
            that.mostrarErrorsUsuaris()
          } else {
            that.formStatus.errorMsg = e.message
          }


        })
        .finally(() => {
          //Update UI:
          that.formStatus.loading = false;
        })
    },
    mostrarErrorsUsuaris() {
      let that = this;

      this.formStatus.usuarisErronis.forEach(usuariErroni => {
        that.usuaris.forEach(usuari => {
          if (usuariErroni.email == usuari.email) {
            usuari.error = usuariErroni.error
          }
        })
      })
    },
    validarUsuaris() {
      let that = this
      this.usuaris.forEach(usuari => {
        Object.keys(usuari).forEach(key => {
          switch (key) {
            case 'name':
              that.formValidat = true
              break;

            default:
              break;
          }
        })

      })
    }


  }
}
</script>
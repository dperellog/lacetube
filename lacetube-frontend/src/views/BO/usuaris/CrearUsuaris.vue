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
              <tr v-for="(usuari, index) in usuaris" :key="index">
                <td>
                  <input type="text" class="form-control" v-model="usuari.name">
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
          <a href="#" class="showMore text-center card-footer" @click.prevent="afegirUsuariLlista">Afegir més usuaris</a>
        </div>

        <div class="text-start">
          <button type="submit" class="btn btn-success mt-3" @click.prevent="crearUsuaris" :disabled="!formValidat">Crear usuaris</button>
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
    }
  },
  computed : {
    formValidat () {
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
      console.log('usersArray :>> ', this.usuaris);
      userService.registerUsers(this.usuaris)
      .then(r => {
        console.log('r :>> ', r);
      })
      .catch(e => {
        console.log('e :>> ', e);
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
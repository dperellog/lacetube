<template>
  <div class="row mb-3 justify-content-between">
    <div class="col-4 d-flex">
      <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Acció en massa
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#" @click.prevent="triggerEliminarUsuaris()">Eliminar</a></li>
        </ul>
      </div>
    </div>

    <div class="col-4 d-flex justify-content-end" v-if="this.btnNovaTaula">
      <router-link to="/gestio/usuaris/crear" class="btn btn-success" type="button">
        <i class="fa-solid fa-plus" style="color: #ffffff;"></i>&nbsp;&nbsp;
        Crear Usuaris
      </router-link>
    </div>
  </div>

  <!-- TAULA CURSOS -->
  <div class="card taula">
    <table class="card-table table">
      <thead class="card-header capcalera-taula">
        <tr>
          <th></th>
          <th @click="ordenarPer('id')">Usuari &nbsp;&nbsp;<i
              :class="['fa-solid', 'sortingArrow', columnesOrdre.id ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i>
          </th>
          <th class="text-center" @click="ordenarPer('cursos')">Cursos &nbsp;&nbsp;<i
              :class="['fa-solid', 'sortingArrow', columnesOrdre.cursos ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i>
          </th>
          <th class="text-center" @click="ordenarPer('videos')">Videos &nbsp;&nbsp;<i
              :class="['fa-solid', 'sortingArrow', columnesOrdre.videos ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i>
          </th>
          <th class="text-center" @click="ordenarPer('roles')">Rol &nbsp;&nbsp;<i
              :class="['fa-solid', 'sortingArrow', columnesOrdre.roles ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i>
          </th>
          <th class="text-center">Accions</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="usuari in limitarArray(usuarisFiltrats)" :key="usuari.id">
          <!-- Check per marcar -->
          <td style="width:5%">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" :value="usuari" :id="'usuari' + usuari.id"
                v-model="usuarisModificar">
            </div>
          </td>

          <!-- Usuari -->
          <td style="width:30%">
            <router-link :to="{ path: '/usuari/' + usuari.id }" class="d-flex align-items-center  text-decoration-none">
              <avatar :url="userService.getAvatarURLByAvatar(usuari.avatar)" :size="'sm'"></avatar>
              <div class="ms-3">
                <p class="fw-bold mb-1">{{ usuari.name }}</p>
                <p class="text-muted mb-0">{{ usuari.email }}</p>
              </div>
            </router-link>
          </td>

          <!-- Cursos -->
          <td style="width:15%" class="text-center">
            {{ usuari.courses.length }}
          </td>

          <!-- Videos -->
          <td class="text-center" style="width:15%">
            {{ usuari.videos.length }}
          </td>

          <!-- Rol -->
          <td style="width:10%" class="text-center">
            {{ usuari.roles.map(role => userService.translateRole(role)).join() }}
          </td>

          <!-- Accions -->
          <td class="text-center" style="width:25%">
            <button type="button" class="btn btn-sm btn-danger m-1" @click="triggerEliminarUsuari(usuari)">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Botó mostrar més -->
    <a href="#" class="showMore text-center card-footer" v-if="limit != -1" @click.prevent="mostrarMes">Mostra'n més</a>
  </div>

  <!-- Confirmació eliminar usuari single -->
  <div class="modal fade" id="confirmacioEliminar" tabindex="-1" aria-labelledby="confirmacioEliminar" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="confirmacioEliminar">Segur que vols eliminar l'usuari?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Estas a punt d'eliminar el següent usuari: <span class="fw-bold text-dark">{{
            usuariEliminar.data.name }}</span>
          </p>
          <p v-if="!usuariEliminar.valid">Estas segur que vols eliminar l'usuari? <span
              class="fw-bold h6 text-danger">Aquesta acció no es pot revertir!</span></p>

          <!-- Missatge de confirmació -->
          <div class="mt-2" v-if="usuariEliminar.loading">
            <div class="spinner-border spinner-border-sm text-secondary me-1" role="status">
              <span class="visually-hidden">Eliminant usuari...</span>
            </div>
            <span class="text-secondary">Eliminant usuari... </span>
          </div>
          <div class="mt-2" v-if="usuariEliminar.error === true">
            <div class="alert alert-danger">
              <strong>Hi ha hagut un error!</strong>
              <p class="mb-0">{{ usuariEliminar.errorMsg }}</p>
            </div>
          </div>
          <div class="mt-2" v-if="usuariEliminar.error === false">
            <div class="alert alert-success">
              <strong>Acció completada: </strong>
              <p class="mb-0">S'ha eliminat l'usuari exitosament!</p>
            </div>
          </div>
        </div>
        <div class="modal-footer" v-if="!usuariEliminar.valid">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancel·lar</button>
          <button type="button" @click="eliminarUsuari(usuariEliminar.data.id)"
            class="btn btn-outline-danger">Eliminar
            Usuari</button>
        </div>
        <div class="modal-footer" v-else>
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tancar</button>
        </div>


      </div>
    </div>
  </div>

  <!-- Confirmació eliminar curs multi -->
  <div class="modal fade" id="confirmacioEliminarMulti" tabindex="-1" aria-labelledby="confirmacioEliminarMulti"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="confirmacioEliminarMulti">Segur que vols eliminar tots aquests usuaris?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Estas a punt d'eliminar els següents usuaris: </p>
          <ul>
            <li v-for="usuari in usuarisModificar">
              <span class="fw-bold text-dark">{{ usuari.name }} - {{ usuari.email }}</span>
            </li>
          </ul>
          <p v-if="!usuariEliminar.valid">Estas segur que vols eliminar aquests usuaris? <span
              class="fw-bold h6 text-danger">Aquesta acció no es pot revertir!</span></p>

          <!-- Missatge de confirmació -->
          <div class="mt-2" v-if="usuariEliminar.loading">
            <div class="spinner-border spinner-border-sm text-secondary me-1" role="status">
              <span class="visually-hidden">Eliminant usuaris...</span>
            </div>
            <span class="text-secondary">Eliminant usuaris... </span>
          </div>
          <div class="mt-2" v-if="usuariEliminar.error === true">
            <div class="alert alert-danger">
              <strong>Hi ha hagut un error!</strong>
              <p class="mb-0">{{ usuariEliminar.errorMsg }}</p>
            </div>
          </div>
          <div class="mt-2" v-if="usuariEliminar.error === false">
            <div class="alert alert-success">
              <strong>Acció completada: </strong>
              <p class="mb-0">S'han eliminat els usuaris exitosament!</p>
            </div>
          </div>
        </div>
        <div class="modal-footer" v-if="!usuariEliminar.valid">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancel·lar</button>
          <button type="button" @click="eliminarUsuaris()" class="btn btn-outline-danger">Eliminar
            Usuaris</button>
        </div>
        <div class="modal-footer" v-else>
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tancar</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import userService from '@/services/User';
import Avatar from '@/components/common/Avatar.vue';


export default {
  props: {
    usuaris: {
      type: Object,
      required: true
    },
    btnNovaTaula: {
      type: Boolean
    }
  },
  components : {
    Avatar
  },
  emits: ["refrescarTaula"],
  setup() {
    return {
      userService: userService
    }
  },
  beforeMount() {
    this.usuarisFiltrats = this.usuaris

    if (this.limit >= this.usuaris.length) {
      this.limit = -1;
    }
  },
  data() {
    return {
      usuarisFiltrats: null,
      columnesOrdre: {
        id: true,
        cursos: true,
        videos: true,
        roles: true,
      },
      limit: 10,
      filterRegex: '',
      columnCriteria: '',
      usuarisModificar: [],
      usuariEliminar: {
        data: {
          id: '',
          name: ''
        }
      },
    }
  },
  methods: {
    limitarArray(arr) {
      if (arr && arr.length) {
        let limit = this.limit;

        if (limit == -1) {
          return arr;
        }
        if (limit > arr.length) {
          return arr;
        }

        return arr.slice(0, limit);
      }
      return null;
    },
    mostrarMes() {
      this.limit += 10;
      if (this.limit >= this.cursos.length) {
        this.limit = -1;
      }
    },
    ordenarPer(atribut) {
      switch (atribut) {
        case 'roles':
          this.usuarisFiltrats = this.usuaris.sort((a, b) => (a.roles[0] > b.roles[0]) ? 1 : -1)
          break;
        case 'videos':
          this.usuarisFiltrats = this.usuaris.sort((a, b) => (a.videos.length > b.videos.length) ? 1 : -1)
          break;
        case 'cursos':
          this.usuarisFiltrats = this.usuaris.sort((a, b) => (a.courses.length > b.courses.length) ? 1 : -1)
          break;
        case 'id':
          this.usuarisFiltrats = this.usuaris.sort((a, b) => (a.name > b.name) ? 1 : -1)
          break;
      }

      if (this.columnesOrdre[atribut]) {
        this.usuarisFiltrats.reverse()
      }

      this.columnesOrdre[atribut] = !this.columnesOrdre[atribut]
    },
    triggerEliminarUsuari(usuari) {
      this.usuariEliminar.valid = false;
      this.usuariEliminar.data = usuari;

      this.usuariEliminar.alerta = new bootstrap.Modal(document.getElementById('confirmacioEliminar'), { backdrop: true })
      this.usuariEliminar.alerta.show()
    },
    eliminarUsuari(usuariID) {
      //Reset defaults:
      this.usuariEliminar.loading = true;
      this.usuariEliminar.error = null;
      this.usuariEliminar.errorMsg = '';
      let that = this;

      userService.removeUser(usuariID)
        .then(r => {
          that.usuariEliminar.error = false;
          this.usuariEliminar.valid = true;

          const alerta = document.getElementById('confirmacioEliminar')

          alerta.addEventListener('hidden.bs.modal', event => {
            that.$emit('refrescarTaula');
          })

        })
        .catch(e => {
          console.log('e :>> ', e);
          that.usuariEliminar.error = true;
          that.usuariEliminar.errorMsg = e.response.data.message;
        })
        .finally(() => {
          //Update UI:
          that.usuariEliminar.loading = false;
        })
    },
    triggerEliminarUsuaris() {
      this.usuariEliminar.valid = false;

      this.usuariEliminar.alerta = new bootstrap.Modal(document.getElementById('confirmacioEliminarMulti'), { backdrop: true })
      this.usuariEliminar.alerta.show()
    },
    async eliminarUsuaris() {
      //Reset defaults:
      this.usuariEliminar.loading = true;
      this.usuariEliminar.error = null;
      this.usuariEliminar.errorMsg = '';
      let that = this;

      //Eliminar tots els cursos:
      let usuarisAEliminar = this.usuarisModificar.map(usuari => {
        return userService.removeUser(usuari.id)
      })

      Promise.all(usuarisAEliminar)
        .then(responses => {
          // Aquí tienes todas las respuestas de los fetches

          that.usuariEliminar.error = false;
          this.usuariEliminar.valid = true;

          const alerta = document.getElementById('confirmacioEliminarMulti')

          alerta.addEventListener('hidden.bs.modal', event => {
            that.$emit('refrescarTaula');
          })
        })
        .catch(error => {
          // Aquí manejas el error si alguno de los fetches falla
          console.log('errors :>> ', error);
          that.usuariEliminar.error = true;
          that.usuariEliminar.errorMsg = e.response.data.message;
        })
        .finally(() => {
          this.usuariEliminar.loading = false;
        })

    }
  }

}
</script>

<style scoped>
.table {
  margin-bottom: 0em;
}

.card.taula {

  overflow-x: auto;
}

.sortingArrow {
  color: #7F8C8D;
}

.sortingArrow:hover {
  color: #212529;
}
</style>
<template>
  <div class="row mb-3 justify-content-between">
    <div class="col-4 d-flex">
      <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Acció en massa
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#" @click.prevent="triggerEliminarCursos()">Eliminar</a></li>
        </ul>
      </div>
    </div>

    <div class="col-4 d-flex justify-content-end" v-if="this.btnNovaTaula">
      <router-link to="/gestio/cursos/crear" class="btn btn-success" type="button">
        <i class="fa-solid fa-plus" style="color: #ffffff;"></i>&nbsp;&nbsp;
        Crear Curs
      </router-link>
    </div>
  </div>

  <!-- TAULA CURSOS -->
  <div class="card taula">
    <table class="card-table table">
      <thead class="card-header capcalera-taula">
        <tr>
          <th></th>
          <th @click="ordenarPer('curs')">Nom del curs &nbsp;&nbsp;<i
              :class="['fa-solid', 'sortingArrow', columnesOrdre.curs ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i>
          </th>
          <th @click="ordenarPer('professor')">Professor &nbsp;&nbsp;<i
              :class="['fa-solid', 'sortingArrow', columnesOrdre.professor ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i>
          </th>
          <th @click="ordenarPer('estudiants')">Estudiants &nbsp;&nbsp;<i
              :class="['fa-solid', 'sortingArrow', columnesOrdre.estudiants ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i>
          </th>
          <th @click="ordenarPer('any')">Any &nbsp;&nbsp;<i
              :class="['fa-solid', 'sortingArrow', columnesOrdre.any ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i>
          </th>
          <th class="text-center">Accions</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="curs in limitarArray(cursosFiltrats)">
          <td style="width:5%">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" :value="curs" :id="'curs' + curs.id"
                v-model="cursosModificar">
            </div>
          </td>
          <td style="width:25%">
            <router-link :to="{ path: '/curs/' + curs.id }" class="text-primary fw-bold mb-1">{{ curs.name.length < 50 ?
              curs.name : curs.name.substring(0, 50) + "..." }}</router-link>
                <p class="text-muted mb-0">{{ curs.description.length < 30 ? curs.description :
                  curs.description.substring(0, 30) + "..." }}</p>
          </td>
          <td style="width:25%">
            <div class="d-flex align-items-center">
              <img :src="userService.getAvatarURLByAvatar(curs.teacher.avatar)" alt="" style="width: 45px; height: 45px"
                class="rounded-circle">
              <div class="ms-3">
                <p class="fw-bold mb-1">{{ curs.teacher.name }}</p>
                <p class="text-muted mb-0">{{ curs.teacher.email }}</p>
              </div>
            </div>
          </td>
          <td class="text-center" style="width:15%">
            {{ curs.students.length }}
          </td>
          <td style="width:10%">
            {{ curs.year }}
          </td>
          <td class="text-center" style="width:25%">
            <router-link :to="{ path: '/gestio/cursos/modificar/' + curs.id }" type="button"
              class="btn btn-sm btn-info m-1">
              Editar
            </router-link>
            <button type="button" @click="triggerEliminarCurs(curs)" class="btn btn-sm btn-danger m-1">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Botó mostrar més -->
    <a href="#" class="showMore text-center card-footer" v-if="limit != -1" @click.prevent="mostrarMes">Mostra'n més</a>
  </div>

  <!-- Confirmació eliminar curs single -->
  <div class="modal fade" id="confirmacioEliminar" tabindex="-1" aria-labelledby="confirmacioEliminar" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="confirmacioEliminar">Segur que vols eliminar el curs?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Estas a punt d'eliminar el següent curs: <span class="fw-bold text-dark">{{ cursEliminar.data.name }}</span>
          </p>
          <p v-if="!cursEliminar.valid">Estas segur que vols eliminar el curs? <span
              class="fw-bold h6 text-danger">Aquesta acció no es pot
              revertir!</span></p>

          <!-- Missatge de confirmació -->
          <div class="mt-2" v-if="cursEliminar.loading">
            <div class="spinner-border spinner-border-sm text-secondary me-1" role="status">
              <span class="visually-hidden">Eliminant curs...</span>
            </div>
            <span class="text-secondary">Eliminant curs... </span>
          </div>
          <div class="mt-2" v-if="cursEliminar.error === true">
            <div class="alert alert-danger">
              <strong>Hi ha hagut un error!</strong>
              <p class="mb-0">{{ cursEliminar.errorMsg }}</p>
            </div>
          </div>
          <div class="mt-2" v-if="cursEliminar.error === false">
            <div class="alert alert-success">
              <strong>Acció completada: </strong>
              <p class="mb-0">S'ha eliminat el curs exitosament!</p>
            </div>
          </div>
        </div>
        <div class="modal-footer" v-if="!cursEliminar.valid">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancel·lar</button>
          <button type="button" @click="eliminarCurs(cursEliminar.data.id)" class="btn btn-outline-danger">Eliminar
            Curs</button>
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
          <h1 class="modal-title fs-5" id="confirmacioEliminarMulti">Segur que vols eliminar tots aquests cursos?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Estas a punt d'eliminar els següents cursos: </p>
          <ul>
            <li v-for="curs in cursosModificar">
              <span class="fw-bold text-dark">{{ curs.name }}</span>
            </li>
          </ul>
          <p v-if="!cursEliminar.valid">Estas segur que vols eliminar aquests cursos? <span
              class="fw-bold h6 text-danger">Aquesta acció no es pot
              revertir!</span></p>

          <!-- Missatge de confirmació -->
          <div class="mt-2" v-if="cursEliminar.loading">
            <div class="spinner-border spinner-border-sm text-secondary me-1" role="status">
              <span class="visually-hidden">Eliminant cursos...</span>
            </div>
            <span class="text-secondary">Eliminant cursos... </span>
          </div>
          <div class="mt-2" v-if="cursEliminar.error === true">
            <div class="alert alert-danger">
              <strong>Hi ha hagut un error!</strong>
              <p class="mb-0">{{ cursEliminar.errorMsg }}</p>
            </div>
          </div>
          <div class="mt-2" v-if="cursEliminar.error === false">
            <div class="alert alert-success">
              <strong>Acció completada: </strong>
              <p class="mb-0">S'han eliminat els cursos exitosament!</p>
            </div>
          </div>
        </div>
        <div class="modal-footer" v-if="!cursEliminar.valid">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancel·lar</button>
          <button type="button" @click="eliminarCursos()" class="btn btn-outline-danger">Eliminar
            Cursos</button>
        </div>
        <div class="modal-footer" v-else>
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tancar</button>
        </div>
      </div>
    </div>
  </div>
</template>
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
<script>
import userService from '@/services/User';
import Resources from '../../../services/Resources';

export default {
  props: {
    cursos: {
      type: Object,
      required: true
    },
    btnNovaTaula: {
      type: Boolean
    }
  },
  emits: ["refrescarTaula"],
  setup() {
    return {
      userService: userService
    }
  },
  beforeMount() {
    this.cursosFiltrats = this.cursos

    if (this.limit >= this.cursos.length) {
        this.limit = -1;
      }
  },
  data() {
    return {
      cursosFiltrats: null,
      limit: 10,
      columnesOrdre: {
        curs: true,
        professor: true,
        estudiants: true,
        any: true,
      },
      cursEliminar: {
        data: {
          id: '',
          name: ''
        },
        error: null,
        errorMsg: '',
        loading: false,
        valid: false,
        alerta: false
      },
      cursosModificar: []
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
        case 'curs':
          this.cursosFiltrats = this.cursos.sort((a, b) => (a.name > b.name) ? 1 : -1)
          break;
        case 'professor':
          this.cursosFiltrats = this.cursos.sort((a, b) => (a.teacher.name > b.teacher.name) ? 1 : -1)
          break;
        case 'estudiants':
          this.cursosFiltrats = this.cursos.sort((a, b) => (a.students.length > b.students.length) ? 1 : -1)
          break;
        case 'any':
          this.cursosFiltrats = this.cursos.sort((a, b) => (a.year > b.year) ? 1 : -1)
          break;
      }

      if (this.columnesOrdre[atribut]) {
        this.cursosFiltrats.reverse()
      }

      this.columnesOrdre[atribut] = !this.columnesOrdre[atribut]
    },
    triggerEliminarCurs(curs) {
      this.cursEliminar.valid = false;
      this.cursEliminar.data = curs;

      this.cursEliminar.alerta = new bootstrap.Modal(document.getElementById('confirmacioEliminar'), { backdrop: true })
      this.cursEliminar.alerta.show()
    },
    eliminarCurs(cursID) {
      //Reset defaults:
      this.cursEliminar.loading = true;
      this.cursEliminar.error = null;
      this.cursEliminar.errorMsg = '';
      let that = this;

      Resources.deleteCourse(cursID)
        .then(r => {
          console.log('r :>> ', r);
          that.cursEliminar.error = false;
          this.cursEliminar.valid = true;

          const alerta = document.getElementById('confirmacioEliminar')

          alerta.addEventListener('hidden.bs.modal', event => {
            that.$emit('refrescarTaula');
          })

        })
        .catch(e => {
          console.log('e :>> ', e);
          that.cursEliminar.error = true;
          that.cursEliminar.errorMsg = e.response.data.message;
        })
        .finally(() => {
          //Update UI:
          that.cursEliminar.loading = false;
        })
    },
    triggerEliminarCursos() {
      this.cursEliminar.valid = false;

      this.cursEliminar.alerta = new bootstrap.Modal(document.getElementById('confirmacioEliminarMulti'), { backdrop: true })
      this.cursEliminar.alerta.show()
    },
    async eliminarCursos() {
      //Reset defaults:
      this.cursEliminar.loading = true;
      this.cursEliminar.error = null;
      this.cursEliminar.errorMsg = '';
      let that = this;

      //Eliminar tots els cursos:
      let cursosAEliminar = this.cursosModificar.map(curs => {
        return Resources.deleteCourse(curs.id)
      })

      Promise.all(cursosAEliminar)
        .then(responses => {
          // Aquí tienes todas las respuestas de los fetches
          console.log('responses :>> ', responses);

          that.cursEliminar.error = false;
          this.cursEliminar.valid = true;

          const alerta = document.getElementById('confirmacioEliminarMulti')

          alerta.addEventListener('hidden.bs.modal', event => {
            that.$emit('refrescarTaula');
          })
        })
        .catch(error => {
          // Aquí manejas el error si alguno de los fetches falla
          console.log('errors :>> ', error);
          that.cursEliminar.error = true;
          that.cursEliminar.errorMsg = e.response.data.message;
        })
        .finally(() => {
          this.cursEliminar.loading = false;
        })

    }
  }


}
</script>


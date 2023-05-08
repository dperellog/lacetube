<template>
  <div class="row mb-3 justify-content-between">
    <div class="col-4 d-flex">
      <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Acció en massa
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#" @click.prevent="triggerEliminaractivitatos()">Eliminar</a></li>
        </ul>
      </div>
    </div>

    <div class="col-4 d-flex justify-content-end">
      <button @click="actualitzarTaula" class="btn btn-outline-secondary mx-2" type="button">
        <i class="fa-solid fa-rotate-right"></i>
      </button>
      <button @click="formulariCrearTasca" class="btn btn-success" type="button">
        <i class="fa-solid fa-plus" style="color: #ffffff;"></i>&nbsp;&nbsp;
        Nova Tasca
      </button>
    </div>
  </div>

  <!-- Formulari Creació de Tasca -->
  <div v-if="creantTasca">
    <div class="card p-3 mb-3">
      <h3 class="h4 m-0">Crear nova tasca:</h3>
      <hr>
      <div class="row">
        <div class="col-8 mb-3">
          <div class="my-2">
            <label for="exampleInputEmail1" class="form-label h6">Nom de la tasca:</label>
            <input type="text" class="form-control" v-model="tascaForm.name">
          </div>
          <div class="my-2">
            <label for="exampleInputPassword1" class="form-label">Descripció del curs:</label>
            <textarea class="form-control" rows="8" v-model="tascaForm.description"></textarea>
          </div>
        </div>

        <div class="col-4">
          <div class="my-2">
            <label for="exampleInputEmail1" class="form-label h6">Data de lliurament:</label>
            <VueDatePicker v-model="tascaForm.end_date" inline auto-apply :enable-time-picker="false"></VueDatePicker>
          </div>
        </div>
      </div>

      <button v-if="!tascaFormStatus.editing" class="btn btn-success" @click="crearTasca" :disabled="newTaskFormCorrecte">Crear Tasca</button>
      <button v-else class="btn btn-success" @click="modificarTasca" :disabled="newTaskFormCorrecte">Modificar Tasca</button>

      <div class="mt-2" v-if="tascaFormStatus.loading">
      <div class="spinner-border spinner-border-sm text-secondary me-1" role="status">
        <span class="visually-hidden">Creant tasca...</span>
      </div>
      <span v-if="!tascaFormStatus.editing" class="text-secondary">Creant tasca... </span>
      <span v-else class="text-secondary">Modificant tasca... </span>
    </div>

    <div class="mt-2" v-if="tascaFormStatus.error === true">
      <div class="alert alert-dismissible alert-danger">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Hi ha hagut un error!</strong>
        <p class="mb-0">{{ tascaFormStatus.errorMsg }}</p>
      </div>
    </div>
    <div class="mt-2" v-if="tascaFormStatus.error === false">
      <div class="alert alert-dismissible alert-success">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Acció completada: </strong>
        <p v-if="!tascaFormStatus.editing" class="mb-0">S'ha creat la tasca exitosament!</p>
        <p v-else class="mb-0">S'ha modificat la tasca exitosament!</p>
      </div>
    </div>

    </div>
  </div>

  <!-- TAULA activitats -->
  <div class="card taula">
    <table class="card-table table">
      <thead class="card-header capcalera-taula">
        <tr>
          <th></th>
          <th @click="ordenarPer('nom')">Titol Activitat &nbsp;&nbsp;<i
              :class="['fa-solid', 'sortingArrow', columnesOrdre.nom ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i>
          </th>
          <th @click="ordenarPer('entrega')" class="text-center">Data d'entrega &nbsp;&nbsp;<i
              :class="['fa-solid', 'sortingArrow', columnesOrdre.entrega ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i>
          </th>
          <th @click="ordenarPer('videos')" class="text-center">Entregues &nbsp;&nbsp;<i
              :class="['fa-solid', 'sortingArrow', columnesOrdre.videos ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i>
          </th>
          <th class="text-center">Accions</th>
        </tr>
      </thead>

      <tbody>
        <tr v-if="activitatsFiltrades.length > 0" v-for="activitat in limitarArray(activitatsFiltrades)" :key="activitat.id">
          <td style="width:5%">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" :value="activitat" :id="'activitat' + activitat.id"
                v-model="activitatModificar">
            </div>
          </td>
          <td style="width:35%">
            <router-link :to="{ path: '/' }" class="text-primary fw-bold mb-1">{{
              activitat.name.length < 50 ? activitat.name : activitat.name.substring(0, 50) + "..." }}</router-link>
                <p class="text-muted mb-0">{{ activitat.description.length < 30 ? activitat.description :
                  activitat.description.substring(0, 30) + "..." }}</p>
          </td>
          <td class="text-center" style="width:20%">
            {{ formatarData(activitat.end_date) }}
          </td>
          <td class="text-center" style="width:15%">
            {{ activitat.videos.length }}
          </td>

          <td class="text-center" style="width:25%">
            <button @click="formulariEditarTasca(activitat)" class="btn btn-sm btn-info m-1">
              Editar
            </button>
            <button type="button" @click="triggerEliminaractivitat(activitat)" class="btn btn-sm btn-danger m-1">
              Eliminar
            </button>
          </td>
        </tr>
        <tr v-else>
          <td colspan="5">
            <div class="alert alert-info" role="alert">
              No hi han tasques disponibles!
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Botó mostrar més -->
    <a href="#" class="showMore text-center card-footer" v-if="limit != -1 && activitatsFiltrades > limit"
      @click.prevent="mostrarMes">Mostra'n més</a>
  </div>
</template>
<style>
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
import Resources from '../../../services/Resources';
import moment from 'moment';
import VueDatePicker from '@vuepic/vue-datepicker';


export default {
  props: {
    activitats: {
      type: Array,
      required: true
    },
    btnNovaTaula: {
      type: Boolean
    },
    curs: {
      type: Object,
      required: true
    }
  },
  emits: ["refrescarTaula"],
  components: {
    VueDatePicker
  },
  beforeMount() {
    this.activitatsFiltrades = this.activitats
    this.tascaForm = { ...this.tascaModel }
  },
  data() {
    return {
      activitatsFiltrades: null,
      limit: 10,
      columnesOrdre: {
        nom: true,
        entrega: true,
        videos: true,
      },
      tascaForm: {
        name: '',
        description: '',
        end_date: moment().format('YYYY-MM-DD')
      },
      tascaModel: {
        name: '',
        description: '',
        end_date: moment().format('YYYY-MM-DD')
      },
      creantTasca: false,
      tascaFormStatus: {
        error: null,
        errorMsg: '',
        loading: false,
        valid: false,
        editing: false,
      },
      activitatModificar: []

    }
  },
  watch: {
    'tascaForm.end_date': {
      handler(data) {
        this.tascaForm.end_date = moment(data).format('YYYY-MM-DD')
      },
      deep: true
    }
  },
  computed: {
    newTaskFormCorrecte() {
      return !(this.tascaForm.name != '' && this.tascaForm.description != '' && moment(this.tascaForm.end_date).isAfter(moment().subtract(1, 'day')))
    }
  },
  methods: {
    formatarData(data){
      return moment(data).format('DD-MM-YYYY')
    },
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
      if (this.limit >= this.activitatos.length) {
        this.limit = -1;
      }
    },
    ordenarPer(atribut) {
      switch (atribut) {
        case 'nom':
          this.activitatsFiltrades = this.activitats.sort((a, b) => (a.name > b.name) ? 1 : -1)
          break;
        case 'entrega':
          this.activitatsFiltrades = this.activitats.sort((a, b) => (a.end_date > b.end_date) ? 1 : -1)
          break;
        case 'videos':
          this.activitatsFiltrades = this.activitats.sort((a, b) => (a.name > b.name) ? 1 : -1)
          break;
      }

      if (this.columnesOrdre[atribut]) {
        this.activitatsFiltrades.reverse()
      }

      this.columnesOrdre[atribut] = !this.columnesOrdre[atribut]
    },
    formulariCrearTasca(){
      this.tascaForm = { ...this.tascaModel }
      this.tascaFormStatus.editing = false;
      this.creantTasca = true;
    },
    actualitzarTaula(){
      this.$emit('refrescarTaula');
    },
    formulariEditarTasca(tasca) {
      this.tascaForm = {...tasca};

      this.tascaFormStatus.editing = true;
      this.creantTasca = true;
      
    },
    async crearTasca() {
      //Reset defaults:
      this.tascaFormStatus.loading = true;
      this.tascaFormStatus.error = null;
      this.tascaFormStatus.errorMsg = '';
      let that = this;

      let tasca = {...this.tascaForm}
      tasca.course_id = this.curs.id

      Resources.createTask(tasca)
        .then(r => {
          console.log('r :>> ', r);
          that.tascaFormStatus.error = false;

          that.tascaForm = {...that.tascaModel}
        })
        .catch(e => {
          console.log('e :>> ', e);
          that.tascaFormStatus.error = true;
          that.tascaFormStatus.errorMsg = e.response.data.message;
        })
        .finally(() => {
          //Update UI:
          that.tascaFormStatus.loading = false;
        })
    },
    async modificarTasca() {
      //Reset defaults:
      this.tascaFormStatus.loading = true;
      this.tascaFormStatus.error = null;
      this.tascaFormStatus.errorMsg = '';
      let that = this;

      let tasca = {...this.tascaForm}
      tasca.course_id = this.curs.id
      tasca.id = this.curs.id

      Resources.modifyTask(tasca)
        .then(r => {
          console.log('r :>> ', r);
          that.tascaFormStatus.error = false;

          that.tascaForm = {...that.tascaModel}
        })
        .catch(e => {
          console.log('e :>> ', e);
          that.tascaFormStatus.error = true;
          that.tascaFormStatus.errorMsg = e.response.data.message;
        })
        .finally(() => {
          //Update UI:
          that.tascaFormStatus.loading = false;
        })
      }
  }


}
</script>


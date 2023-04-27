<template>
  <div class="row mb-3 justify-content-between">
    <div class="col-4 d-flex">
      <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Proxims {{ ordre }} dies
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#" @click.prevent="ordenarTasques(7)">Proxims 7 dies</a></li>
          <li><a class="dropdown-item" href="#" @click.prevent="ordenarTasques(14)">Proxims 14 dies</a></li>
          <li><a class="dropdown-item" href="#" @click.prevent="ordenarTasques(21)">Proxims 21 dies</a></li>
          <li><a class="dropdown-item" href="#" @click.prevent="ordenarTasques(31)">Proxims 31 dies</a></li>
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
          <th @click="ordenarPer('curs')">Nom del curs &nbsp;&nbsp;<i :class="['fa-solid','sortingArrow', columnesOrdre.curs ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i></th>
          <th @click="ordenarPer('professor')">Professor &nbsp;&nbsp;<i :class="['fa-solid','sortingArrow', columnesOrdre.professor ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i></th>
          <th @click="ordenarPer('estudiants')">Estudiants &nbsp;&nbsp;<i :class="['fa-solid','sortingArrow', columnesOrdre.estudiants ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i></th>
          <th @click="ordenarPer('any')">Any &nbsp;&nbsp;<i :class="['fa-solid','sortingArrow', columnesOrdre.any ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i></th>
          <th class="text-center">Accions</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="curs in limitarArray(cursosFiltrats)">
          <td style="width:5%">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            </div>
          </td>
          <td style="width:25%">
            <p class="fw-bold mb-1">{{ curs.name.length < 50 ? curs.name : curs.name.substring(0,50) + "..." }}</p>
            <p class="text-muted mb-0">{{ curs.description.length < 30 ? curs.description : curs.description.substring(0,30) + "..." }}</p>
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
            <router-link :to="{ path: '/gestio/cursos/modificar/'+curs.id}" type="button" class="btn btn-sm btn-info m-1">
              Editar
            </router-link>
            <button type="button" class="btn btn-sm btn-danger m-1">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Botó mostrar més -->
    <a href="#" class="showMore text-center card-footer" v-if="limit != -1" @click.prevent="mostrarMes">Mostra'n més</a>
  </div>
</template>
<style>
.table{
  margin-bottom: 0em;
}

.card.taula{
  overflow-x: auto;
}

.sortingArrow{
  color: #7F8C8D;
}

.sortingArrow:hover{
  color: #212529;
}

</style>
<script>
import userService from '@/services/User';
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
  setup() {
    return {
      userService: userService
    }
  },
  beforeMount() {
    this.cursosFiltrats = this.cursos
  },
  data() {
    return {
      cursosFiltrats: null,
      limit: 10,
      filterRegex: '',
      columnCriteria: '',
      columnesOrdre: {
        curs: true,
        professor: true,
        estudiants: true,
        any: true,
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
    
    ordenarPer(atribut){
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
    }
  }

}
</script>


<template>
  <div class="row mb-3 justify-content-between">
    <div class="col-4 d-flex">
      <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Proxims dies
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
          Crear Usuaris
        </router-link>
    </div>
  </div>

  <!-- TAULA CURSOS -->
  <div class="card">
    <table class="card-table table">
      <thead class="card-header capcalera-taula">
        <tr>
          <th></th>
          <th @click="ordenarPer('id')">Usuari &nbsp;&nbsp;<i :class="['fa-solid','sortingArrow', columnesOrdre.id ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i></th>
          <th class="text-center" @click="ordenarPer('cursos')">Cursos &nbsp;&nbsp;<i :class="['fa-solid','sortingArrow', columnesOrdre.cursos ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i></th>
          <th class="text-center" @click="ordenarPer('videos')">Videos &nbsp;&nbsp;<i :class="['fa-solid','sortingArrow', columnesOrdre.videos ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i></th>
          <th class="text-center" @click="ordenarPer('roles')">Rol &nbsp;&nbsp;<i :class="['fa-solid','sortingArrow', columnesOrdre.roles ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i></th>
          <th class="text-center">Accions</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="usuari in limitarArray(usuarisFiltrats)" :key="usuari.id">
          <td style="width:5%">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            </div>
          </td>
          <td style="width:30%">
            <div class="d-flex align-items-center">
              <img :src="userService.getAvatarURLByAvatar(usuari.avatar)" alt="" style="width: 45px; height: 45px"
                class="rounded-circle">
              <div class="ms-3">
                <p class="fw-bold mb-1">{{ usuari.name }}</p>
                <p class="text-muted mb-0">{{ usuari.email }}</p>
              </div>
            </div>
          </td>
          <td style="width:15%" class="text-center">
            {{ usuari.courses.length }}
          </td>
          <td class="text-center" style="width:15%">
            {{ usuari.videos.length }}
          </td>
          <td style="width:10%" class="text-center">
            {{ usuari.roles.map(role => userService.translateRole(role)).join() }}
          </td>
          <td class="text-center" style="width:25%">
            <router-link :to="{ path: '/gestio/cursos/modificar/'+usuari.id}" type="button" class="btn btn-sm btn-info m-1">
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

.card{
  overflow-x: scroll;
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
    usuaris: {
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
    this.usuarisFiltrats = this.usuaris
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
      columnCriteria: ''
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
    }
  }

}
</script>


<template>
  <div class="row mb-3">
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
  </div>

  <!-- TAULA CURSOS -->
  <div class="card">
    <table class="card-table table">
      <thead class="card-header capcalera-taula">
        <tr>
          <th></th>
          <th>Nom del curs</th>
          <th>Professor</th>
          <th>Estudiants</th>
          <th>Any</th>
          <th>Accions</th>
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
            <p class="fw-bold mb-1">{{ curs.name < 50 ? curs.name : curs.name.substring(0,50) + "..." }}</p>
            <p class="text-muted mb-0">{{ curs.description < 30 ? curs.description : curs.description.substring(0,30) + "..." }}</p>
          </td>
          <td style="width:25%">
            <div class="d-flex align-items-center">
              <img src="https://mdbootstrap.com/img/new/avatars/8.jpg" alt="" style="width: 45px; height: 45px"
                class="rounded-circle">
              <div class="ms-3">
                <p class="fw-bold mb-1">John Doe</p>
                <p class="text-muted mb-0">john.doe@gmail.com</p>
              </div>
            </div>
          </td>
          <td style="width:15%">
            <span class="badge badge-success rounded-pill d-inline">Active</span>
          </td>
          <td style="width:10%">
            Senior
          </td>
          <td style="width:25%">
            <button type="button" class="btn btn-link btn-sm btn-rounded">
              Edit
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


</style>
<script>

export default {
  props: {
    cursos: {
      type: Object,
      required: true
    }
  },
  beforeMount() {
    this.cursosFiltrats = this.cursos
  },
  data() {
    return {
      cursosFiltrats: null,
      limit: 10,
      filterRegex: ''
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
      this.limit += 4;
      if (this.limit >= this.cursos.length) {
        this.limit = -1;
      }
    }
  }

}
</script>


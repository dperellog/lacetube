<template>
  <HeaderBackoffice></HeaderBackoffice>
  <div class="container mt-4 px-4">
    <h1 class="fw-bold">Crear un nou curs:</h1>
    <hr>
    <form @submit.prevent="nouCurs">
      <!-- Nom del curs -->
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label h4">Nom del curs:</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>

      <!-- Descrcipcio i pare -->
      <div class="row mb-3">
        <!-- Descripcio -->
        <div class="col-sm-8">
          <label for="exampleInputPassword1" class="form-label">Descripció del curs:</label>
          <textarea class="form-control" id="exampleFormControlTextarea1" rows="9"></textarea>
        </div>
        <!-- Pare -->
        <div class="col-sm-4">
          <label for="exampleInputPassword1" class="form-label">Pare:</label>
          <div v-if="cursos.data != null && !cursos.error" class="card p-2 parentCourses">
            <div v-for="curs in cursos.data" class="d-inline">
            <input class="form-check-input" type="radio" :id="'cursPare'+curs.id" name="cursPare" :value="curs.id">
            <label class="form-check-label text-break ms-1" :for="'cursPare'+curs.id">
              {{ curs.name }}
            </label>
            </div>
          </div>
        </div>
      </div>

      <!-- Estudiants -->
      <div class="row my-4">
        <!-- Descripcio -->
        <div class="col-sm-8">
          <label for="exampleInputPassword1" class="form-label h4">Assignar estudiants:</label>
          <textarea class="form-control" id="exampleFormControlTextarea1" rows="9"></textarea>
        </div>
        <!-- Pare -->
        <div class="col-sm-4">
          <label for="exampleInputPassword1" class="form-label">Pare:</label>
          <div v-if="cursos.data != null && !cursos.error" class="card p-2 parentCourses">
            <div v-for="curs in cursos.data" class="d-inline">
            <input class="form-check-input" type="radio" :id="'cursPare'+curs.id" name="cursPare" :value="curs.id">
            <label class="form-check-label text-break ms-1" :for="'cursPare'+curs.id">
              {{ curs.name }}
            </label>
            </div>
          </div>
        </div>
      </div>
      
      








      <button type="submit" class="btn btn-primary">Submit</button>

    </form>

  </div>
</template>
<style scoped>
.parentCourses{
  overflow-y: scroll;
  overflow-wrap: break-word;
  max-height: 14rem;
}
</style>
  
<script>
import HeaderBackoffice from '@/components/BO/headers/HeaderBackoffice.vue';
import Resources from '@/services/Resources';
import { useUserStore } from '@/stores/userStore';

export default {
  components: {
    HeaderBackoffice
  },
  setup() {
    return {
      userStore: useUserStore
    }
  },
  data() {
    return {
      error: null,
      cursos: {
        error: false,
        data: null
      },
    }
  },
  async beforeMount() {
    //Obtenir cursos del backend
    this.getCursos();
  },

  methods: {
    nouCurs() {

    },
    async getCursos() {
      let that = this;
      return Resources.getAllCourses()
        .then(r => {
          that.cursos.data = r.data.data;
        })
        .catch(e => {
          this.cursos.error = e;
        });
    },
  }
}
</script>
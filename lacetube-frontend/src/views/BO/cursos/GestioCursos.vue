<template>
  <HeaderBackoffice></HeaderBackoffice>
  <div class="container mt-4 px-4">
    <h1 class="fw-bold">Tots els cursos:</h1>
    <section class="mt-4">
      <!-- Llistat de cursos -->
      <div v-if="cursos != null">
        <div v-if="cursos.length > 0">
          <CursosTaula :cursos="cursos" btnNovaTaula></CursosTaula>
        </div>

        <div v-else class="alert alert-info" role="alert">
          No hi han cursos disponibles!
        </div>
      </div>

      <!-- Mostrar abans d'obtenir del backend: -->
      <div v-else>
        <div v-if="error" class="alert alert-danger" role="alert">
          ERROR: {{ error }}
        </div>
        <div v-else class="d-flex justify-content-center">
          <strong>Carregant cursos...</strong>
          <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
        </div>
      </div>
    </section>


    

  </div>
</template>
  
<script>
import HeaderBackoffice from '@/components/BO/headers/HeaderBackoffice.vue';
import CursosTaula from '@/components/BO/components/CursosTaula.vue';
import Resources from '@/services/Resources';

export default {
  name: 'TotsElsCursos',
  components: {
    HeaderBackoffice,
    CursosTaula
  },
  data() {
    return {
      cursos: null,
      error: null,
    }
  },
  async beforeMount() {
    //Obtenir cursos del backend
    this.cursos = await this.getCursos();
    console.log('this.cursos :>> ', this.cursos);
  },

  methods: {
    async getCursos() {
      return Resources.getAllCourses()
        .then(r => {
          return r.data.data;
        })
        .catch(e => {
          this.error = e;
        });
    },

    
  }
}
</script>
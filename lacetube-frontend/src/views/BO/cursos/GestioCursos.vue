<template>
  <HeaderBackoffice></HeaderBackoffice>
  <div class="main-content-section container mt-4 px-4">
    <h1 class="fw-bold">Tots els cursos:</h1>
    <section class="mt-4">
      <!-- Llistat de cursos -->
      <div v-if="cursos != null">
        <div v-if="cursos.length > 0">
          <CursosTaula :cursos="cursos" btnNovaTaula @refrescarTaula="refrescarTaula" :key="clau"></CursosTaula>
        </div>

        <div v-else>
          <div class="col-12 d-flex justify-content-end mb-3">
            <router-link to="/gestio/cursos/crear" class="btn btn-success" type="button">
              <i class="fa-solid fa-plus" style="color: #ffffff;"></i>&nbsp;&nbsp;
              Crear Curs
            </router-link>
          </div>
          <div class="alert alert-info" role="alert">
            No hi han cursos disponibles!
          </div>
          
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
  <FooterBackoffice></FooterBackoffice>
</template>
  
<script>
import HeaderBackoffice from '@/components/BO/headers/HeaderBackoffice.vue';
import FooterBackoffice from '@/components/BO/FooterBackoffice.vue';

import CursosTaula from '@/components/BO/components/CursosTaula.vue';
import Resources from '@/services/Resources';

export default {
  components: {
    HeaderBackoffice,
    FooterBackoffice,
    CursosTaula
  },
  data() {
    return {
      cursos: null,
      error: null,
      clau: 0
    }
  },
  async beforeMount() {
    //Obtenir cursos del backend
    this.cursos = await this.getCursos();
  },

  methods: {
    async getCursos() {
      return Resources.getAllCourses()
        .then(r => {
          return r.data;
        })
        .catch(e => {
          console.log('e :>> ', e);
          this.error = e;
        })
    },
    async refrescarTaula() {
      this.cursos = await this.getCursos();
      this.clau += 1;
    }
  }
}
</script>
<template>
  <HeaderBackoffice></HeaderBackoffice>

  <!-- Seleccionar Curs -->
  <div v-if="curs == null" class="container mt-4 px-4">
    <h1 class="fw-bold">Seleccionar curs:</h1>
    <section class="mt-4">
      <!-- Llistat de cursos -->
      <ElsMeusCursos mostrarTots emitCourse @cursSeleccionat="cursSeleccionat"></ElsMeusCursos>
    </section>
  </div>

  <div v-else class="container mt-4 px-4">
    <h1 class="fw-bold">Gestió de tasques:</h1>
    <h2 class="h4 text-secondary"><i class="fa-solid fa-graduation-cap"></i>&nbsp;&nbsp;{{ curs.name }}</h2>
    <a href="#" class="h6 text-decoration-none returnback" @click.prevent="curs = null"><i class="fa-solid fa-reply"></i>&nbsp;&nbsp;Gestionar un altre curs</a>
    <hr>
    <section class="mt-4">
      <!-- Llistat de tasques -->
    <h2 class="h3 mt-4 fw-bold">Tasques del curs:</h2>
    <div v-if="activitats.data != null && !activitats.error">
      <ActivitatsTaula :activitats="activitats.data" :curs="curs" @refrescarTaula="refrescarTaula()"></ActivitatsTaula>
    </div>

    <div v-else>
      <div v-if="activitats.error" class="alert alert-danger" role="alert">
        ERROR: {{ activitats.error }}
      </div>
      <div v-else class="d-flex justify-content-center">
        <strong>Carregant activitats...</strong>
        <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
      </div>
    </div>
    </section>
  </div>


  <FooterBackoffice></FooterBackoffice>
</template>
    
<style scoped>
.returnback{
  color: rgb(203, 203, 203)
}

.returnback:hover {
  color: rgb(138, 138, 138)
}
</style>
<script>
import HeaderBackoffice from '@/components/BO/headers/HeaderBackoffice.vue';
import FooterBackoffice from '@/components/BO/FooterBackoffice.vue';
import ElsMeusCursos from '@/components/FO/tauler/sections/ElsMeusCursos.vue';
import ActivitatsTaula from '@/components/BO/components/ActivitatsTaula.vue';

import cursService from '@/services/Resources';

export default {
  components: {
    HeaderBackoffice,
    FooterBackoffice,
    ElsMeusCursos,
    ActivitatsTaula
  },
  data() {
    return {
      curs: null,
      activitats: {
        error: false,
        data: null
      },
      clau: 0
    }
  },
  methods: {
    cursSeleccionat(event){
      this.curs = event;

      this.obtenirActivitats();
    },
    async obtenirActivitats() {
      let that = this;
      this.activitats = {
        error: false,
        data: null
      };

      await cursService.getCourseActivities(that.curs.id)
      .then(r => {
         that.activitats.data = r.data
      })
      .catch(e => {
        that.activitats.error = e
      })
    },
    async refrescarTaula() {
      await this.obtenirActivitats();

      this.clau += 1;
    }
  }
}
</script>
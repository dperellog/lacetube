<template>
  <HeaderBackoffice></HeaderBackoffice>
  <div class="container mt-4 px-4">
    <h1 class="fw-bold">Tots els usuaris:</h1>
    <section class="mt-4">
      <!-- Llistat de cursos -->
      <div v-if="usuaris != null">
        <div v-if="usuaris.length > 0">
          <UsuarisTaula :usuaris="usuaris" btnNovaTaula></UsuarisTaula>
        </div>

        <div v-else class="alert alert-info" role="alert">
          No hi han usuaris disponibles!
        </div>
      </div>

      <!-- Mostrar abans d'obtenir del backend: -->
      <div v-else>
        <div v-if="error" class="alert alert-danger" role="alert">
          ERROR: {{ error }}
        </div>
        <div v-else class="d-flex justify-content-center">
          <strong>Carregant usuaris...</strong>
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

import UsuarisTaula from '@/components/BO/components/UsuarisTaula.vue';
import Resources from '@/services/Resources';

export default {
  name: 'TotsElsCursos',
  components: {
    HeaderBackoffice,
    FooterBackoffice,
    UsuarisTaula
  },
  data() {
    return {
      usuaris: null,
      error: null,
    }
  },
  async beforeMount() {
    //Obtenir cursos del backend
    this.usuaris = await this.getUsuaris();
    console.log('this.usuaris :>> ', this.usuaris);
  },

  methods: {
    async getUsuaris() {
      return Resources.getAllUsers()
        .then(r => {
          return r.data;
        })
        .catch(e => {
          this.error = e;
        });
    },

    
  }
}
</script>
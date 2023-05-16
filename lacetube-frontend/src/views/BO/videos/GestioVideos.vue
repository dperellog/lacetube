<template>
  <HeaderBackoffice></HeaderBackoffice>
  <div class="main-content-section container mt-4 px-4">
    <h1 class="fw-bold">Gestió de videos:</h1>
    <section class="mt-4">
      <!-- Llistat de videos -->
      <div v-if="videos != null">
        <div v-if="videos.length > 0">
          <VideosTaula :videos="videos" btnNovaTaula @refrescarTaula="refrescarTaula" :key="clau"></VideosTaula>
        </div>

        <div v-else>
          <div class="col-12 d-flex justify-content-end mb-3">
            <router-link to="/gestio/videos/crear" class="btn btn-success" type="button">
              <i class="fa-solid fa-plus" style="color: #ffffff;"></i>&nbsp;&nbsp;
              Crear Curs
            </router-link>
          </div>
          <div class="alert alert-info" role="alert">
            No hi han videos disponibles!
          </div>
          
        </div>
      </div>

      <!-- Mostrar abans d'obtenir del backend: -->
      <div v-else>
        <div v-if="error" class="alert alert-danger" role="alert">
          ERROR: {{ error }}
        </div>
        <div v-else class="d-flex justify-content-center">
          <strong>Carregant videos...</strong>
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

import VideosTaula from '@/components/BO/components/VideosTaula.vue';
import Resources from '@/services/Resources';

export default {
  components: {
    HeaderBackoffice,
    FooterBackoffice,
    VideosTaula
  },
  data() {
    return {
      tascaID: 0,
      videos: null,
      clau: 0
    }
  },
  async beforeMount() {
    if (this.$route.query.activitat) {
      this.tascaID = this.$route.query.activitat;
    }

    //Obtenir videos del backend
    this.videos = await this.getVideos();
    console.log('this.videos :>> ', this.videos);
  },

  methods: {
    async getVideos() {
      return Resources.getVideos(this.tascaID)
        .then(r => {
          return r.data;
        })
        .catch(e => {
          this.error = e;
          this.$router.push('/404');
        })
    },

    async refrescarTaula() {
      this.videos = await this.getVideos(this.tascaID);
      this.clau += 1;
    }


  }
}
</script>
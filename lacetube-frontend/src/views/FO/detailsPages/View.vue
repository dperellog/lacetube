<template>
  <HeaderFrontoffice></HeaderFrontoffice>
  <div class="main-content-section container-fluid">
    <div v-if="video.data !== null">
      <div class="row gy-4">

        <!-- Video Player -->
        <div class="col-lg-10 px-4">
          <div class="text-center">
            <vue-plyr :options="playerOptions">
              <video controls crossorigin playsinline :data-poster="video.data.thumbnailURL">
                <source :src="video.data.streamingPath" type="application/vnd.apple.mpegurl" />
              </video>
            </vue-plyr>
          </div>

          <!-- Titol i info -->
          <div class="mt-3">
            <h2 class="h3 fw-bold">{{ video.data.title }}</h2>
            <h4 class="h6 text-secondary mt-2"><i class="fa-solid fa-paintbrush"></i>&nbsp;&nbsp;{{
              video.data.activity.name }}</h4>
            <h4 class="h6 text-secondary mt-2"><i class="fa-solid fa-graduation-cap"></i>&nbsp;&nbsp;{{
              video.data.activity.course.name }} - {{ video.data.teacher.name }}</h4>
          </div>

          <!-- Usuari del video -->
          <div class="card p-2 mt-3 pe-5" style="width: fit-content;">
            <router-link :to="{ path: '/usuari/' + video.data.user.id }"
              class="d-flex align-items-center text-decoration-none">
              <img :src="userService.getAvatarURLByAvatar(video.data.user.avatar)" alt="foto-usuari"
                style="width: 45px; height: 45px" class="rounded-circle">
              <div class="ms-3">
                <p class="fw-bold mb-1">{{ video.data.user.name }}</p>
                <p class="text-muted mb-0">{{ video.data.user.email }}</p>
              </div>
            </router-link>
          </div>

          <!-- Descripció -->
          <div class="card description mt-2">
            <h5 class="h6 fw-bold">Data de publicació: {{ dataPublicacio }}</h5>
            <p>{{ video.data.description }}</p>
          </div>

          <!-- Formulari per deixar comentari -->
          <div class="mt-4">

            <h4 class="fw-bold">Deixar valoració</h4>
            <hr>
            <ComentariForm :videoID="video.data.id" @nouComentari="mostrarNouComentari"></ComentariForm>
          </div>

          <!-- Comentaris -->
          <div class="mt-4">
            <h4 class="fw-bold">Comentaris</h4>
            <hr>
            <div class="my-4">
              <div v-if="comentariProfe">
                <Comentari class="my-4" :comentari="comentariProfe" professor></Comentari>
              </div>
              <div v-if="comentaris.length > 0">
                <Comentari class="my-4" v-for="comentari in comentaris" :comentari="comentari"></Comentari>
              </div>
              <div v-else class="alert alert-info" role="alert">
                No hi han comentaris disponibles! Sigues el primer en comentar :D
            </div>
            </div>
          </div>
        </div>

        <!-- Recomanats -->
        <div class="col-lg-2">
          <h4 class="fw-bold">Recomanats:</h4>
          <hr>
          <div v-if="recomendedVideos.length > 0">
            <router-link :to="{ path: '/video/' + video.id }" v-for="video in recomendedVideos"
              class="my-4 text-decoration-none ">
              <Video :video="video"></Video>
            </router-link>
          </div>
          <div v-else class="d-flex justify-content-center">
                <strong>Carregant videos recomanants...</strong>
                <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
            </div>
        </div>
      </div>


    </div>

    <!-- Mostrar abans d'obtenir del backend: -->
    <div v-else>
      <div v-if="error" class="alert alert-danger" role="alert">
        ERROR: {{ error }}
      </div>
      <div v-else class="d-flex justify-content-center">
        <strong>Carregant video...</strong>
        <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
      </div>
    </div>

  </div>


  <FooterFrontoffice></FooterFrontoffice>
</template>
  
<script>
import HeaderFrontoffice from '@/components/FO/HeaderFrontoffice.vue';
import FooterFrontoffice from '@/components/FO/FooterFrontoffice.vue';
import Video from '@/components/FO/components/Video.vue';
import ComentariForm from '@/components/FO/singlePages/watch/ComentariForm.vue';
import Comentari from '@/components/FO/components/Comentari.vue';

import videoService from '@/services/Resources';
import userService from '@/services/User';

import VuePlyr from 'vue-plyr';
import Hls from 'hls.js';
import moment from 'moment';

export default {
  components: {
    HeaderFrontoffice,
    FooterFrontoffice,
    VuePlyr,
    Video,
    ComentariForm,
    Comentari
  },
  props: {
    id: String
  },
  setup() {
    return {
      userService: userService
    }
  },
  data() {
    return {
      video: {
        error: false,
        data: null
      },
      playerOptions: {
        controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'settings', 'fullscreen'],
        settings: ['quality', 'speed', 'loop'],
      },
      recomendedVideos: [],
      comentaris: [],
      comentariProfe: null
    }
  },
  computed: {
    dataPublicacio() {
      return moment(this.video.data.publish_date, 'YYYY-MM-DD').format('LL')
    },
    player() {coment
      console.log(this.$refs.plyr.player);
      return this.$refs.plyr.player;
    },
  },
  async beforeMount() {
    let videoID = this.id;
    this.video.data = await videoService.getVideo(videoID)
      .then(r => {
        return r.data;
      });

    this.getRecomended()
    
    this.comentaris = this.video.data.comments;

    //Obtenir comentari del profe:
    this.comentariProfe = this.comentaris.filter(comentari => comentari.isTeacher).shift()

  },
  watch: {
    video() {
      if (video.data !== null) {
        this.videoMounted()
      }
    },
    comentaris() {
      this.comentaris = this.comentaris.sort((a, b) => moment(b.published_at).diff(moment(a.published_at)))
    }
  },
  methods: {
    videoMounted() {
      if (Hls.isSupported()) {
        const hls = new Hls();
        hls.loadSource(this.video.data.streamingPath);
        //hls.loadSource("http://api.lacetube.cat:8000/video/Y6nSEN5ggwWcy3vYFDvDgaLFzcvye4miBnoVU1tr/Y6nSEN5ggwWcy3vYFDvDgaLFzcvye4miBnoVU1tr_0_3000.m3u8");
        hls.attachMedia(this.player.media);

        window.hls = hls;
      }
    },
    getRecomended() {
      videoService.getRecomended(this.id)
        .then(r => {
          this.recomendedVideos = r.data
          console.log('r  :>> ', r)
        })
        .catch(e => console.log('e :>> ', e.response.data))
    },
    mostrarNouComentari(comentari) {
      this.comentaris.unshift(comentari)
    }
  }

}
</script>
<style scoped>
@media screen and (min-width: 700px){

  .main-content-section {
  padding: 2rem 10rem 2rem 8rem;
}
}


.card.description {
  background-color: #EAEAEA;
  border-color: #EAEAEA;
  box-shadow: 0px 3px 6px #00000026;
  border-radius: 1rem;

  padding: 0.5rem 1rem;
}
</style>
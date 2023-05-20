<template>
  <div class="row mb-3 justify-content-between">
    <div class="col-4 d-flex">
      <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Acció en massa
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#" @click.prevent="triggerEliminarVideos()">Eliminar</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- TAULA CURSOS -->
  <div class="card taula">
    <table class="card-table table">
      <thead class="card-header capcalera-taula">
        <tr>
          <th></th>
          <th @click="ordenarPer('titol')">Títol &nbsp;&nbsp;<i
              :class="['fa-solid', 'sortingArrow', columnesOrdre.titol ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i>
          </th>
          <th class="" @click="ordenarPer('usuari')">Usuari &nbsp;&nbsp;<i
              :class="['fa-solid', 'sortingArrow', columnesOrdre.usuari ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i>
          </th>
          <th class="" @click="ordenarPer('curs')">Curs &nbsp;&nbsp;<i
              :class="['fa-solid', 'sortingArrow', columnesOrdre.curs ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i>
          </th>
          <th class="text-center" @click="ordenarPer('entrega')">Data d'entrega &nbsp;&nbsp;<i
              :class="['fa-solid', 'sortingArrow', columnesOrdre.entrega ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short']"></i>
          </th>
          <th class="text-center">Accions</th>
        </tr>
      </thead>

      <tbody>
        
        <tr v-for="video in limitarArray(videosFiltrats)" :key="video.id">
          <!-- Check per marcar -->
          <td style="width:5%">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" :value="video" :id="'video' + video.id"
                v-model="videosModificar">
            </div>
          </td>

          <!-- Miniatura de video -->
          <td style="width:30%">
            <router-link :to="{path: '/video/'+video.id}" class="row text-decoration-none">
              <div class="col-4">
                <div class="thumbnail border rounded-2" :style="{ backgroundImage: 'url(' + video.thumbnailURL + ')' }"></div>
              </div>
              <div class="col-8">
                <p class="fw-bold mb-1">{{ video.title.length < 50 ? video.title : video.title.substring(0, 50) + "..." }}</p>
                <p class="text-muted mb-0">{{ video.description.length < 50 ? video.description :
                  video.description.substring(0, 50) + "..." }}</p>
              </div>
            </router-link>
          </td>

          <!-- Usuari -->
          <td style="width:20%">
            <router-link :to="{ path: '/usuari/' + video.user.id }" class="d-flex align-items-center text-decoration-none">
              <avatar :url="userService.getAvatarURLByAvatar(video.user.avatar)" :size="'sm'"></avatar>
              <div class="ms-3">
                <p class="fw-bold mb-1">{{ video.user.name }}</p>
                <p class="text-muted mb-0">{{ video.user.email }}</p>
              </div>
            </router-link>
          </td>

          <!-- Link al curs -->
          <td style="width:15%">
            <router-link :to="{ path: '/curs/' + video.activity.course.id }" class="text-primary fw-bold mb-1">{{
              video.activity.course.name.length < 50 ? video.activity.course.name :
              video.activity.course.name.substring(0, 50) + "..." }}</router-link>
            <p class="fw-bold text-secondary">{{ video.activity.name }}</p>
          </td>
          <td style="width:15%" class="text-center">
            {{ dataPublicacio(video.publish_date) }}
          </td>

          <!-- Accions -->
          <td class="text-center" style="width:15%">
            <router-link :to="{ path: '/video/' + video.id }" type="button"
              class="btn btn-sm btn-success m-1">
              Visualitzar
            </router-link>
            <button type="button" class="btn btn-sm btn-danger m-1" @click="triggerEliminarVideo(video)">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Botó mostrar més -->
    <a href="#" class="showMore text-center card-footer" v-if="limit != -1" @click.prevent="mostrarMes">Mostra'n més</a>
  </div>

  <!-- Confirmació eliminar video single -->
  <div class="modal fade" id="confirmacioEliminar" tabindex="-1" aria-labelledby="confirmacioEliminar" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="confirmacioEliminar">Segur que vols eliminar l'video?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Estas a punt d'eliminar el següent video: <span class="fw-bold text-dark">{{
            videoEliminar.data.title }}</span>
          </p>
          <p v-if="!videoEliminar.valid">Estas segur que vols eliminar l'video? <span
              class="fw-bold h6 text-danger">Aquesta acció no es pot revertir!</span></p>

          <!-- Missatge de confirmació -->
          <div class="mt-2" v-if="videoEliminar.loading">
            <div class="spinner-border spinner-border-sm text-secondary me-1" role="status">
              <span class="visually-hidden">Eliminant video...</span>
            </div>
            <span class="text-secondary">Eliminant video... </span>
          </div>
          <div class="mt-2" v-if="videoEliminar.error === true">
            <div class="alert alert-danger">
              <strong>Hi ha hagut un error!</strong>
              <p class="mb-0">{{ videoEliminar.errorMsg }}</p>
            </div>
          </div>
          <div class="mt-2" v-if="videoEliminar.error === false">
            <div class="alert alert-success">
              <strong>Acció completada: </strong>
              <p class="mb-0">S'ha eliminat el video exitosament!</p>
            </div>
          </div>
        </div>
        <div class="modal-footer" v-if="!videoEliminar.valid">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancel·lar</button>
          <button type="button" @click="eliminarVideo(videoEliminar.data.id)" class="btn btn-outline-danger">Eliminar
            Video</button>
        </div>
        <div class="modal-footer" v-else>
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tancar</button>
        </div>


      </div>
    </div>
  </div>

  <!-- Confirmació eliminar video multi -->
  <div class="modal fade" id="confirmacioEliminarMulti" tabindex="-1" aria-labelledby="confirmacioEliminarMulti"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="confirmacioEliminarMulti">Segur que vols eliminar tots aquests videos?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Estas a punt d'eliminar els següents videos: </p>
          <ul>
            <li v-for="video in videosModificar">
              <span class="fw-bold text-dark">{{ video.title }} - {{ video.user.email }}</span>
            </li>
          </ul>
          <p v-if="!videoEliminar.valid">Estas segur que vols eliminar aquests videos? <span
              class="fw-bold h6 text-danger">Aquesta acció no es pot revertir!</span></p>

          <!-- Missatge de confirmació -->
          <div class="mt-2" v-if="videoEliminar.loading">
            <div class="spinner-border spinner-border-sm text-secondary me-1" role="status">
              <span class="visually-hidden">Eliminant videos...</span>
            </div>
            <span class="text-secondary">Eliminant videos... </span>
          </div>
          <div class="mt-2" v-if="videoEliminar.error === true">
            <div class="alert alert-danger">
              <strong>Hi ha hagut un error!</strong>
              <p class="mb-0">{{ videoEliminar.errorMsg }}</p>
            </div>
          </div>
          <div class="mt-2" v-if="videoEliminar.error === false">
            <div class="alert alert-success">
              <strong>Acció completada: </strong>
              <p class="mb-0">S'han eliminat els videos exitosament!</p>
            </div>
          </div>
        </div>
        <div class="modal-footer" v-if="!videoEliminar.valid">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancel·lar</button>
          <button type="button" @click="eliminarVideos()" class="btn btn-outline-danger">Eliminar
            Videos</button>
        </div>
        <div class="modal-footer" v-else>
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tancar</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import userService from '@/services/User';
import Resources from '@/services/Resources';
import Avatar from '@/components/common/Avatar.vue';
import moment from 'moment';

export default {
  props: {
    videos: {
      type: Object,
      required: true
    },
    btnNovaTaula: {
      type: Boolean
    }
  },
  components: {
    Avatar
  },
  emits: ["refrescarTaula"],
  setup() {
    return {
      userService: userService
    }
  },
  beforeMount() {
    this.videosFiltrats = this.videos

    if (this.limit >= this.videos.length) {
      this.limit = -1;
    }
  },
  data() {
    return {
      videosFiltrats: null,
      columnesOrdre: {
        titol: true,
        usuari: true,
        curs: true,
        entrega: true,
      },
      limit: 10,
      filterRegex: '',
      columnCriteria: '',
      videosModificar: [],
      videoEliminar: {
        data: {
          id: '',
          name: ''
        }
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
      if (this.limit >= this.videos.length) {
        this.limit = -1;
      }
    },
    dataPublicacio(data) {
      return moment(data, 'YYYY-MM-DD').format('LL')
    },
    ordenarPer(atribut) {
      switch (atribut) {
        case 'titol':
          this.videosFiltrats = this.videos.sort((a, b) => (a.title > b.title) ? 1 : -1)
          break;
        case 'usuari':
          this.videosFiltrats = this.videos.sort((a, b) => (a.user.name > b.user.name) ? 1 : -1)
          break;
        case 'curs':
          this.videosFiltrats = this.videos.sort((a, b) => (a.activity.course.name > b.sactivity.course.name) ? 1 : -1)
          break;
        case 'entrega':
          this.videosFiltrats = this.videos.sort((a, b) => (a.publish_date > b.publish_date) ? 1 : -1)
          break;
      }

      if (this.columnesOrdre[atribut]) {
        this.videosFiltrats.reverse()
      }

      this.columnesOrdre[atribut] = !this.columnesOrdre[atribut]
    },
    triggerEliminarVideo(video) {
      this.videoEliminar.valid = false;
      this.videoEliminar.data = video;

      this.videoEliminar.alerta = new bootstrap.Modal(document.getElementById('confirmacioEliminar'), { backdrop: true })
      this.videoEliminar.alerta.show()
    },
    eliminarVideo(videoID) {
      //Reset defaults:
      this.videoEliminar.loading = true;
      this.videoEliminar.error = null;
      this.videoEliminar.errorMsg = '';
      let that = this;

      Resources.deleteVideo(videoID)
        .then(r => {
          that.videoEliminar.error = false;
          this.videoEliminar.valid = true;

          const alerta = document.getElementById('confirmacioEliminar')

          alerta.addEventListener('hidden.bs.modal', event => {
            that.$emit('refrescarTaula');
          })

        })
        .catch(e => {
          console.log('e :>> ', e);
          that.videoEliminar.error = true;
          that.videoEliminar.errorMsg = e.response.data.message;
        })
        .finally(() => {
          //Update UI:
          that.videoEliminar.loading = false;
        })
    },
    triggerEliminarVideos() {
      this.videoEliminar.valid = false;

      this.videoEliminar.alerta = new bootstrap.Modal(document.getElementById('confirmacioEliminarMulti'), { backdrop: true })
      this.videoEliminar.alerta.show()
    },
    async eliminarVideos() {
      //Reset defaults:
      this.videoEliminar.loading = true;
      this.videoEliminar.error = null;
      this.videoEliminar.errorMsg = '';
      let that = this;

      //Eliminar tots els videos:
      let videosAEliminar = this.videosModificar.map(video => {
        return Resources.deleteVideo(video.id)
      })

      Promise.all(videosAEliminar)
        .then(responses => {
          this.videoEliminar.error = false;
          this.videoEliminar.valid = true;

          const alerta = document.getElementById('confirmacioEliminarMulti')

          alerta.addEventListener('hidden.bs.modal', event => {
            that.$emit('refrescarTaula');
          })
        })
        .catch(error => {
          console.log('errors :>> ', error);
          that.videoEliminar.error = true;
          that.videoEliminar.errorMsg = e.response.data.message;
        })
        .finally(() => {
          this.videoEliminar.loading = false;
        })
    }
  }

}
</script>

<style scoped>
.table {
  margin-bottom: 0em;
}

.card.taula {
  overflow-x: auto;
}

.sortingArrow {
  color: #7F8C8D;
}

.sortingArrow:hover {
  color: #212529;
}
.thumbnail {
    width: 100%;
    padding-bottom: 56.25%;
    overflow: hidden;
    background-position: center;
    background-size: cover;
}
</style>
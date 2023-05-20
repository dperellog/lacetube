<template>
  <HeaderFrontoffice></HeaderFrontoffice>
  <div class="main-content-section">

    <div v-if="curs !== null" class="container mt-4 px-4">
      <div class="thumbnail border rounded-4" :style="{ backgroundImage: 'url(' + curs.thumbnailURL + ')' }"></div>
      <h1 class="h2 mt-4">{{ curs.name }}</h1>
      <hr>
      <!-- Breadcrumbs -->
      <ol class="breadcrumb ps-0">
        <li v-if="curs.parent.parent_id != undefined" class="breadcrumb-item text-secondary"><router-link
            class="text-secondary text-decoration-none" :to="{ path: '/curs/' + curs.parent.parent_id }">>></router-link>
        </li>
        <li v-if="curs.parent != undefined" class="breadcrumb-item"><router-link
            class="text-secondary text-decoration-none" :to="{ path: '/curs/' + curs.parent.id }">{{ curs.parent.name
            }}</router-link></li>
        <li class="breadcrumb-item text-warning">{{ curs.name }}</li>
      </ol>

      <!-- Capçalera curs -->
      <div class="row">

        <!-- Descripcio curs -->
        <div class="col-sm-7">
          <p class="text-dark">{{ curs.description }}</p>
        </div>

        <!-- Professor-Estudiants -->
        <div class="col-sm-5">
          <div class="bs-component">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" data-bs-toggle="tab" href="#professor" aria-selected="true" role="tab"><i
                    class="fa-solid fa-user-graduate"></i>&nbsp;&nbsp;Professor</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#estudiants" aria-selected="false" role="tab"><i
                    class="fa-solid fa-users"></i>&nbsp;&nbsp;Estudiants<span
                    class="ms-2 badge bg-success rounded-pill">{{ curs.students.length }}</span></a>
              </li>
            </ul>

            <div id="myTabContent" class="tab-content">
              <!-- Professor -->
              <div class="tab-pane show active fade" id="professor" role="tabpanel">
                <div class="card p-2">
                  <router-link :to="{ path: '/usuari/' + curs.teacher.id }"
                    class="d-flex align-items-center text-decoration-none">
                    <Avatar :url="userService.getAvatarURLByAvatar(curs.teacher.avatar)" :size="'sm'" alt="foto-professor"></Avatar>
                    <div class="ms-3">
                      <p class="fw-bold mb-1">{{ curs.teacher.name }}</p>
                      <p class="text-muted mb-0">{{ curs.teacher.email }}</p>
                    </div>
                  </router-link>
                </div>
              </div>

              <!-- Estudiants -->
              <div class="tab-pane fade show" id="estudiants" role="tabpanel">
                <div class="card taula">
                  <table class="card-table table">
                    <tbody>
                      <tr v-for="usuari in curs.students" :key="usuari.id">
                        <td>
                          <router-link :to="{ path: '/usuari/' + usuari.id }"
                            class="d-flex align-items-center text-decoration-none">
                            <Avatar :url="userService.getAvatarURLByAvatar(usuari.avatar)" :size="'sm'"></Avatar>
                            <div class="ms-3">
                              <p class="fw-bold mb-1">{{ usuari.name }}</p>
                              <p class="text-muted mb-0">{{ usuari.email }}</p>
                            </div>
                          </router-link>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Llistat de tasques -->
      <div class="row d-flex justify-content-between">
        <h2 class="h3 mt-4 fw-bold col-sm-auto">Tasques del curs:</h2>
        <div class="col-sm-auto btn mt-4 btn-secondary" @click="invertirOrdre"
          :title="!ordreInvertit ? 'Ordenar de recents a antigues' : 'Ordenar d\'antigues a recents'" style="height: 2.4rem;">
          <i v-if="!ordreInvertit" class="fa-solid fa-arrow-down-short-wide"></i>
          <i v-else class="fa-solid fa-arrow-up-wide-short"></i>
        </div>
      </div>

      <div v-if="activitats.data != null && !activitats.error">
        <div v-if="activitats.data.length == 0" class="alert alert-info" role="alert">
          No hi han activitats disponibles!
        </div>
        <div v-else>
          <Tasca class="my-4" v-for="activitat in activitats.data" :activitat="activitat" :disseny="'detall'"></Tasca>
        </div>
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


    </div>
  </div>
  <FooterFrontoffice></FooterFrontoffice>
</template>
  
<script>
import HeaderFrontoffice from '@/components/FO/HeaderFrontoffice.vue';
import FooterFrontoffice from '@/components/FO/FooterFrontoffice.vue';
import Tasca from '@/components/FO/components/Tasca.vue';
import Avatar from '@/components/common/Avatar.vue'

import cursService from '@/services/Resources';
import userService from '@/services/User';

import moment from 'moment';

export default {
  components: {
    HeaderFrontoffice,
    FooterFrontoffice,
    Tasca,
    Avatar
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
      curs: null,
      activitats: {
        error: false,
        data: null
      },
      ordreInvertit: false
    }
  },
  async beforeMount() {
    let cursID = this.id;
    this.curs = await userService.getCourses().then(cursos => cursos.filter(curs => curs.id == cursID).shift())
    if (this.curs == undefined) {
      this.$router.push('/404')
    }
    let that = this;

    await cursService.getCourseActivities(this.id)
      .then(r => {
        that.activitats.data = r.data.sort((a, b) => moment(b.end_date).diff(moment(a.end_date))).reverse();
      })
      .catch(e => {
        console.log('e :>> ', e);
        that.activitats.error = e
      })
  },
  methods: {
    invertirOrdre() {
      this.ordreInvertit = !this.ordreInvertit;
      this.activitats.data = this.activitats.data.reverse();
    }
  }
}
</script>

<style scoped>
.thumbnail {
  height: 20rem;
  overflow: hidden;
  background-position: center;
  background-size: cover;
}
</style>
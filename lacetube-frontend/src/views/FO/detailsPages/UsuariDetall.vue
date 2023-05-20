<template>
  <HeaderFrontoffice></HeaderFrontoffice>
  <div class="main-content-section container mt-4 px-4">
    <div v-if="usuari != null">
      <!-- Capçalera -->
      <div class="card userheader">
        <div class="row card-body">
          <div class="col-sm-auto">
            <Avatar :url="userService.getAvatarURLByAvatar(usuari.avatar)" :size="'lg'"></Avatar>
          </div>
          <div class="col-sm">
            <h2 class="fw-bold">{{ usuari.name }}</h2>
            <h4 class="text-secondary fst-italic">{{ usuari.email }}</h4>
            <h5 class="text-secondary"><i class="fa-solid fa-user"></i>&nbsp;&nbsp;{{ userService.translateRole(rol) }}
            </h5>
          </div>
        </div>
      </div>

      <!-- Videos de l'usuari -->
      <h2 class="my-4 col-8 fw-bold mt-5">Videos de l'usuari:</h2>
      <ElsMeusVideos :inputVideos="usuari.videos"></ElsMeusVideos>

      <!-- Cursos i professors de l'usuari -->
      <h2 class="my-5 col-8 fw-bold mt-5">Cursos de l'usuari:</h2>
      <div class="row">

        <!-- Cursos -->
        <div :class="[rol == 'student' ? 'col-lg-8' : 'col-lg-12']">
          <ElsMeusCursos :="inputCursos"></ElsMeusCursos>
        </div>

        <!-- Professors -->
        <div v-if="rol == 'student'" class="col-lg-4 mt-4 mt-lg-0">
          <h4 class="fw-bold">Professors de l'estudiant:</h4>
          <div class="card taula">
            <table class="card-table table">
              <tbody>
                <tr v-for="professor in professors" :key="professor.id">
                  <td>
                    <router-link :to="{ path: '/usuari/' + professor.id }"
                      class="d-flex align-items-center text-decoration-none">
                      <Avatar :url="userService.getAvatarURLByAvatar(professor.avatar)" :size="'sm'"></Avatar>
                      <div class="ms-3">
                        <p class="fw-bold mb-1">{{ professor.name }}</p>
                        <p class="text-muted mb-0">{{ professor.email }}</p>
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
    <div v-else>
      <div class="d-flex justify-content-center">
        <strong>Carregant usuari...</strong>
        <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
      </div>
    </div>
  </div>
  <FooterFrontoffice></FooterFrontoffice>
</template>
  
<script>
import HeaderFrontoffice from '@/components/FO/HeaderFrontoffice.vue';
import FooterFrontoffice from '@/components/FO/FooterFrontoffice.vue';
import Avatar from '@/components/common/Avatar.vue';
import ElsMeusVideos from '@/components/FO/tauler/sections/ElsMeusVideos.vue';
import ElsMeusCursos from '@/components/FO/tauler/sections/ElsMeusCursos.vue';

import userService from '@/services/User.js';

export default {
  components: {
    HeaderFrontoffice,
    FooterFrontoffice,
    Avatar,
    ElsMeusVideos,
    ElsMeusCursos
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
      usuari: null,
      rol: null,
      professors: []
    }
  },
  async beforeMount() {
    //Obtenir usuari:

    await userService.getUserByID(this.id)
      .then(r => {
        this.usuari = r.data;
      })
      .catch(e => console.log('e :>> ', e))

    this.rol = this.usuari.roles.join()

    if (this.rol == 'student') {
      this.obtenirProfessors()
    }


  },
  methods: {
    obtenirProfessors() {
      let professors = []

      //Mirar per cada curs el seu professor i si no existeix al array afegir-lo.
      this.usuari.courses.forEach(curs => {
        if (!professors.some(prof => prof.id == curs.teacher.id)) {
          professors.push(curs.teacher)
        }
      })

      this.professors = professors;
    }
  }

}
</script>
<style scoped>
.card.userheader {
  background-color: #ffffff;
  border-color: #F9F7F3;
  border-radius: 2rem;
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}
</style>
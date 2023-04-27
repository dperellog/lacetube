<template>
  <HeaderBackoffice></HeaderBackoffice>
  <div class="container mt-4 px-4">
    <h1 class="fw-bold" v-if="!modificar">Crear un nou curs:</h1>
    <h1 class="fw-bold" v-else>Modificant curs:</h1>
    <hr>
    <form @submit.prevent="nouCurs">
      <!-- Nom del curs -->
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label h4">Nom del curs:</label>
        <input type="text" class="form-control" v-model="cursForm.name">
      </div>

      <!-- Descrcipcio i pare -->
      <div class="row mb-3">
        <!-- Descripcio -->
        <div class="col-sm-8">
          <label for="exampleInputPassword1" class="form-label">Descripció del curs:</label>
          <textarea class="form-control" rows="9" v-model="cursForm.description"></textarea>
        </div>
        <!-- Pare -->
        <div class="col-sm-4">
          <label for="exampleInputPassword1" class="form-label">Pare:</label>
          <div v-if="cursos.data != null && !cursos.error" class="card p-2 parentCourses">
            <div v-for="curs in cursos.data" class="d-inline">
              <input class="form-check-input" type="radio" :id="'cursPare' + curs.id" name="cursPare" :value="curs.id" v-model="cursForm.parent_id">
              <label class="form-check-label text-break ms-1" :for="'cursPare' + curs.id">
                {{ curs.name }}
              </label>
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
        </div>
      </div>

      <!-- Estudiants -->
      <div class="row my-4">
        <!-- Descripcio -->
        <div class="col-sm-8">
          <label for="exampleInputPassword1" class="form-label h4">Assignar estudiants:</label>
          <div v-if="estudiants.data != null && !estudiants.error" class="card p-2 parentCourses">
            <div v-for="estudiant in estudiants.data" class="d-inline">
              <input class="form-check-input" type="checkbox" :id="'estudiant' + estudiant.id" name="estudiants" :value="estudiant.id" v-model="cursForm.students">
              <label class="form-check-label text-break ms-1" :for="'cursPare' + estudiant.id">
                {{ estudiant.name }}
              </label>
            </div>
          </div>

          <div v-else>
            <div v-if="error" class="alert alert-danger" role="alert">
              ERROR: {{ error }}
            </div>
            <div v-else class="d-flex justify-content-center">
              <strong>Carregant estudiants...</strong>
              <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
            </div>
          </div>

        </div>
        <!-- Professor -->
        <div class="col-sm-4">
          <label for="exampleInputPassword1" class="form-label">Professor:</label>
          <div class="card p-2">
            <div class="d-flex align-items-center">
              <img :src="userService.getAvatarURLByAvatar(cursForm.teacher.avatar)" alt="" style="width: 45px; height: 45px"
                class="rounded-circle">
              <div class="ms-3">
                <p class="fw-bold mb-1">{{ cursForm.teacher.name}}</p>
                <p class="text-muted mb-0">{{ cursForm.teacher.email }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <button v-if="!modificar" type="submit" class="btn btn-success" @click.prevent="crearCurs">Crear Curs</button>
      <button v-else type="submit" class="btn btn-success">Modificar</button>

    </form>

  </div>

  <FooterBackoffice></FooterBackoffice>
</template>
<style scoped>
.parentCourses {
  overflow-y: scroll;
  overflow-wrap: break-word;
  max-height: 14rem;
}
</style>
  
<script>
import HeaderBackoffice from '@/components/BO/headers/HeaderBackoffice.vue';
import FooterBackoffice from '@/components/BO/FooterBackoffice.vue';

import Resources from '@/services/Resources';
import userService from '@/services/User'
import { useUserStore } from '@/stores/userStore';

import moment from 'moment';

export default {
  components: {
    HeaderBackoffice,
    FooterBackoffice
  },
  props : {
    id: String
  },
  setup() {
    const userStore = useUserStore();
    return {
      userStore: userStore,
      userService: userService
    }
  },
  data() {
    return {
      cursForm:{
        name: '',
        description: '',
        parent_id: null,
        students: [],
        teacher: {},
        teacher_id: 0,
        year: moment().year()
      },
      modificar: false,

      currentUser: null,
      error: null,
      cursos: {
        error: false,
        data: null
      },
      estudiants: {
        error: false,
        data: null
      },
    }
  },
  async beforeMount() {
    if (this.id) {
      //Obtenir curs a modificar del backend:
      this.modificar = true;
      let curs = await this.getCurs(this.id)

      console.log('curs :>> ', curs);
      this.cursForm = {
        name: curs.name,
        description: curs.description,
        parent: curs.parent != null? curs.parent.id : null,
        students: curs.students.map(v => v.id),
        teacher: curs.teacher,
        teacher_id: curs.teacher.id,
        year: curs.year
      }


    }

    if (!this.modificar) {
      this.cursForm.teacher = {
        id: this.userStore.currentUser.id,
        name: this.userStore.currentUser.name,
        email: this.userStore.currentUser.email,
        avatar: this.userStore.currentUser.avatar
      }

      this.cursForm.teacher_id = this.userStore.currentUser.id;
    }
    //Obtenir cursos del backend:
    this.getCursos();
    this.getEstudiants();

    console.log('modificar :>> ', this.modificar);
  },

  methods: {
    async crearCurs() {
      let curs = { ...this.cursForm};

      curs.teacher_id = curs.teacher.id;
      Resources.createCourse(this.cursForm)
      .then(r => {
        console.log('r :>> ', r);
      })
      .catch(e => {
        console.log('e :>> ', e);
      })
    },
    async getCurs(id) {
      let that = this;
      return Resources.getCourse(id)
        .then(r => {
          return r.data
        })
        .catch(e => {
          console.log('e :>> ', e);
          return e
        });
    },
    async getCursos() {
      let that = this;
      return Resources.getAllCourses()
        .then(r => {
          that.cursos.data = r.data;
        })
        .catch(e => {
          this.cursos.error = e;
        });
    },
    async getEstudiants() {
      let that = this;
      return Resources.getAllStudents()
        .then(r => {
          that.estudiants.data = r.data.data;
        })
        .catch(e => {
          this.estudiants.error = e;
        });
    },
  }
}
</script>
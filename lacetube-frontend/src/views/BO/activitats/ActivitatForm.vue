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
            <div v-if="cursos.data.length == 0" class="alert alert-info" role="alert">
              No hi han cursos disponibles!
            </div>
            <div v-else>
              <div v-for="curs in cursos.data" class="form-check">
                <input class="form-check-input" type="radio" :id="'cursPare' + curs.id" name="cursPare" :value="curs.id"
                  v-model="cursForm.parent_id">
                <label class="form-check-label text-break ms-1" :for="'cursPare' + curs.id">
                  {{ curs.name }}
                </label>
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
        </div>
      </div>

      <!-- Estudiants -->
      <div class="row my-4">
        <!-- Descripcio -->
        <div class="col-sm-8">
          <label for="exampleInputPassword1" class="form-label h4">Assignar estudiants:</label>
          <div v-if="estudiants.data != null && !estudiants.error" class="card p-2 parentCourses">
            <div v-if="estudiants.data.length == 0" class="alert alert-info" role="alert">
              No hi han estudiants disponibles!
            </div>
            <div v-else>
              <div v-for="estudiant in estudiants.data" class="form-check">
                <input class="form-check-input" type="checkbox" :id="'estudiant' + estudiant.id" name="estudiants"
                  :value="estudiant.id" v-model="cursForm.students">
                <label class="form-check-label text-break ms-1" :for="'cursPare' + estudiant.id">
                  {{ estudiant.name }} <span class="text-dark fst-italic">({{ estudiant.email }})</span>
                </label>
              </div>
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
          <div class="row justify-content-between">
            <label for="exampleInputPassword1" class="form-label col-6">Professor:</label>
            <a href="#" v-if="userStore.hasRole('admin')" class="text-secondary col-6 text-end"
              @click.prevent="actualitzarProfessor">Cambiar professor</a>
          </div>

          <!-- Mostrar professor actual -->
          <div v-if="!llistarProfessors" class="card p-2">
            <div class="d-flex align-items-center">
              <img :src="userService.getAvatarURLByAvatar(cursForm.teacher.avatar)" alt="foto-professor"
                style="width: 45px; height: 45px" class="rounded-circle">
              <div class="ms-3">
                <p class="fw-bold mb-1">{{ cursForm.teacher.name }}</p>
                <p class="text-muted mb-0">{{ cursForm.teacher.email }}</p>
              </div>
            </div>
          </div>

          <!-- Mostrar llista de professors -->
          <div v-else>
            <div v-if="professors.data != null && !professors.error" class="card p-2 parentCourses">
              <div v-if="professors.data.length == 0" class="alert alert-info" role="alert">
                No hi han professors disponibles!
              </div>
              <div v-else>
                <div v-for="professor in professors.data" class="form-check">
                  <input class="form-check-input" type="radio" :id="'prof' + professor.id" name="professors"
                    :value="professor.id" v-model="cursForm.teacher_id" @change="llistarProfessors = false">
                  <label class="form-check-label text-break ms-1" :for="'prof' + professor.id">
                    {{ professor.name }} <span class="text-dark fst-italic">({{ professor.email }})</span>
                  </label>
                </div>
              </div>
            </div>

            <div v-else>
              <div v-if="professors.error" class="alert alert-danger" role="alert">
                ERROR: {{ professors.error }}
              </div>
              <div v-else class="d-flex justify-content-center">
                <strong>Carregant professors...</strong>
                <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <button v-if="!modificar" type="submit" class="btn btn-success" @click.prevent="crearCurs">Crear Curs</button>
      <button v-else type="submit" class="btn btn-success" @click.prevent="modificarCurs">Modificar</button>
      <router-link v-if="modificar" :to="{ path: '/curs/' + cursForm.id }" class="btn btn-info ms-2">Veure el curs</router-link>

    </form>

    <div class="mt-2" v-if="formStatus.loading">
      <div class="spinner-border spinner-border-sm text-secondary me-1" role="status">
        <span class="visually-hidden">Creant curs...</span>
      </div>
      <span class="text-secondary" v-if="!modificar">Creant curs... </span>
      <span class="text-secondary" v-else>Modificant curs... </span>
    </div>

    <div class="mt-2" v-if="formStatus.error === true">
      <div class="alert alert-dismissible alert-danger">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Hi ha hagut un error!</strong>
        <p class="mb-0">{{ formStatus.errorMsg }}</p>
      </div>
    </div>
    <div class="mt-2" v-if="formStatus.error === false">
      <div class="alert alert-dismissible alert-success">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Acció completada: </strong>
        <p class="mb-0" v-if="!modificar">S'ha creat el curs exitosament!</p>
        <p class="mb-0" v-else>S'ha modificat el curs exitosament!</p>
      </div>
    </div>

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
  props: {
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
      cursForm: {
        id: 0,
        name: '',
        description: '',
        parent_id: null,
        students: [],
        teacher: {},
        teacher_id: 0,
        year: moment().year(),
        thumbnailURL: 'https://educaciodigital.cat/inslacetania/moodle/pluginfile.php/216009/course/overviewfiles/backend.png'
      },
      formStatus: {
        error: null,
        errorMsg: '',
        loading: false,
        valid: false,
      },
      modificar: false,
      llistarProfessors: false,
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
      professors: {
        error: false,
        data: null
      }
    }
  },
  async beforeMount() {
    if (this.id) {
      //Obtenir curs a modificar del backend:
      this.modificar = true;
      let curs = await this.getCurs(this.id)

      console.log('curs :>> ', curs);
      this.cursForm = {
        id: curs.id,
        name: curs.name,
        description: curs.description,
        parent_id: curs.parent != null ? curs.parent.id : null,
        students: curs.students.map(v => v.id),
        teacher: curs.teacher,
        teacher_id: curs.teacher.id,
        year: curs.year,
        thumbnailURL: curs.thumbnailURL
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
      //Reset defaults:
      this.formStatus.loading = true;
      this.formStatus.error = null;
      this.formStatus.errorMsg = '';
      let that = this;

      Resources.createCourse(this.cursForm)
        .then(r => {
          console.log('r :>> ', r);
          that.formStatus.error = false;
        })
        .catch(e => {
          console.log('e :>> ', e);
          that.formStatus.error = true;
          that.formStatus.errorMsg = e.response.data.message;
        })
        .finally(() => {
          //Update UI:
          that.formStatus.loading = false;
        })
    },
    async modificarCurs() {
      //Reset defaults:
      this.formStatus.loading = true;
      this.formStatus.error = null;
      this.formStatus.errorMsg = '';
      let that = this;

      Resources.modifyCourse(this.cursForm)
        .then(r => {
          console.log('r :>> ', r);
          that.formStatus.error = false;
        })
        .catch(e => {
          console.log('e :>> ', e);
          that.formStatus.error = true;
          that.formStatus.errorMsg = e.response.data.message;
        })
        .finally(() => {
          that.formStatus.loading = false;
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
          //Ordenar per email:
          that.estudiants.data = r.data.data.sort((a, b) => (a.email > b.email) ? 1 : -1)
        })
        .catch(e => {
          this.estudiants.error = e;
        });
    },
    async getProfessors() {
      let that = this;
      return Resources.getAllTeachers()
        .then(r => {
          //Ordenar per email:
          that.professors.data = r.data.data.sort((a, b) => (a.email > b.email) ? 1 : -1)
        })
        .catch(e => {
          this.professors.error = e;
        });
    },
    actualitzarProfessor() {
      this.llistarProfessors = !this.llistarProfessors
      this.getProfessors()
    },
    
  },
  watch: {
    'cursForm.teacher_id': {
      handler(newID, oldID) {

        if (this.professors.data !== null && this.professors.data.length > 0) {
          this.cursForm.teacher = this.professors.data.filter(prof => prof.id == newID).shift()
        }
      
      },
      deep: true
    }
    
  },
}
</script>
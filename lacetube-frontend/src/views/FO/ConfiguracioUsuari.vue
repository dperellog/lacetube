<template>
  <HeaderFrontoffice></HeaderFrontoffice>
  <div class="main-content-section container mt-4 px-4">
    <h2 class="fw-bold">Configuració del compte:</h2>
    <hr>
    <div class="row gy-4">

      <!-- Secció Avatar -->
      <section class="col-sm-6">
        <h4>Actualitzar avatar:</h4>
        <div class="card py-4">

          <!-- Avatar Actual -->
          <div class="text-center">
            <h5 class="text-decoration-underline mb-3">Avatar actual</h5>
            <avatar :url="userService.getAvatarURLByAvatar(userStore.currentUser.avatar)" :size="'lg'"></avatar>
          </div>

          <!-- Formulari actualitzar -->
          <div class="card card-grey p-4 mt-3 mx-3">
            <h5>Actualitzar Avatar:</h5>
            <div class="mb-2 card p-2">
              <label for="formFile" class="form-label">Seleccionar nou avatar</label>
              <input class="form-control" type="file" @change="avatarChange()" accept="image/*" ref="newAvatar">
            </div>
            <button class="btn btn-outline-danger" @click="eliminarAvatar">Eliminar avatar</button>
          </div>
        </div>
      </section>

      <!-- Secció contrasenya -->
      <section class="col-sm-6">
        <h4>Modificar contrasenya:</h4>
        <div class="card card-grey p-4 py-4">
          <div class="mb-2 p-2">
            <label for="formFile" class="form-label">Contrasenya actual:</label>
            <input class="form-control" type="password" v-model="updatePasswordForm.formData.old_password">
          </div>
          <div class="mb-2 p-2">
            <label for="formFile" class="form-label">Nova contrasenya actual:</label>
            <input class="form-control" type="password" v-model="updatePasswordForm.formData.new_password">
          </div>
          <div class="mb-2 p-2">
            <label for="formFile" class="form-label">Confirmar contrasenya:</label>
            <input class="form-control" type="password" v-model="updatePasswordForm.formData.password_confirmation">
          </div>

          <!-- Botó d'enviar -->
          <div class="d-flex justify-content-between flex-row-reverse mt-4">
            <div class="mb-2 p-2 text-end">
              <input class="btn btn-warning" type="submit" value="Actualitzar Contrasenya"
                :disabled="!updatePasswordFormValid" @click="updatePassword">
            </div>

            <!-- Mostrar carregant -->
            <div class="mt-2 ms-4" v-if="updatePasswordForm.status.loading">
              <div class="spinner-border spinner-border-sm text-secondary me-1" role="status">
                <span class="visually-hidden">Actualitzant contrasenya...</span>
              </div>
              <span class="text-secondary">Actualitzant contrasenya... </span>
            </div>
          </div>

          <!-- Mostrar carregant comentari -->


          <!-- Confirmació de modiciacio -->
          <div class="mt-2" v-if="updatePasswordForm.status.error === true">
            <div class="alert alert-dismissible alert-danger">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <strong>Hi ha hagut un error!</strong>
              <p class="mb-0">{{ updatePasswordForm.status.errorMsg }}</p>
            </div>
          </div>
          <div class="mt-2" v-if="updatePasswordForm.status.updated">
            <div class="alert alert-dismissible alert-success">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <strong>Acció completada: </strong>
              <p class="mb-0" v-if="!modificar">S'ha actualitzat la contrasenya exitosament!</p>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <FooterFrontoffice></FooterFrontoffice>
</template>
  
<script>
import HeaderFrontoffice from '@/components/FO/HeaderFrontoffice.vue';
import FooterFrontoffice from '@/components/FO/FooterFrontoffice.vue';
import Avatar from '@/components/common/Avatar.vue';

import userService from '@/services/User.js';
import { useUserStore } from '@/stores/userStore';

export default {
  components: {
    HeaderFrontoffice,
    FooterFrontoffice,
    Avatar
  },
  props: {
  },
  setup() {
    let userStore = useUserStore();
    return {
      userService: userService,
      userStore: userStore
    }
  },
  data() {
    return {
      updatePasswordForm: {
        status: {
          error: false,
          errorMsg: '',
          loading: false,
          updated: false
        },
        formData: {
          old_password: '',
          new_password: '',
          password_confirmation: ''
        }
      }
    }
  },
  async beforeMount() {

  },
  computed: {
    updatePasswordFormValid() {
      let valid = true;
      let form = this.updatePasswordForm.formData

      if (form.old_password.length < 4) {
        valid = false;
      }

      if (form.new_password.length < 4) {
        valid = false;
      }

      if (form.new_password != form.password_confirmation) {
        valid = false;
      }

      return valid
    }
  },
  methods: {
    updatePassword() {
      //Reset defaults:
      this.updatePasswordForm.status.loading = true;
      this.updatePasswordForm.status.error = false;
      this.updatePasswordForm.status.errorMsg = '';
      let form = this.updatePasswordForm;

      //Eliminar la confirmació de password
      delete form.formData.password_confirmation;

      this.userStore.updatePassword(form.formData)
        .then(() => {
          //Password change success:
          form.status.updated = true;

        })
        .catch(function (error) {
          //Login Failed:
          console.log('error :>> ', error);
          form.status.error = true;
          form.status.errorMsg = error.response.data
        })
        .finally(() => {
          //Update UI:
          form.status.loading = false;
          form.formData.old_password = '';
          form.formData.new_password = '';
        })
    },

    avatarChange() {
      console.log('object :>> ', this.$refs.newAvatar.files[0]);

      //Si l'usuari ha penjat una foto nova:
      if (this.$refs.newAvatar.files[0] !== undefined) {
        const formData = new FormData();
        formData.append('avatar', this.$refs.newAvatar.files[0]);

        userService.updateAvatar(formData)
          .then(r => {
            this.userStore.refreshAvatar(r.data.avatar)
          })
          .catch(e => console.log('e :>> ', e))
      }
    },
    eliminarAvatar() {
      const formData = new FormData();

      userService.updateAvatar(formData)
        .then(r => {
          this.userStore.refreshAvatar(r.data.avatar)
        })
        .catch(e => console.log('e :>> ', e))
    }
  }

}
</script>
<style scoped>
.card-grey {
  background-color: #EAEAEA;
  border-color: #F9F7F3;
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}
</style>
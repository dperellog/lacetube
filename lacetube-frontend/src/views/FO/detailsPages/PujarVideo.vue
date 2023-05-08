<template>
    <HeaderFrontoffice></HeaderFrontoffice>
    <div v-if="activitat.data !== null" class="container mt-4 px-4">
        <h1 class="h2">Pujar video</h1>
        <hr>

        <!-- Informació de tasca -->
        <h3>Informació de la tasca:</h3>
        <div class="card bg-white p-3">
            <div class="row justify-content-between">
                <div class="col-sm-7">
                    <h3 class="fw-bold h4">{{ activitat.data.name }}</h3>
                    <p>{{ activitat.data.description }}</p>
                </div>
                <div class="col-sm-4">
                    <p class="fw-bold fst-italic m-0">Professor:</p>
                    <div class="card p-2">
                        <div class="d-flex align-items-center">
                            <img :src="userService.getAvatarURLByAvatar(activitat.data.teacher.avatar)" alt="foto-professor"
                                style="width: 45px; height: 45px" class="rounded-circle">
                            <div class="ms-3">
                                <p class="fw-bold mb-1">{{ activitat.data.teacher.name }}</p>
                                <p class="text-muted mb-0">{{ activitat.data.teacher.email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulari de pujada de video -->
        <h3 class="mt-5">La teva entrega:</h3>

        <!-- Nom del video -->
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label h4">Títol del video:</label>
        <input type="text" class="form-control" v-model="cursForm.name">
      </div>


    </div>
    <div v-else class="d-flex justify-content-center container mt-4 px-4">
        <strong>Carregant activitat...</strong>
        <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
    </div>


    <FooterFrontoffice></FooterFrontoffice>
</template>
    
<script>
import HeaderFrontoffice from '@/components/FO/HeaderFrontoffice.vue';
import FooterFrontoffice from '@/components/FO/FooterFrontoffice.vue';

import activityServce from '@/services/Resources';
import userService from '@/services/User';

export default {
    components: {
        HeaderFrontoffice,
        FooterFrontoffice
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
            activitat: {
                error: false,
                data: null
            },
            videoForm: {
                name: null,
                description: null,
                
            }
        }
    },
    async beforeMount() {
        let that = this;
        await activityServce.getActivity(this.id)
            .then(r => {
                that.activitat.data = r.data
            })
            .catch(e => {
                that.activitat.error = e
            })
    },

}
</script>
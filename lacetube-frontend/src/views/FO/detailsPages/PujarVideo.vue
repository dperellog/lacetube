<template>
    <HeaderFrontoffice></HeaderFrontoffice>
    <div class="main-content-section">
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
                        <div class="card p-2">
                            <div class="d-flex align-items-center">
                                <Avatar :url="userService.getAvatarURLByAvatar(activitat.data.teacher.avatar)" :size="'sm'"></Avatar>
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
            <form class="mt-5" enctype="multipart/form-data">
                <h3 class="fw-bold">La teva entrega:</h3>
                <!-- Nom del video -->
                <div class="my-3">
                    <label for="exampleInputEmail1" class="form-label h4">Títol del video:</label>
                    <input type="text" class="form-control" v-model="videoForm.title">
                </div>

                <!-- Descripcio -->
                <div class="row">
                    <div :class="[modificar ? 'col-sm-12' : 'col-sm-8']">
                        <label for="exampleInputPassword1" class="form-label">Descripció del video:</label>
                        <textarea class="form-control" rows="9" v-model="videoForm.description"></textarea>
                    </div>

                    <!-- Caixa -->
                    <div class="col-sm-4" v-if="!modificar">
                        <label for="exampleInputPassword1" class="form-label">Arxiu de video:</label>
                        <div class="dropbox rounded-4">
                            <input type="file" @change="filesChange()" accept="video/*" ref="videoInput" class="input-file">
                            <p v-if="!this.videoForm.video"><i class="fa-solid fa-file-arrow-up text-grey"></i></p>
                            <p v-else><i class="fa-solid fa-file-circle-check text-success"></i></p>

                        </div>
                    </div>
                </div>
                <button v-if="!modificar" type="submit" class="btn btn-outline-warning mt-3"
                    :disabled="!formCorrecte" @click.prevent="pujarvideo">Entregar</button>
                <button v-else type="submit" class="btn btn-outline-warning mt-3"
                    :disabled="!formCorrecte" @click.prevent="modificarvideo">Modificar</button>
                <router-link v-if="modificar" :to="{path: '/video/'+videoID}" class="btn btn-outline-info mt-3 ms-3">Veure video</router-link>

                <div class="mt-2" v-if="videoFormStatus.loading">
                    <div class="spinner-border spinner-border-sm text-secondary me-1" role="status">
                        <span class="visually-hidden">Enviant dades...</span>
                    </div>
                    <span class="text-secondary">Pujant video... Això pot tardar uns minuts, no tanquis la pestanya del navegador!</span>
                </div>

                <div class="mt-2" v-if="videoFormStatus.error === true">
                    <div class="alert alert-dismissible alert-danger">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Hi ha hagut un error!</strong>
                        <p class="mb-0">{{ videoFormStatus.errorMsg }}</p>
                    </div>
                </div>
                <div class="mt-2" v-if="videoFormStatus.error === false">
                    <div class="alert alert-dismissible alert-success">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Acció completada: </strong>
                        <p v-if="!modificar" class="mb-0">S'ha entregat correctament! <router-link :to="{path: '/video/'+videoPujatId}">Veure el video</router-link></p>
                        <p v-else class="mb-0">S'ha modificat correctament!</p>
                    </div>
                </div>
            </form>

        </div>
        <div v-else class="d-flex justify-content-center container mt-4 px-4">
            <strong>Carregant activitat...</strong>
            <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
        </div>

    </div>

    <FooterFrontoffice></FooterFrontoffice>
</template>
    
<script>
import HeaderFrontoffice from '@/components/FO/HeaderFrontoffice.vue';
import FooterFrontoffice from '@/components/FO/FooterFrontoffice.vue';
import Avatar from '@/components/common/Avatar.vue';

import activityServce from '@/services/Resources';
import userService from '@/services/User';
import { useUserStore } from '@/stores/userStore';


export default {
    components: {
        HeaderFrontoffice,
        FooterFrontoffice,
        Avatar
    },
    props: {
        id: {
            type: String,
            required: true
        },
        videoID: String,
    },
    setup() {
        return {
            userService: userService,
            userStore: useUserStore()
        }
    },
    computed: {
        formCorrecte() {
            let correcte = true;

            if (this.modificar) {
                if (this.videoForm.title.length < 1) {
                    correcte = false;
                }
                if (this.videoForm.description.length < 1) {
                    correcte = false;
                }
            } else {
                Object.keys(this.videoForm).forEach(key => {
                    if (this.videoForm[key] == null) {
                        correcte = false;
                    }
                })
            }

            return correcte;
        },
    },
    data() {
        return {
            activitat: {
                error: false,
                data: null
            },
            videoForm: {
                title: null,
                description: '',
                video: null,
                user_id: null,
                activity_id: null
            },
            videoFormStatus: {
                error: null,
                errorMsg: '',
                loading: false,
                valid: false,
                currentStatus: null,
            },
            modificar: false,
            videoPujatId: 0
        }
    },
    async beforeMount() {

        if (this.videoID) {
            this.modificar = true;
        }

        if (this.modificar) {
            let video = null;
            //Obtenir video del backend.
            await activityServce.getVideo(this.videoID)
                .then(r => {
                    video = r.data
                    this.videoForm.title = video.title;
                    this.videoForm.description = video.description;

                    //Carregar l'activitat
                    this.activitat.data = video.activity;
                })
                .catch(e => {
                    console.log('e :>> ', e);
                    this.$router.push('/404');
                })
        } else {
            //Obtenir dades de l'activitat.
            await activityServce.getActivity(this.id)
                .then(r => {
                    this.activitat.data = r.data
                })
                .catch(e => {
                    console.log('e :>> ', e);
                    this.activitat.error = e
                })

            //Comprovar que l'usuari està autoritzat a penjar video:
            if (this.userStore.hasRole('student')) {
                if (!this.activitat.data.students.map(activitat => activitat.id).includes(this.userStore.currentUser.id)) {
                    this.$router.push('/tauler')
                }
            }
        }

        this.videoForm.activity_id = this.activitat.data.id;
        this.videoForm.user_id = this.userStore.currentUser.id;
    },
    methods: {
        filesChange() {
            this.videoForm.video = this.$refs.videoInput.files[0];
        },
        pujarvideo() {
            this.videoFormStatus.loading = true;
            this.videoFormStatus.error = null;
            this.videoFormStatus.errorMsg = '';
            let that = this;

            const formData = new FormData();
            Object.keys(this.videoForm).forEach(key => {
                formData.append(key, that.videoForm[key]);
            })

            activityServce.uploadVideo(formData)
                .then(r => {
                    this.videoPujatId = r.data.id;
                    that.videoFormStatus.error = false;
                })
                .catch(e => {
                    console.log('e :>> ', e);
                    that.videoFormStatus.error = true;
                    that.videoFormStatus.errorMsg = e.response.data.message;
                })
                .finally(() => {
                    //Update UI:
                    that.videoFormStatus.loading = false;
                })
        },
        modificarvideo() {
            this.videoFormStatus.loading = true;
            this.videoFormStatus.error = null;
            this.videoFormStatus.errorMsg = '';
            let that = this;

            activityServce.modifyVideo(this.videoID, this.videoForm)
                .then(r => {
                    that.videoFormStatus.error = false;
                })
                .catch(e => {
                    console.log('e :>> ', e);
                    that.videoFormStatus.error = true;
                    that.videoFormStatus.errorMsg = e.response.data.message;
                })
                .finally(() => {
                    //Update UI:
                    that.videoFormStatus.loading = false;
                })
        }
    }

}
</script>
<style scoped>
.dropbox {
    outline: 2px dashed grey;
    /* the dash box */
    outline-offset: -10px;
    background: #fff9f1;
    color: dimgray;
    padding: 10px 10px;
    min-height: 200px;
    /* minimum height */
    position: relative;
    cursor: pointer;
}

.input-file {
    opacity: 0;
    width: 100%;
    height: 200px;
    position: absolute;
    cursor: pointer;
}

.dropbox:hover {
    background: #ffeed4;
}

.dropbox p {
    font-size: 4em;
    text-align: center;
    padding: 50px 0;
}
</style>
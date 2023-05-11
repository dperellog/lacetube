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
        <form class="mt-5" @submit.prevent="pujarvideo" enctype="multipart/form-data">
            <h3 class="fw-bold">La teva entrega:</h3>
            <!-- Nom del video -->
            <div class="my-3">
                <label for="exampleInputEmail1" class="form-label h4">Títol del video:</label>
                <input type="text" class="form-control" v-model="videoForm.title">
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <label for="exampleInputPassword1" class="form-label">Descripció del video:</label>
                    <textarea class="form-control" rows="9" v-model="videoForm.description"></textarea>
                </div>
                <div class="col-sm-4">
                    <label for="exampleInputPassword1" class="form-label">Arxiu de video:</label>
                    <div class="dropbox">
                        <input type="file" @change="filesChange()" accept="video/*" ref="videoInput" class="input-file">

                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-outline-warning mt-3" :disabled="!formCorrecte">Entregar</button>

            <div class="mt-2" v-if="videoFormStatus.loading">
                <div class="spinner-border spinner-border-sm text-secondary me-1" role="status">
                    <span class="visually-hidden">Enviant dades...</span>
                </div>
                <span class="text-secondary">Enviant dades... </span>
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
                    <p class="mb-0">S'ha entregat correctament!</p>
                </div>
            </div>
        </form>

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
import { useUserStore } from '@/stores/userStore';


export default {
    components: {
        HeaderFrontoffice,
        FooterFrontoffice
    },
    props: {
        id: String,
        required: true
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

            Object.keys(this.videoForm).forEach(key => {
                if (this.videoForm[key] == null) {
                    correcte = false;
                }
            })

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
            }
        }
    },
    async beforeMount() {
        let that = this;

        //Obtenir dades de l'activitat.
        await activityServce.getActivity(this.id)
            .then(r => {
                that.activitat.data = r.data
            })
            .catch(e => {
                that.activitat.error = e
            })

        //Comprovar que l'usuari està autoritzat a penjar video:
        if (this.userStore.hasRole('student')) {
            if (!this.activitat.data.students.map(activitat => activitat.id).includes(this.userStore.currentUser.id)) {
                this.$router.push('/tauler')
            }
        }

        this.videoForm.activity_id = this.activitat.data.id;
        this.videoForm.user_id = this.userStore.currentUser.id;
    },
    methods: {
        filesChange() {
            console.log('object :>> ', this.$refs.videoInput);
            this.videoForm.video = this.$refs.videoInput.files[0];
        },
        pujarvideo() {
            this.videoFormStatus.loading = true;
            this.videoFormStatus.error = null;
            this.videoFormStatus.errorMsg = '';
            let that = this;

            const formData = new FormData();
            Object.keys(this.videoForm).forEach(key => {
                console.log('key :>> ', that.videoForm);
                formData.append(key, that.videoForm[key]);
            })
            console.log('formData :>> ', formData);

            activityServce.uploadVideo(formData)
                .then(r => {
                    console.log('r :>> ', r);
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
<!-- App.vue -->
...

<!-- SASS styling -->
<style>
.dropbox {
    outline: 2px dashed grey;
    /* the dash box */
    outline-offset: -10px;
    background: lightcyan;
    color: dimgray;
    padding: 10px 10px;
    min-height: 200px;
    /* minimum height */
    position: relative;
    cursor: pointer;
}

.input-file {
    opacity: 0;
    /* invisible but it's there! */
    width: 100%;
    height: 200px;
    position: absolute;
    cursor: pointer;
}

.dropbox:hover {
    background: lightblue;
    /* when mouse over to the drop zone, change color */
}

.dropbox p {
    font-size: 1.2em;
    text-align: center;
    padding: 50px 0;
}</style>
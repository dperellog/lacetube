<template>
    <div class="comentari mt-2">
        <!-- Capçalera formulari -->
        <div class="row py-2">
            <div class="col-auto">
                <avatar :url="userService.getAvatarURLByAvatar(userStore.currentUser.avatar)" :size="'sm'"></avatar>
            </div>
            <div class="col-auto" style="font-size: 1rem;">
                <Puntuar :maxRating="5" :currentRating="comentariForm.stars" @puntuacio="actualitzarPuntuacio"
                    :key="comentariForm.stars"></Puntuar>
            </div>
        </div>

        <!-- Comentari: -->
        <div class="missatgeBox">
            <textarea class="form-control" placeholder="Escriu aqui el teu comentari" v-model="comentariForm.description"
                @input="autoEscalar($event.target)" :style="{ height: `${textareaAltura}px` }"></textarea>
        </div>

        <!-- Botó d'enviar -->
        <div class="d-flex justify-content-between flex-row-reverse mt-4">
            <button class="btn btn-warning" :disabled="!formCorrecte" @click="enviarComentari">Enviar</button>

            <!-- Mostrar carregant comentari -->
            <div class="mt-2 ms-4" v-if="formStatus.loading">
                <div class="spinner-border spinner-border-sm text-secondary me-1" role="status">
                    <span class="visually-hidden">Enviant comentari...</span>
                </div>
                <span class="text-secondary">Enviant comentari... </span>
            </div>
        </div>

        <!-- Confirmació de creació -->
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
                <p class="mb-0" v-if="!modificar">S'ha enviat el comentari exitosament!</p>
            </div>
        </div>
    </div>
</template>
<script>
import Puntuar from '@/components/common/Puntuar.vue'
import Avatar from '@/components/common/Avatar.vue'

import userService from '@/services/User';
import { useUserStore } from '@/stores/userStore';
import Resources from '@/services/Resources';

export default {
    components: {
        Puntuar,
        Avatar
    },
    emits: ['nouComentari'],
    props: {
        videoID: {
            type: Number,
            required: true
        }
    },
    setup() {
        let userStore = useUserStore();

        return {
            userStore: userStore,
            userService: userService
        }
    },
    data() {
        return {
            comentariForm: {
                stars: 0,
                description: "",
                video_id: null,
                user_id: null
            },
            formStatus: {
                loading: false,
                error: null
            },
            textareaAltura: "auto"
        }
    },
    beforeMount() {
        this.comentariForm.video_id = this.videoID;
        this.comentariForm.user_id = this.userStore.currentUser.id;
    },
    methods: {
        actualitzarPuntuacio(novaPuntuacio) {
            this.comentariForm.stars = novaPuntuacio
        },
        autoEscalar(textarea) {
            textarea.style.height = "auto";
            textarea.style.height = `${textarea.scrollHeight}px`;
            this.textareaAltura = `${textarea.scrollHeight}px`;
        },
        enviarComentari() {
            //Reset defaults:
            this.formStatus.loading = true;
            this.formStatus.error = null;
            this.formStatus.errorMsg = '';
            let that = this;

            Resources.sendComment(this.comentariForm)
                .then(r => {
                    console.log('r :>> ', r)
                    that.formStatus.error = false;
                    this.$emit('nouComentari', r.data)

                    //Resetejar formulari
                    this.comentariForm.stars = 0;
                    this.comentariForm.description = '';
                })
                .catch(e => {
                    console.log('e :>> ', e)
                    that.formStatus.error = true;
                    that.formStatus.errorMsg = e.response.data.message;
                })
                .finally(() => {
                    //Update UI:
                    that.formStatus.loading = false;
                })
        }
    },
    computed: {
        formCorrecte() {
            return this.comentariForm.stars != 0;
        }
    }
}
</script>
<style scoped>
.missatgeBox {
    position: relative;
    background-color: #F9F7F3;
    border: 1px solid #ffffff;
    padding: 0.7rem;
    margin-left: 3rem;
    border-radius: 5px;
    font-size: 16px;
    line-height: 1.5;
}

.missatgeBox::before {
    content: "";
    position: absolute;
    left: -0.5rem;
    margin-top: -1.5rem;
    border-width: 0 11px 27px 11px;
    border-style: solid;
    transform: rotate(313deg);
    border-bottom-left-radius: 150px;
    /* ajusta el valor de radius para redondear la punta del triángulo */
    border-top-right-radius: 200px;
    border-color: transparent transparent #ffffff transparent;
}

.comentari {
    background-color: #EAEAEA;
    border-color: #EAEAEA;
    box-shadow: 0px 3px 6px #00000026;
    border-radius: 1rem;

    padding: 0.5rem 1rem;
}

.missatgeBox textarea {
    min-height: 4rem;
}
</style>
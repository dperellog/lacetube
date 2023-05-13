<template>
    <section>

        <!-- Llistat de tasques -->
        <div v-if="videos != null">
            <div class="row gy-3" v-if="videos.length > 0">
                <router-link v-for="video in limitarArray(videos)" :to="{ path: '/video/' + video.id }"
                    class="text-decoration-none col-sm-4 col-lg-3">
                    <Video :video="video"></Video>
                </router-link>

                <!-- Botó mostrar més -->
                <a href="#" class="showMore text-center" v-if="limit != -1" @click.prevent="mostrarMes">Mostra'n més</a>
            </div>

            <div v-else class="alert alert-info" role="alert">
                No hi han videos disponibles!
            </div>
        </div>

        <!-- Mostrar abans d'obtenir del backend: -->
        <div v-else>
            <div v-if="error" class="alert alert-danger" role="alert">
                ERROR: {{ error }}
            </div>
            <div v-else class="d-flex justify-content-center">
                <strong>Carregant videos...</strong>
                <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
            </div>
        </div>
    </section>
</template>

<script>

import UserService from '@/services/User';
import Video from '@/components/FO/tauler/components/Video.vue';


export default {
    components: {
        Video
    },
    props: {
        mostrarTots: Boolean,
        force: {
            type: Boolean,
            default: false
        },
        inputVideos: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            videos: null,
            error: null,
            limit: 4
        }
    },
    async beforeMount() {

        if (this.inputVideos) {
            this.videos = this.inputVideos
        } else {
            //Obtenir videos del backend
            this.videos = await this.getVideos();            
        }

        if (this.mostrarTots) {
                this.limit = -1
            }

    },
    methods: {
        async getVideos() {
            return UserService.getVideos(this.force)
                .then(r => {
                    console.log('r :>> ', r);
                    return r;
                })
                .catch(e => {
                    this.error = e;
                });
        },

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
            this.limit += 4;
            if (this.limit >= this.videos.length) {
                this.limit = -1;
            }
        }
    }
}
</script>
<style scoped>
a.showMore {
    color: #6399BB;
    text-decoration: none;
    font-weight: bold;
}

a.showMore:hover {
    color: #77b6dc;
    text-decoration: none;
}
</style>
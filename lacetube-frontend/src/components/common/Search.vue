<template>
    <form>
        <div class="input-group border-light">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">{{ currentType.name }}</button>
            <ul class="dropdown-menu">
                <li v-for="tipus in getTypes()"><a class="dropdown-item" href="#" @click.prevent="changeType(tipus)">{{
                    tipus.name }}</a></li>
            </ul>
            <input type="search" class="form-control" aria-label="Cercar..." v-model="searchText">
            <button class="btn btn-outline-secondary" type="button"><i
                    class="fa-sharp fa-solid fa-magnifying-glass"></i></button>
        </div>
        <div v-if="resultatsFiltrats.data.length > 0 || resultatsFiltrats.noHiHanResultats == true" class="resultats">
            <div class="card">
                <table class="card-table table">
                    <tbody>
                        <tr v-for="resultat in resultatsFiltrats.data">
                            <!-- Mostrar resultats de video -->
                            <td v-if="currentType.type == 'video'">
                                <router-link :to="{ path: '/video/' + resultat.id }" class="text-decoration-none">
                                    <Video :video="resultat" :estil="'llista'"></Video>
                                </router-link>
                            </td>

                            <!-- Mostrar resultats d'usuari -->
                            <td v-if="currentType.type == 'user'">
                                <router-link :to="{ path: '/usuari/' + resultat.id }"
                                    class="d-flex align-items-center text-decoration-none">
                                    <img :src="userService.getAvatarURLByAvatar(resultat.avatar)" alt="foto-usuari"
                                        style="width: 45px; height: 45px" class="rounded-circle">
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1">{{ resultat.name }}</p>
                                        <p class="text-muted mb-0">{{ resultat.email }}</p>
                                    </div>
                                </router-link>
                            </td>

                            <!-- Mostrar resultats de cursos -->
                            <td v-if="currentType.type == 'course'">
                                <router-link :to="{ path: '/curs/' + resultat.id }" class="text-decoration-none">
                                    <Curs :curs="resultat" :estil="'llista'"></Curs>
                                </router-link>
                            </td>
                        </tr>
                        <tr v-if="resultatsFiltrats.noHiHanResultats">
                            <td class="fw-bold text-secondary"><i class="fa-solid fa-circle-xmark"></i>&nbsp;&nbsp;No s'han trobat resultats per aquesta cerca!</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</template>
<script>
import Video from '@/components/FO/components/Video.vue'
import Curs from '@/components/FO/components/Curs.vue'

import Resources from '@/services/Resources'
import userService from '@/services/User'

export default {
    components: {
        Video,
        Curs
    },
    setup() {
        return {
            userService : userService
        }
    },
    props: {
        userAuthenticated: {
            type: Boolean
        }
    },
    beforeMount(){
        if (this.userAuthenticated) {
            this.types = [
                { type: 'video', name: 'Video' },
                { type: 'user', name: 'Usuari' },
                { type: 'course', name: 'Curs' }
            ];
        }
    },
    data() {
        return {
            currentType: { type: 'video', name: 'Video' },
            types: [
                { type: 'video', name: 'Video' },
            ],
            searchText: '',
            resultatsBackend: [],
            resultatsFiltrats: {
                noHiHanResultats: null,
                data: []
            },
            canviType: false
        }
    },
    methods: {
        changeType(type) {
            this.currentType = type

            //Refrescar resultats
            if (this.searchText.length > 2) {
                this.searchToBackend(this.searchText)
            }
        },
        getTypes() {
            return this.types.filter(type => type.type != this.currentType.type)
        },
        async searchToBackend(searchText) {
            Resources.searchBackend(searchText, this.currentType.type)
                .then(r => {
                    this.resultatsBackend = r.data

                    if (this.resultatsBackend.length == 0) {
                        this.resultatsFiltrats.noHiHanResultats = true;
                        this.resultatsFiltrats.data = [];
                    } else {
                        this.resultatsFiltrats.noHiHanResultats = false;
                    }
                    this.filtrarResultats(searchText)
                })
                .catch(e => console.log('e :>> ', e))
        },
        filtrarResultats(searchText) {
            searchText = searchText.toLowerCase();

            switch (this.currentType.type) {
                case 'video':
                    this.resultatsFiltrats.data = this.resultatsBackend.filter(video => video.title.toLowerCase().includes(searchText));
                    break;

                case 'user':
                    this.resultatsFiltrats.data = this.resultatsBackend.filter(usuari => usuari.name.toLowerCase().includes(searchText));
                    break;

                case 'course':
                    this.resultatsFiltrats.data = this.resultatsBackend.filter(curs => curs.name.toLowerCase().includes(searchText));
                    break;
            }
        }
    },
    watch: {
        searchText(searchText, oldtext) {

            //Si la longitut es 2, buscar al backend:
            if (searchText.length == 2 && oldtext.length < 2 ) {
                this.searchToBackend(this.searchText)
            }

            //Si la longitut és 0, borrar els resultats.
            if (searchText.length == 0) {
                this.resultatsFiltrats.data = [];
                this.resultatsFiltrats.noHiHanResultats = false;
                this.resultatsBackend = [];
            }

            this.filtrarResultats(searchText)
        },
        currentType(oldType, newType){
            if (oldType != newType) {
                this.searchToBackend(this.searchText)
            }
        }
    }
}
</script>
<style scoped>
.btn,
input {
    border-color: rgb(215, 215, 215);
}

.resultats {
    position: absolute;
    width: 100%;
    z-index: 100;
}

form {
    position: relative;
}

.table {
    margin-bottom: 0px !important;
}
</style>
<template>
    <section>
        <!-- Llistat de tasques -->
        <div v-if="cursos != null">
            <div class="row gy-3" v-if="cursos.length > 0">
                <router-link v-if="!emitCourse" v-for="curs in limitarArray(cursos)" class="text-decoration-none col-sm-4 col-lg-3" :to="{ path: '/curs/'+curs.id}">
                    <Curs class="cursPreview " :curs="curs"></Curs>
                </router-link>

                <a href="#" v-else v-for="curs in limitarArray(cursos)" class="text-decoration-none col-sm-4 col-lg-3" @click.prevent="$emit('cursSeleccionat', curs)">
                    <Curs class="cursPreview " :curs="curs"></Curs>
                </a>

                <!-- Botó mostrar més -->
                <a href="#" class="showMore text-center" v-if="limit != -1 && cursos.length > limit" @click.prevent="mostrarMes">Mostra'n més</a>
            </div>

            <div v-else class="alert alert-info" role="alert">
                No hi han cursos disponibles!
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
    </section>
</template>

<script>

import UserService from '@/services/User';
import Curs from '@/components/FO/components/Curs.vue';


export default {
    components: {
        Curs
    },
    props: {
        mostrarTots : Boolean,
        emitCourse: Boolean,
        force: {
            type: Boolean,
            default: false
        },
        inputCursos: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            cursos: null,
            error: null,
            limit: 4
        }
    },
    async beforeMount() {
        if (this.inputCursos) {
            this.cursos = this.inputCursos
        } else {
            //Obtenir videos del backend
            this.cursos = await this.getCursos();
        }
        

        if (this.mostrarTots) {
            this.limit = -1
        }
    },
    methods: {
        async getCursos() {
            return UserService.getCourses(this.force)
                .then(r => {
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
            if (this.limit >= this.cursos.length) {
                this.limit = -1;
            }
        }
    }
}
</script>
<style scoped>

</style>
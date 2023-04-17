<template>
    <section>

        <!-- Capçalera i botons de filtre -->
        <div class="row">
            <p class="h2 mb-3 col-8">Els meus videos:</p>
        </div>

        <!-- Llistat de tasques -->
        <div v-if="cursos != null">
            <div class="row gy-3" v-if="cursos.length > 0">
                <!-- <Tasca class="col-12" v-for="activitat in limitarArray(tasquesFiltrades)" :activitat="activitat" :disseny="'carta'"></Tasca> -->
                <Curs class="col-sm-4 col-lg-3" v-for="curs in limitarArray(cursos)" :curs="curs"></Curs>
                <!-- Botó mostrar més -->
                <a href="#" class="showMore text-center" v-if="limit != -1" @click.prevent="mostrarMes">Mostra'n més</a>
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
import Curs from '@/components/tauler/components/Curs.vue'


export default {
    components: {
        Curs
    },
    data() {
        return {
            cursos: null,
            error: null,
            limit: 4
        }
    },
    async beforeMount() {
        //Obtenir tasques del backend
        this.cursos = await this.getCursos();
    },
    methods: {
        async getCursos() {
            return UserService.getCourses()
                .then(r => {
                    return r.data.data;
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
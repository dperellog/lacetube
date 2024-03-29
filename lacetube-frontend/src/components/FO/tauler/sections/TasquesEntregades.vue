<template>
    <section>

        <!-- Capçalera i botons de filtre -->
        <div class="row">
            <p class="h2 mb-3 col-8">Tasques entregades:</p>
            <div class="col-4 d-flex justify-content-end">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Històric {{ ordre }} dies
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" @click.prevent="ordenarTasques(7)">Històric 7 dies</a></li>
                        <li><a class="dropdown-item" href="#" @click.prevent="ordenarTasques(14)">Històric 14 dies</a></li>
                        <li><a class="dropdown-item" href="#" @click.prevent="ordenarTasques(21)">Històric 21 dies</a></li>
                        <li><a class="dropdown-item" href="#" @click.prevent="ordenarTasques(31)">Històric 31 dies</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Llistat de tasques -->
        <div v-if="tasques != null">
            <div class="row gy-3" v-if="tasquesFiltrades.length > 0">
                <Tasca class="col-12" v-for="activitat in limitarArray(tasquesFiltrades)" :activitat="activitat"
                    :disseny="'carta'"></Tasca>

                <!-- Botó mostrar més -->
                <a href="#" class="showMore text-center" v-if="limit != -1 && tasquesFiltrades.length > limit"
                    @click.prevent="mostrarMes">Mostra'n més</a>
            </div>

            <div v-else class="alert alert-info" role="alert">
                No hi han tasques disponibles!
            </div>
        </div>

        <!-- Mostrar abans d'obtenir del backend: -->
        <div v-else>
            <div v-if="error" class="alert alert-danger" role="alert">
                ERROR: {{ error }}
            </div>
            <div v-else class="d-flex justify-content-center">
                <strong>Carregant tasques...</strong>
                <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
            </div>
        </div>
    </section>
</template>

<script>

import UserService from '@/services/User';
import moment from 'moment';
import Tasca from '@/components/FO/components/Tasca.vue';


export default {
    components: {
        Tasca
    },
    data() {
        return {
            tasques: null,
            tasquesFiltrades: null,
            error: null,
            ordre: 7,
            limit: 2,
        }
    },
    async beforeMount() {
        //Obtenir tasques del backend
        this.tasques = await this.getTasques();
        this.tasquesFiltrades = this.tasques;

        //Ordenar tasques
        this.ordenarTasques();
    },
    methods: {
        async getTasques() {
            return UserService.getActivities()
                .then(r => {
                    return r;
                })
                .catch(e => {
                    this.error = e;
                    console.log('e :>> ', e);
                });
        },
        ordenarTasques(dies = 7) {
            this.ordre = dies;
            this.limit = 2;

            const limitInferior = moment().subtract(this.ordre, 'days');
            const limitSuperior = moment().subtract(1, 'days');

            //Filtrar tasques:
            this.tasquesFiltrades = this.tasques.filter(tasca => {
                let filtrar = false;

                if (tasca.entregada) {
                    if (moment(tasca.end_date).isBetween(limitInferior, limitSuperior, null, '[]')) {
                        filtrar = true;
                    }

                    if (moment(tasca.end_date).diff(limitSuperior) >= 0 ) {
                        filtrar = true;
                    }
                }

                return filtrar
            });

            //Ordenar per dies.
            this.tasquesFiltrades = this.tasquesFiltrades.sort((a, b) => moment(b.end_date).diff(moment(a.end_date)));

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
            this.limit += 3;
            if (this.limit >= this.tasquesFiltrades.length) {
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
}</style>
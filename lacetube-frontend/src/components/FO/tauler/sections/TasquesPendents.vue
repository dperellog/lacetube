<template>
    <section>

        <!-- Capçalera i botons de filtre -->
        <div class="row">
            <p class="h2 mb-3 col-8">Tasques pendents:</p>
            <div class="col-4 d-flex justify-content-end">
                <div :class="['btn', 'me-2', mostrarVencudes ? 'btn-light' : 'btn-secondary']" @click="mostrarTasquesVencudes" :title="mostrarVencudes ? 'Amagar tasques vencudes' : 'Mostrar tasques vençudes'" style="height: 2.4rem;">
                    <i v-if="!mostrarVencudes" class="fa-solid fa-calendar-xmark"></i>
                    <i v-else class="fa-solid fa-calendar-check"></i>
                </div>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Proxims {{ ordre }} dies
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" @click.prevent="ordenarTasques(7)">Proxims 7 dies</a></li>
                        <li><a class="dropdown-item" href="#" @click.prevent="ordenarTasques(14)">Proxims 14 dies</a></li>
                        <li><a class="dropdown-item" href="#" @click.prevent="ordenarTasques(21)">Proxims 21 dies</a></li>
                        <li><a class="dropdown-item" href="#" @click.prevent="ordenarTasques(31)">Proxims 31 dies</a></li>
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
            mostrarVencudes: false
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

            const limitInferior = moment().subtract(1, 'days');
            const limitSuperior = moment().add(this.ordre, 'days');
            let mostrarVencudes = this.mostrarVencudes;

            //Filtrar tasques:
            this.tasquesFiltrades = this.tasques.filter(tasca => {
                let filtrar = false;
                
                //Si la tasca es troba dins del filtre de dies:
                if (moment(tasca.end_date).isBetween(limitInferior, limitSuperior, null, '[]')) {
                    if (tasca.entregada) {
                        filtrar = false;
                    }else{
                        filtrar = true;
                    }
                }

                if (mostrarVencudes ? tasca.entregada == false : false) {
                    filtrar = true;
                }

                return filtrar
            });

            //Ordenar per dies.
            this.tasquesFiltrades = this.tasquesFiltrades.sort((a, b) => moment(b.end_date).diff(moment(a.end_date))).reverse();

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
        },
        mostrarTasquesVencudes() {
            this.mostrarVencudes = !this.mostrarVencudes;
            this.ordenarTasques();
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
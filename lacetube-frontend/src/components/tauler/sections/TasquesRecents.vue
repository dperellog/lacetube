<template>
    <section>
        <div class="row">
            <p class="h2 mb-3 col-9">Tasques pendents:</p>
            <div class="col-3">
                <button @click="ordenarTasques" class="btn btn-sm btn-outline-info">Ordre</button>
            </div>
            
        </div>
        

        <div v-if="tasques != null">
            <div class="row gy-3" v-if="tasques.length > 0">
                <Tasca class="col-12" v-for="activitat in tasques" :activitat="activitat"></Tasca>
            </div>
            <div v-else class="alert alert-info" role="alert">
                No hi han tasques disponibles!
            </div>
        </div>
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

import Tasca from '@/components/tauler/components/Tasca.vue'


export default {
    components: {
        Tasca
    },
    async beforeMount() {
        this.tasques = await this.getTasques();
    },
    data() {
        return {
            tasques: null,
            error: null,
            ordre: '+7'
        }
    },
    methods: {
        async getTasques() {
            return UserService.getActivities()
                .then(r => {
                    return r.data;
                })
                .catch(e => {
                    this.error = e;
            });
        },
        ordenarTasques() {
            const today = moment();
            const nextWeek = moment().add(7, 'days');
            
            this.tasques.sort((a, b) => moment(b.end_date).diff(moment(a.end_date)));

            this.tasques.filter(task => moment(task.end_date).isBetween(today, nextWeek, null, '[]'));
        }
    }
}
</script>
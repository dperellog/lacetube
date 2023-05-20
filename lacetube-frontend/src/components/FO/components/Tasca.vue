<template>
    <div>
        <div class="card">
            <div class="row px-4 py-2">
                <div class="card-body col-sm-10">
                    <header class="">
                        <h3 class="h4 fw-bold">{{ activitat.name }}</h3>
                        <router-link :to="{ path: '/curs/' + activitat.course.id }"
                            class="h6 text-secondary text-decoration-none" v-if="disseny == 'carta'"><i
                                class="fa-solid fa-graduation-cap"></i>&nbsp;&nbsp;<span>{{
                                    activitat.course.name }}</span></router-link>
                        <h6 class="text-secondary" :class="[vencuda ? 'text-danger' : '']"><i
                                class="fa-solid fa-calendar-check"></i>&nbsp;&nbsp;<span>Venciment: {{
                                    dataFinal }}</span></h6>
                        <hr>
                    </header>
                    <p>{{ activitat.description }}</p>
                </div>
                <div v-if="!activitat.entregada" class="col-sm-2 col-md-1 mt-sm-4 d-grid gap-2 mb-auto">
                    <router-link :to="{ path: '/activitat/penjar/' + activitat.id }" class="btn btn-warning d-block"
                        style="min-height: 3rem; font-size: 1.4rem;"><i
                            class="fa-sharp fa-solid fa-upload"></i></router-link>
                    <div v-if="vencuda" class="btn btn-danger">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>

                </div>
                <div v-else class="col-1 mt-4 d-grid gap-2 mb-auto">
                    <router-link :to="{ path: '/video/' + activitat.entregada.id }" class="btn btn-success d-block"
                        style="min-height: 3rem; font-size: 1.4rem;"><i class="fa-solid fa-check-to-slot"></i></router-link>
                    <router-link :to="{ path: '/activitat/modificar/' + activitat.entregada.id }" class="btn btn-info d-block"
                        style="min-height: 3rem; font-size: 1.4rem;"><i class="fa-solid fa-pencil"></i></router-link>
                </div>
            </div>
        </div>
    </div>
</template>
    
<script>
import moment from 'moment';
import { useUserStore } from '@/stores/userStore';

export default {
    props: {
        activitat: {
            type: Object
        },
        disseny: {
            type: String
        },
    },
    setup() {
        const userStore = useUserStore();

        return {
            userStore: userStore
        }
        
    },
    beforeMount(){
        this.estudiant = this.userStore.hasRole('student')
    },
    data() {
        return {
            estudiant: true
        }
    },
    computed: {
        dataFinal() {
            return moment(this.activitat.end_date, 'YYYY-MM-DD').format('LL')
        },
        vencuda() {
            if (!this.estudiant) {
                return false;
            }
            let avui = moment().subtract(1, 'day');
            let dataEntrega = this.activitat.end_date;

            if (avui.diff(dataEntrega) > 0 && !this.activitat.entregada) {
                return true;
            } else {
                return false;
            }
        }
    }
}
</script>

<style scoped>
.card {
    background-color: #F9F7F3;
    border-color: #F9F7F3;
    border-radius: 42px;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}
</style>
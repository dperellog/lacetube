<template>
    <div v-if="disseny == 'carta'">
        <div class="card">
            <div class="row ps-4">
                <div class="card-body col-11">
                    <header class="">
                        <h3 class="h4 fw-bold">{{ activitat.name }}</h3>
                        <h6 class="text-secondary"><i class="fa-solid fa-user-graduate"></i>&nbsp;&nbsp;<span>{{
                            activitat.course_name }}</span></h6>
                        <h6 class="text-secondary"><i class="fa-solid fa-calendar-check"></i>&nbsp;&nbsp;<span>Venciment: {{
                            dataFinal }}</span></h6>
                        <hr>
                    </header>
                    <p>{{ activitat.description }}</p>
                </div>
                <div class="col-1">Butt</div>
            </div>
        </div>
    </div>
</template>
    
<script>
import moment from 'moment';

export default {
    props: {
        activitat: {
            type: Object
        },
        disseny: {
            type: String
        }
    },
    data() {
        return {

        }
    },
    computed: {
        dataFinal() {
            return moment(this.activitat.end_date, 'YYYY-MM-DD').format('LL')
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
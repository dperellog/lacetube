<template>
    <div class="cursPreview">
        <div class="image">
            <img src="" alt="" srcset="">

        </div>
        <h5>{{ curs.name }}</h5>
        
    </div>
</template>
    
<script>

export default {
    props: {
        curs: {
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
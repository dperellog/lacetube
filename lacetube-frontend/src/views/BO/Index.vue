<template>
    <HeaderBackoffice></HeaderBackoffice>
    <h1>Benvinguts al Backoffice!</h1>
</template>
<style>
/* body {
    background-color: #e4e4e4 !important;
} */
</style>
<script>
import HeaderBackoffice from '../../components/headers/HeaderBackoffice.vue';
import { useCounterStore } from '@/stores/counter';

export default {
    setup() {
        return {store : useCounterStore()};
    },
    components: {
        HeaderBackoffice
    }
}
</script>
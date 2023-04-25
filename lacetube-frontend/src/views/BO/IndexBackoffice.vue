<template>
    <HeaderBackoffice></HeaderBackoffice>
    <div class="container mt-4 px-4">
        <h1 class="fw-bold">Panell de gestió:</h1>
        <hr>

    </div>
    <FooterBackoffice></FooterBackoffice>
</template>
<style>
/* body {
    background-color: #e4e4e4 !important;
} */
</style>
<script>
import HeaderBackoffice from '@/components/BO/headers/HeaderBackoffice.vue';
import FooterBackoffice from '@/components/BO/FooterBackoffice.vue';
import { useCounterStore } from '@/stores/counter';

export default {
    components: {
        HeaderBackoffice,
        FooterBackoffice
    },
    setup() {
        return { store: useCounterStore() };
    },
    
}
</script>
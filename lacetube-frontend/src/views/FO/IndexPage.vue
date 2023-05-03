<template>
    <HeaderFrontoffice></HeaderFrontoffice>
    <h2>{{ store.count }}</h2>
    <!-- <font-awesome-icon icon="fa-solid fa-user-secret" /> -->
    <FooterFrontoffice></FooterFrontoffice>
</template>
<script>
import HeaderFrontoffice from '../../components/FO/HeaderFrontoffice.vue';
import FooterFrontoffice from '../../components/FO/FooterFrontoffice.vue';
import { useCounterStore } from '@/stores/counter';

export default {
    components: {
        HeaderFrontoffice,
        FooterFrontoffice
    },
    setup() {
        return {store : useCounterStore()};
    },
}
</script>
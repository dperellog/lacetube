<template>
    <Header></Header>
    <h2>{{ store.count }}</h2>
    <!-- <font-awesome-icon icon="fa-solid fa-user-secret" /> -->
    <Footer></Footer>
</template>
<script>
import Header from '@/components/FO/Header.vue';
import Footer from '@/components/FO/Footer.vue';
import { useCounterStore } from '@/stores/counter';

export default {
    setup() {
        return {store : useCounterStore()};
    },
    components: {
        Header,
        Footer
    }
}
</script>
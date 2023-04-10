<template>
    <Header></Header>
    <h2>{{ store.count }}</h2>
    <!-- <font-awesome-icon icon="fa-solid fa-user-secret" /> -->
</template>
<script>
import Header from '../../components/Header.vue';
import { useCounterStore } from '@/stores/counter';

export default {
    setup() {
        return {store : useCounterStore()};
    },
    components: {
        Header
    }
}
</script>
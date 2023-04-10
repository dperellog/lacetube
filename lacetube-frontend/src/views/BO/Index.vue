<template>
    <h1>Benvinguts al Backoffice!</h1>
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
<template>
    <HeaderBackoffice></HeaderBackoffice>
    <div class="main-content-section container mt-4 px-4">
        <h1 class="fw-bold">Panell de gestió:</h1>
        <hr>
        <Bar :data="data" :options="options" />

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

import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js'
import { Bar } from 'vue-chartjs'

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)

export default {
    components: {
        HeaderBackoffice,
        FooterBackoffice,
        Bar
    },
    setup() {
        return { store: useCounterStore() };
    },
    data() {
    return {
      data: {
        labels: ['January', 'February', 'March'],
        datasets: [{ data: [40, 20, 12] }]
      },
      options: {
        responsive: true
      }
    }
  }

}
</script>
<template>
  <HeaderBackoffice></HeaderBackoffice>
  <div class="main-content-section container mt-4 px-4">
    <h1 class="fw-bold">Panell de gestió:</h1>
    <hr>
    <Doughnut :data="pieChart.data"></Doughnut>
    <Bar :data="barchart.data" :options="barchart.options" />
    

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
import { Bar, Doughnut } from 'vue-chartjs'
import Resources from '@/services/Resources';

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)
ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)

export default {
  components: {
    HeaderBackoffice,
    FooterBackoffice,
    Bar,
    Doughnut
  },
  setup() {
    return { store: useCounterStore() };
  },
  beforeMount() {
    this.getStatistics()
  },
  data() {
    return {
      pieChart: {
        data: {
          labels: ['Administradors', 'Professors', 'Alumnes'],
          datasets: [{
            label: 'Tipus d\'usuaris',
            data: [300, 50, 100],
            backgroundColor: [
              'rgb(255, 99, 132)',
              'rgb(54, 162, 235)',
              'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
          }]
        },
        options: {
          responsive: true
        }
      },
      barchart: {
        data: {
          labels: ['Videos', 'Cursos', 'Activitats', 'Usuaris'],
          datasets: [{ data: [0, 0, 0, 0] }]
        },
        options: {
          indexAxis: 'y',
          responsive: true
        },
      },

      statistics: null
    }
  },
  methods: {
    getStatistics() {
      Resources.getStatistics()
        .then(r => console.log('r :>> ', r))
        .catch(e => console.log('e :>> ', e))
    }
  }

}
</script>
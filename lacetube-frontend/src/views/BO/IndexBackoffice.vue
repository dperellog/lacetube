<template>
  <HeaderBackoffice></HeaderBackoffice>
  <div class="main-content-section container mt-4 px-4">
    <h1 class="fw-bold">Panell de gestió:</h1>
    <hr>
    <h2 class="mb-4">Estadístiques rapides:</h2>
    <div v-if="estadistiques != null" class="row">
      <div class="col-sm-4">
        <Doughnut :data="pieChart.data"></Doughnut>
      </div>
      <div class="col-sm-8">
        <Bar :data="barchart.data" :options="barchart.options" />
      </div>
    </div>
    <div v-else class="d-flex justify-content-center">
      <strong>Carregant estadístiques...</strong>
      <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
    </div>
  </div>
  <FooterBackoffice></FooterBackoffice>
</template>
<script>
import HeaderBackoffice from '@/components/BO/headers/HeaderBackoffice.vue';
import FooterBackoffice from '@/components/BO/FooterBackoffice.vue';

import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  ArcElement,
} from 'chart.js'
import { Bar, Doughnut } from 'vue-chartjs'
import Resources from '@/services/Resources';

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)
ChartJS.register(ArcElement, Tooltip, Legend)


export default {
  components: {
    HeaderBackoffice,
    FooterBackoffice,
    Bar,
    Doughnut
  },
  beforeMount() {
    this.getStatistics()
  },
  data() {
    return {
      pieChart: {
        data: {
          labels: ['Alumnes', 'Professors', 'Administradors'],
          datasets: [{
            label: 'Tipus d\'usuaris',
            data: [0, 0, 0],
            backgroundColor: [
              'rgb(255, 205, 86)',
              'rgb(54, 162, 235)',
              'rgb(255, 99, 132)'
            ],
            hoverOffset: 4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true
        }
      },
      barchart: {
        data: {
          labels: ['Videos', 'Cursos', 'Activitats', 'Usuaris', 'Comentaris'],
          datasets: [{ 
            label: 'Total', 
            backgroundColor: [
              'rgb(255, 205, 86)',
              'rgb(54, 162, 235)',
              'rgb(255, 99, 132)',
              '#41B883',
              '#E46651'
            ],
            data: [0, 0, 0, 0, 0] 
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true
        },
      },
      estadistiques: null
    }
  },
  methods: {
    getStatistics() {
      Resources.getStatistics()
        .then(r => {
          this.estadistiques = r.data
        })
        .catch(e => console.log('e :>> ', e))
    }
  },
  watch: {
    estadistiques(estadistiques){
      if (estadistiques != null) {
        let donut = this.pieChart;
        let barra = this.barchart;

        //Carregar dades al gràfic donut:
        let admins= estadistiques.users - (estadistiques.students + estadistiques.teachers)
        donut.data.datasets[0].data = [estadistiques.students, estadistiques.teachers, admins]

        //Carregar dades al gràfic de barres
        barra.data.datasets[0].data = [estadistiques.videos, estadistiques.courses, estadistiques.activities, estadistiques.users, estadistiques.comments]
      }
    }
  }

}
</script>
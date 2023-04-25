<template>
  <Header></Header>
  <div class="container mt-4 px-4">
    <h1 class="fw-bold">Els meus cursos:</h1>
    <hr>
      <ElsMeusCursos class="my-5" mostrarTots></ElsMeusCursos>
    
  </div>
  <Footer></Footer>
</template>
  
<script>
import Header from '@/components/FO/Header.vue';
import Footer from '@/components/FO/Footer.vue';
import ElsMeusCursos from '@/components/FO/tauler/sections/ElsMeusCursos.vue';

export default {
  components: {
    Header,
    Footer,
    ElsMeusCursos
  },
  data() {
    return {
    }
  },
  methods: {
    
  }
}
</script>
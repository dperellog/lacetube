<template>
  <Header></Header>
  <div class="container mt-4 px-4">
    <h1 class="fw-bold">Els meus cursos:</h1>
    <hr>
      <ElsMeusCursos class="my-5" mostrarTots></ElsMeusCursos>
    
  </div>
</template>
  
<script>
import Header from '@/components/FO/Header.vue';
import ElsMeusCursos from '@/components/FO/tauler/sections/ElsMeusCursos.vue';

export default {
  components: {
    Header,
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
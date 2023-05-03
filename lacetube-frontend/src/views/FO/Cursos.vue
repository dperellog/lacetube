<template>
  <HeaderFrontoffice></HeaderFrontoffice>
  <div class="container mt-4 px-4">
    <h1 class="fw-bold">Els meus cursos:</h1>
    <hr>
      <ElsMeusCursos class="my-5" mostrarTots></ElsMeusCursos>
    
  </div>
  <FooterFrontoffice></FooterFrontoffice>
</template>
  
<script>
import HeaderFrontoffice from '@/components/FO/HeaderFrontoffice.vue';
import FooterFrontoffice from '@/components/FO/FooterFrontoffice.vue';
import ElsMeusCursos from '@/components/FO/tauler/sections/ElsMeusCursos.vue';

export default {
  components: {
    HeaderFrontoffice,
    FooterFrontoffice,
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
<template>
  <HeaderFrontoffice></HeaderFrontoffice>
  <div class="main-content-section container mt-4 px-4">
    <h1 class="fw-bold">Tauler:</h1>
    <hr>
    <!-- Mostrar tasques pendents de l'usuari. -->
    <TasquesPendents></TasquesPendents>

    <!-- Mostrar les tasques entregades de l'usuari. -->
    <TasquesEntregades class="my-5"></TasquesEntregades>
    
    <!-- Mostrar els cursos de l'usuari. -->
    <p class="h2 my-4 col-8">Els meus cursos:</p>
    <ElsMeusCursos class="mb-5"></ElsMeusCursos>

    <!-- Mostrar els videos de l'usuari. -->
    <p class="h2 my-4 col-8">Els meus videos:</p>
    <ElsMeusVideos class="mb-5"></ElsMeusVideos>

  </div>
  <FooterFrontoffice></FooterFrontoffice>
</template>
  
<script>
import HeaderFrontoffice from '@/components/FO/HeaderFrontoffice.vue';
import FooterFrontoffice from '@/components/FO/FooterFrontoffice.vue';
import TasquesPendents from '@/components/FO/tauler/sections/TasquesPendents.vue'
import TasquesEntregades from '@/components/FO/tauler/sections/TasquesEntregades.vue';
import ElsMeusCursos from '@/components/FO/tauler/sections/ElsMeusCursos.vue';
import ElsMeusVideos from '@/components/FO/tauler/sections/ElsMeusVideos.vue';

export default {
  components: {
    HeaderFrontoffice,
    FooterFrontoffice,
    TasquesPendents,
    TasquesEntregades,
    ElsMeusCursos,
    ElsMeusVideos
  }
}
</script>
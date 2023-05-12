<template>
  <HeaderFrontoffice></HeaderFrontoffice>
  <div class="container mt-4 px-4">
    <h1 class="fw-bold">Tauler:</h1>
    <hr>
    <TasquesRecents></TasquesRecents>

    <!-- <TasquesPassades class="my-5"></TasquesPassades> -->
    
    <!-- Capçalera i botons de filtre -->
    <p class="h2 my-4 col-8">Els meus cursos:</p>
    <ElsMeusCursos class="mb-5"></ElsMeusCursos>

    <p class="h2 my-4 col-8">Els meus videos:</p>
    <ElsMeusVideos class="mb-5"></ElsMeusVideos>

  </div>
  <FooterFrontoffice></FooterFrontoffice>
</template>
  
<script>
import HeaderFrontoffice from '@/components/FO/HeaderFrontoffice.vue';
import FooterFrontoffice from '@/components/FO/FooterFrontoffice.vue';
import TasquesRecents from '@/components/FO/tauler/sections/TasquesRecents.vue'
import TasquesPassades from '@/components/FO/tauler/sections/TasquesPassades.vue';
import ElsMeusCursos from '@/components/FO/tauler/sections/ElsMeusCursos.vue';
import ElsMeusVideos from '@/components/FO/tauler/sections/ElsMeusVideos.vue';

export default {
  components: {
    HeaderFrontoffice,
    FooterFrontoffice,
    TasquesRecents,
    TasquesPassades,
    ElsMeusCursos,
    ElsMeusVideos
  },
  data() {
    return {
    }
  },
  methods: {
    
  }
}
</script>
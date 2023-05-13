<template>
  <HeaderFrontoffice></HeaderFrontoffice>
  <div class="main-content-section container mt-4 px-4">
    <h1 class="fw-bold">Els meus videos:</h1>
    <hr>
      <ElsMeusVideos class="my-5" mostrarTots></ElsMeusVideos>
    
  </div>
  <FooterFrontoffice></FooterFrontoffice>
</template>
  
<script>
import HeaderFrontoffice from '@/components/FO/HeaderFrontoffice.vue';
import FooterFrontoffice from '@/components/FO/FooterFrontoffice.vue';
import ElsMeusVideos from '@/components/FO/tauler/sections/ElsMeusVideos.vue';

export default {
  components: {
    HeaderFrontoffice,
    FooterFrontoffice,
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
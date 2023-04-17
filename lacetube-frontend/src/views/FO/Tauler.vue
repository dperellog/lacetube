<template>
  <Header></Header>
  <div class="container mt-4 px-4">
    <h1 class="fw-bold">Tauler:</h1>
    <hr>
    <TasquesRecents></TasquesRecents>
    <br>
    <TasquesPassades></TasquesPassades>
    <br>
    <ElsMeusCursos></ElsMeusCursos>

  </div>
</template>
  
<script>
import Header from '@/components/Header.vue';
import TasquesRecents from '@/components/tauler/sections/TasquesRecents.vue'
import TasquesPassades from '@/components/tauler/sections/TasquesPassades.vue';
import ElsMeusCursos from '@/components/tauler/sections/ElsMeusCursos.vue';

export default {
  components: {
    Header,
    TasquesRecents,
    TasquesPassades,
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
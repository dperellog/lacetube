<template>
  <Header></Header>
  <div class="container mt-4 px-4">
    <h1 class="fw-bold">Tauler:</h1>
    <hr>
    <TasquesRecents></TasquesRecents>

    <TasquesPassades class="my-5"></TasquesPassades>

    
    <!-- Capçalera i botons de filtre -->
    <div class="row" v-if="!mostrarTots">
        <p class="h2 mb-3 col-8">Els meus cursos:</p>
    </div>
    <ElsMeusCursos class="mb-5"></ElsMeusCursos>

  </div>
</template>
  
<script>
import Header from '@/components/FO/Header.vue';
import TasquesRecents from '@/components/FO/tauler/sections/TasquesRecents.vue'
import TasquesPassades from '@/components/FO/tauler/sections/TasquesPassades.vue';
import ElsMeusCursos from '@/components/FO/tauler/sections/ElsMeusCursos.vue';

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
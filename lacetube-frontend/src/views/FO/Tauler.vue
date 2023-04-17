<template>
  <Header></Header>
  <div class="container mt-4 px-4">
    <h1 class="fw-bold">Tauler:</h1>
    <hr>
    <TasquesRecents></TasquesRecents>

  </div>
</template>
  
<script>
import Header from '@/components/Header.vue';
import TasquesRecents from '@/components/tauler/sections/TasquesRecents.vue'

export default {
  components: {
    Header,
    TasquesRecents
  },
  data() {
    return {
    }
  },
  methods: {
    
  }
}
</script>
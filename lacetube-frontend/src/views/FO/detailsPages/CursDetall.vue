<template>
  <Header></Header>
  <div class="container mt-4 px-4">
    <h1 class="h2">{{ curs.name }}</h1>
    <hr>
    <ElsMeusCursos class="my-5" mostrarTots></ElsMeusCursos>
  </div>
  <Footer></Footer>
</template>
  
<script>
import Header from '@/components/FO/Header.vue';
import Footer from '@/components/components/FO/Footer.vue';

import cursService from '@/services/Resources';

export default {
  components: {
    Header,
    Footer
  },
  props: {
    id: String
  },
  data() {
    return {
      curs: null
    }
  },
  async beforeMount(){
    this.curs = await cursService.getCourse(this.id)
    .then(r => {
      return r.data
    });
  },
  methods: {
    
  }
}
</script>
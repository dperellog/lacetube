<template>
  <HeaderFrontoffice></HeaderFrontoffice>
  <div v-if="curs !== null" class="container mt-4 px-4">
    <h1 class="h2">{{ curs.name }}</h1>
    <hr>
    <ol class="breadcrumb" v-if="curs.parent != undefined">
      <li v-if="curs.parent.id != undefined" class="breadcrumb-item">>></li>
      <li v-if="curs.parent != undefined" class="breadcrumb-item">{{ curs.parent.name }}</li>
      <li class="breadcrumb-item active">{{ curs.name }}</li>
    </ol>
    <div class="row">
      <div class="col-sm-8">
        <p>{{ curs.description }}</p>
      </div>
      <div class="col-sm-4">

      </div>
    </div>
    
  </div>
  <FooterFrontoffice></FooterFrontoffice>
</template>
  
<script>
import HeaderFrontoffice from '@/components/FO/HeaderFrontoffice.vue';
import FooterFrontoffice from '@/components/FO/FooterFrontoffice.vue';

import cursService from '@/services/Resources';
import userService from '@/services/User';

export default {
  components: {
    HeaderFrontoffice,
    FooterFrontoffice,
  },
  props: {
    id: String
  },
  data() {
    return {
      curs: null,
      activitats: null
    }
  },
  async beforeMount(){
    let cursID = this.id; 
    this.curs = await userService.getCourses().then(cursos => cursos.filter(curs => curs.id == cursID).shift())
    
    this.activitats = await cursService.getCourseActivities(this.id)
    .then(r => {
      return r.data
    });
  },
  
}
</script>
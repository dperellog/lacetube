<template>
  <HeaderFrontoffice></HeaderFrontoffice>

  <!-- <div class="container">
    <div>
      <form @submit.prevent="submitForm">
        <div>
          <label for="video-upload">Selecciona un video:</label>
          <input type="file" id="video-upload" ref="fileInput" @change="handleFileUpload">
        </div>
        <button type="submit">Subir video</button>
      </form>
    </div>
  </div> -->
</template>

<script>
import HeaderFrontoffice from "@/components/FO/HeaderFrontoffice.vue";
import axios from "@/services/Axios";

export default {
  components: {
    HeaderFrontoffice
  },
  beforeMount() {
      axios.get('/api/recomended/1', {
        description: 'Comentari de provaF',
        stars : 4,
        video_id: 1,
        user_id: 2
     })
        .then(response => {
          console.log(response.data);
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
</script>
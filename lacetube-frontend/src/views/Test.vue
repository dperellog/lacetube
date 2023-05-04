<template>
  <HeaderFrontoffice></HeaderFrontoffice>

  <div class="container">
    <div>
      <form @submit.prevent="submitForm">
        <div>
          <label for="video-upload">Selecciona un video:</label>
          <input type="file" id="video-upload" ref="fileInput" @change="handleFileUpload">
        </div>
        <button type="submit">Subir video</button>
      </form>
    </div>
  </div>
</template>

<script>
import HeaderFrontoffice from "@/components/FO/HeaderFrontoffice.vue";
import axios from "@/services/Axios";

export default {
  components: {
    HeaderFrontoffice
  },
  data() {
    return {
      video: null
    }
  },
  methods: {
    handleFileUpload() {
      this.video = this.$refs.fileInput.files[0];
    },

    async submitForm() {
      const formData = new FormData();
      formData.append('title', 'videoProva');
      formData.append('video', this.video);
      
      axios.post('/api/video/upload-video', formData)
        .then(response => {
          console.log(response.data);
        })
        .catch(error => {
          console.log(error);
        });
    }

  }
};
</script>
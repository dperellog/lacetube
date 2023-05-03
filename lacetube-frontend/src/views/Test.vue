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
import Header from "@/components/FO/Header.vue";
import axios from "@/services/Axios";

export default {
  components: {
    Header
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

<<<<<<< HEAD
  }
=======
  },
  beforeMount() {
    //  axios
    //    .get("/api/user/videos",)
    //    .then((r) => console.log("r :>> ", r))
    //    .catch((e) => console.log("e :>> ", e));
      // axios.get("sanctum/csrf-cookie")
      // .then(() =>
      //   axios.put("api/activity/modify/51", {
      //     name: "ActivityProva",
      //     description: "Activitat de prova",
      //     end_date: '2025-1asdasd2-12',
      //   })
      // )
      // .then((r) => console.log("r :>> ", r))
      // .catch((e) => console.log("e :>> ", e));
  },
>>>>>>> 4345370184dfcfab01218d6e7c57f17a98c4a4fc
};
</script>
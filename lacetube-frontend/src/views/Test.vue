<template>
  <Header></Header>
</template>
<script>
import Header from "@/components/FO/Header.vue";
import axios from "@/services/Axios";

export default {
  components: {
    Header,
  },
  beforeMount() {
    //  axios
    //    .get("/api/user/videos",)
    //    .then((r) => console.log("r :>> ", r))
    //    .catch((e) => console.log("e :>> ", e));

    axios
      .get("sanctum/csrf-cookie")
      .then(() =>
        axios.put("api/course/all", {
          
          
          name: "CourseProva",
          thumbnailURL: "https://via.placeholder.com/640x480.png/00eeaa?text=a",
          description: "Curs de prova",
          year: 2024,
          
        })
      )
      .then((r) => console.log("r :>> ", r))
      .catch((e) => console.log("e :>> ", e));
  },
};
</script>
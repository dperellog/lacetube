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
     axios.get('/api/user')
          .then(r => console.log('r :>> ', r))
         .catch(e => console.log('e :>> ', e))

    // axios
    //   .get("sanctum/csrf-cookie")
    //   .then(() =>
    //     axios.post("/api/course/create", {
    //         name: "prova323",
    //         description: "curs de prova test",
    //         thumbnailURL:
    //           "https://via.placeholder.com/640x480.png/00aaff?text=animi",
    //         year: 2015,
    //         teacher_id: 1,
    //         parent_id: 2
    //     })
    //   )
    //   .then((r) => console.log("r :>> ", r))
    //   .catch((e) => console.log("e :>> ", e));
  },
};
</script>
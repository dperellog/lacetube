<template>
  <Header></Header>
</template>
<script>
import Header from "../components/Header.vue";
import axios from "@/services/Axios";

export default {
<<<<<<< HEAD
  components: {
    Header,
  },
  beforeMount() {
     axios.get('/api/user')
          .then(r => console.log('r :>> ', r))
         .catch(e => console.log('e :>> ', e))
=======
    
    components: {
        Header
    },
    beforeMount(){
        axios.get('/api/user/videos')
            .then(r => console.log('r :>> ', r))
        axios.get('/api/activity/1')
             .then(r => console.log('r :>> ', r))
            .catch(e => console.log('e :>> ', e))
>>>>>>> 754a1e5d201161566f6e689a87257f60271d16af

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
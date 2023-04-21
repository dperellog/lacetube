<template>
  <Header></Header>
</template>
<script>
import Header from "../components/Header.vue";
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
         axios.get("/api/user/avatar", {
          name: "Prova2",
          email: "prova3@prova.com",
          password: "1qazZAQ!",
          password_confirmation: "1qazZAQ!",
          role: "teacher",
        })
        )
        .then((r) => console.log("r :>> ", r))
        .catch((e) => console.log("e :>> ", e));
  },
};
</script>
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
        axios.put("api/activity/modify/51", {
          name: "ActivityProva",
          description: "Activitat de prova",
          end_date: '2025-1asdasd2-12',
        })
      )
      .then((r) => console.log("r :>> ", r))
      .catch((e) => console.log("e :>> ", e));
  },
};
</script>
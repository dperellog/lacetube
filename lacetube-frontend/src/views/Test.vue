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
         axios.post("api/course/delete/1", 
         {
         "users" : [
             {
                 "name": "prova1",
                 "email": "prova1333@prova.com",
                 "password": "1qazZAQ!",
                 "password_confirmation": "1qazZAQ!",
                 "role": "student"
             },
             {
                 "name": "prova2",
                 "email": "prova2333@prova.com",
                 "password": "1qazZAQ!",
                 "password_confirmation": "1qazZAQ!",
                 "role": "teacher"
             },
             {
                 "name": "prova3",
                 "email": "prova3333@prova.com",
                 "password": "1qazZAQ!",
                 "password_confirmation": "1qazZAQ!",
                 "role": "admin"
             }

         ]
     }
         )
        )
        .then((r) => console.log("r :>> ", r))
        .catch((e) => console.log("e :>> ", e));
  },
};
</script>
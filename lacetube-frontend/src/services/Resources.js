import Service from "./Axios";

export default {

    async getCourse(id) {
        return Service.get('api/course/'+id)
    },


    async logout(){
        return Service.get('sanctum/csrf-cookie')
        .then(() => Service.post('logout'))
    }
}
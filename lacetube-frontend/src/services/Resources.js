import Service from "./Axios";

export default {

    async getCourse(id) {
        return Service.get('api/course/'+id)
    },

    async getAllCourses() {
        return Service.get('api/course/all')
    },

    async logout(){
        return Service.get('sanctum/csrf-cookie')
        .then(() => Service.post('logout'))
    }
}
import Service from "./Axios";

export default {

    async getCourse(id) {
        return Service.get('api/course/'+id)
    },

    async getAllCourses() {
        return Service.get('api/course/all')
    },

    async getAllStudents(){
        return Service.get('api/user/students')
    },

    async getAllUsers(){
        return Service.get('api/user/all')
    },

    async logout(){
        return Service.get('sanctum/csrf-cookie')
        .then(() => Service.post('logout'))
    }
}
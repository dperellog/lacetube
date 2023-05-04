import Service from "./Axios";

export default {

    async getCourse(id) {
        return Service.get('api/course/'+id)
    },

    async getCourseActivities(id) {
        return Service.get('api/course/activities/'+id)
    },

    async getAllCourses() {
        return Service.get('api/course/all')
    },

    async createCourse(course) {
        return Service.get('sanctum/csrf-cookie')
            .then(() => Service.post('/api/course/create', course))
    },

    async modifyCourse(course) {
        return Service.get('sanctum/csrf-cookie')
            .then(() => Service.put('/api/course/modify/'+course.id, course))
    },

    async deleteCourse(courseID) {
        return Service.get('sanctum/csrf-cookie')
        .then(() => Service.delete('/api/course/delete/'+courseID))
    },

    async getAllStudents(){
        return Service.get('api/user/students')
    },

    async getAllTeachers(){
        return Service.get('api/user/teachers')
    },

    async getAllUsers(){
        return Service.get('api/user/all')
    },

    async logout(){
        return Service.get('sanctum/csrf-cookie')
        .then(() => Service.post('logout'))
    }
}
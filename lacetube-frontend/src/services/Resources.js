import Service from "./Axios";

export default {

    async getCourse(id) {
        return Service.get('api/course/' + id)
    },

    async getActivity(id) {
        return Service.get('api/activity/' + id)
    },

    async getCourseActivities(id) {
        return Service.get('api/course/activities/' + id)
    },

    async getAllCourses() {
        return Service.get('api/course/all')
    },

    async createCourse(course) {
        return Service.get('sanctum/csrf-cookie')
            .then(() => Service.post('/api/course/create', course, {
                headers: {
                    'content-type': 'multipart/form-data',
                }
            }))
    },

    async modifyCourse(course, id) {
        return Service.get('sanctum/csrf-cookie')
            .then(() => Service.post('/api/course/modify/' + id, course, {
                headers: {
                    'content-type': 'multipart/form-data',
                }
            }))
    },

    async deleteCourse(courseID) {
        return Service.get('sanctum/csrf-cookie')
            .then(() => Service.delete('/api/course/delete/' + courseID))
    },

    async createTask(task) {
        return Service.get('sanctum/csrf-cookie')
            .then(() => Service.post('/api/activity/create', task))
    },

    async modifyTask(task) {
        return Service.get('sanctum/csrf-cookie')
            .then(() => Service.put('/api/activity/modify/' + task.id, task))
    },

    async deleteTask(taskID) {
        return Service.get('sanctum/csrf-cookie')
            .then(() => Service.delete('/api/activity/delete/' + taskID))
    },

    async getAllStudents() {
        return Service.get('api/user/students')
    },

    async getAllTeachers() {
        return Service.get('api/user/teachers')
    },

    async getAllUsers() {
        return Service.get('api/user/all')
    },

    async uploadVideo(video) {
        return Service.get('sanctum/csrf-cookie')
            .then(() => Service.post('api/video/upload-video', video, {
                headers: {
                    'content-type': 'multipart/form-data',
                }
            }))
    },

    async getVideo(videoID) {
        return Service.get('api/video/' + videoID)
    },

    async deleteVideo(videoID){
        return Service.get('sanctum/csrf-cookie')
            .then(() => Service.delete('/api/video/delete/' + videoID))
    },

    async getVideos(tascaID) {
        return Service.get('api/video/task/' + tascaID)
    },

    async getRecomended(videoID) {
        return Service.get('api/recomended/' + videoID)
    },

    async searchBackend(searchText, searchField) {
        return Service.get('sanctum/csrf-cookie')
            .then(() => Service.post('api/search/json', {
                content: searchField,
                search: searchText
            }));
    },

    async sendComment(comment) {
        return Service.get('sanctum/csrf-cookie')
            .then(() => Service.post('api/comment/create', comment));
    },

    async getStatistics() {
        return Service.get('api/stats')
    },

    async logout() {
        return Service.get('sanctum/csrf-cookie')
            .then(() => Service.post('logout'))
    }
}
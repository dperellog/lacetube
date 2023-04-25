import Service from "./Axios";
import { baseURL } from "./Axios";


export default {

    async getActivities() {
        return Service.get('api/user/activities')
    },

    async getCourses() {
        return Service.get('api/user/courses')
    },

    getAvatarURLByAvatar(avatar) {
        return baseURL + 'avatar/' + avatar
    },

    async logout() {
        return Service.get('sanctum/csrf-cookie')
            .then(() => Service.post('logout'))
    },

    translateRole(role) {
        let roles = {
            admin: 'Administrador',
            teacher: "Professor",
            student: "Estudiant"
        }

        return roles[role];
    }
}
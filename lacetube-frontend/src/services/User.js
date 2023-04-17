import Service from "./Axios";

export default {

    async getActivities() {
        return Service.get('api/user/activities')
    },

    async logout(){
        return Service.get('sanctum/csrf-cookie')
        .then(() => Service.post('logout'))
    }
}
import Service from "./Axios";

export default {

    async login(userData) {
        return Service.get('api/sanctum/csrf-cookie')
        .then(() => Service.post('/api/login', userData))
    },

    async logout(){
        return Service.get('api/sanctum/csrf-cookie')
        .then(() => Service.post('/api/logout'))
    },

    async updatePassword(passwordForm){
        return Service.get('api/sanctum/csrf-cookie')
        .then(() => Service.post('/api/update-password', passwordForm))
    }
}
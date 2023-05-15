import Service from "./Axios";

export default {

    async login(userData) {
        return Service.get('sanctum/csrf-cookie')
        .then(() => Service.post('/login', userData))
    },

    async logout(){
        return Service.get('sanctum/csrf-cookie')
        .then(() => Service.post('logout'))
    },

    async updatePassword(passwordForm){
        return Service.get('sanctum/csrf-cookie')
        .then(() => Service.post('/api/update-password', passwordForm))
    }
}
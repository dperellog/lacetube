import Service from "./Axios";
import { baseURL } from "./Axios";
import { useUserStore } from "../stores/userStore";


export default {

    async registerUsers(usersArray) {

        return Service.get('sanctum/csrf-cookie')
            .then(() => Service.post('api/register/json', { users: usersArray }))
    },

    async getActivities() {

        let userStore = useUserStore();

        return new Promise((resolve, reject) => {

            let storeActivities = userStore.getUserActivities();

            if (!storeActivities) {
                Service.get('api/user/activities')
                    .then(r => {
                        userStore.setUserActivities(r.data);
                        resolve(r.data)
                    })
                    .catch(e => reject(e))
            } else {
                resolve(storeActivities)
            }

        })

    },

    async getCourses(force = false) {
        let userStore = useUserStore();

        return new Promise((resolve, reject) => {

            let storeCourses = userStore.getUserCourses();

            if (!storeCourses || force) {
                if (userStore.hasRole('admin')) {
                    Service.get('api/course/all')
                        .then(r => {
                            userStore.setUserCourses(r.data);
                            resolve(r.data)
                        })
                        .catch(e => reject(e))
                }
                else {
                    Service.get('api/user/courses')
                        .then(r => {
                            userStore.setUserCourses(r.data.data);
                            resolve(r.data.data)
                        })
                        .catch(e => reject(e))
                }

            } else {
                resolve(storeCourses)
            }

        })
    },

    getAvatarURLByAvatar(avatar) {
        if (avatar) {
            return baseURL + 'avatar/' + avatar
        } else {
            ''
        }

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
    },

    async getVideos(force = false) {
        let userStore = useUserStore();

        return new Promise((resolve, reject) => {

            let storeVideos = userStore.getUserVideos();

            if (!storeVideos || force) {
                if (userStore.hasRole('admin')) {
                    Service.get('api/user/videos')
                        .then(r => {
                            userStore.setUserVideos(r.data.data);
                            resolve(r.data.data)
                        })
                        .catch(e => reject(e))
                }
                else {
                    Service.get('api/user/videos')
                        .then(r => {
                            userStore.setUserVideos(r.data.data);
                            resolve(r.data.data)
                        })
                        .catch(e => reject(e))
                }

            } else {
                resolve(storeVideos)
            }
        })
    }
}
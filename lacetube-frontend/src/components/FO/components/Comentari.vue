<template>
    <div>
        <div class="comentari mt-2" :class="{'professor': professor}">
            <!-- Capçalera formulari -->
            <div class="row py-2">
                <div class="col-auto">
                    <avatar :url="userService.getAvatarURLByAvatar(comentari.user.avatar)" :size="'sm'"></avatar>
                </div>
                <div class="col">
                    <div class="d-flex justify-content-between">
                        <div><h6 class="fw-bold"> {{ comentari.user.name }}</h6>
                        <span class="fw-normal text-secondary">Publicat {{ antiguitat }}</span></div>
                        <div v-if="professor" class="text-secondary"><i class="fa-solid fa-graduation-cap"></i>&nbsp;&nbsp;És professor del curs</div>
                    </div>
                    
                </div>
            </div>

            <!-- Comentari: -->
            <div class="missatgeBox">
                <p>
                    <span v-for="i in comentari.stars" style="color: #FF9F1C;"><i class="fa-solid fa-star"></i></span>
                    <span v-for="i in 5 - comentari.stars" style="color: #D5D5D5;"><i class="fa-solid fa-star"></i></span>
                </p>
                <p>{{ comentari.description }}</p>
            </div>
        </div>
    </div>
</template>
    
<script>
import moment from 'moment';
import { useUserStore } from '@/stores/userStore';

import Avatar from '@/components/common/Avatar.vue';

import userService from '@/services/User';

export default {
    components: {
        Avatar
    },
    props: {
        comentari: {
            type: Object
        },
        professor: {
            type: Boolean
        }
    },
    setup() {
        return {
            userService: userService
        }
    },
    data() {
        return {

        }
    },
    computed: {
        antiguitat() {
            // Obtener la fecha actual
            const present = moment();
            const dataCreacio = moment(this.comentari.published_at);

            // Calcular la diferencia de tiempo entre la fecha actual y la fecha de publicación del comentario
            const diferenciaTemps = dataCreacio.diff(present, 'minutes');

            // Formatear la diferencia de tiempo en términos amigables para el usuario
            return moment.duration(diferenciaTemps, 'minutes').humanize(true);
        }
    }

}
</script>

<style scoped>
.comentari {
    padding: 1rem;
    background-color: #EAEAEA;
    border-color: #F9F7F3;
    border-radius: 1rem;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}

.comentari.professor{
    box-shadow: #ffb349 0px 7px 29px 0px;

}
</style>
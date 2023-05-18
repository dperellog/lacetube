<template>
    <HeaderFrontoffice></HeaderFrontoffice>
    <div class="main-content-section container-fluid m-0 p-0">
        <div class="position-relative overflow-hidden p-3 p-md-5 text-center bg-light banner-index">
            <div class="col-md-5 p-lg-5 mx-auto my-5">
                <h2 class="h3 text-secondary font-weight-normal">Benvingut a</h2>
                <h1 class="fw-bold text-warning display-4">Lacetube</h1>
                <p class="lead font-weight-normal">El teu LMS de referència per interactuar amb els estudiants utilitzant
                    videos!</p>
                <router-link to="/login" v-if="!userStore.isLogged" class="btn btn-lg btn-warning" href="#">Iniciar
                    Sessió</router-link>
                <router-link to="/tauler" v-else class="btn btn-lg btn-outline-warning" href="#">Accedir al
                    taulell</router-link>
            </div>
        </div>
    </div>
    <FooterFrontoffice></FooterFrontoffice>
</template>
<script>
import HeaderFrontoffice from '../../components/FO/HeaderFrontoffice.vue';
import FooterFrontoffice from '../../components/FO/FooterFrontoffice.vue';
import { useUserStore } from '@/stores/userStore';

export default {
    components: {
        HeaderFrontoffice,
        FooterFrontoffice
    },
    setup() {
        let userStore = useUserStore();
        return { userStore: userStore };
    },
}
</script>
<style scoped>
.banner-index {
    background-image: url('/banner-bg.png');
    background-size: cover;
}

.fo-header {
    margin-bottom: 0rem !important;
}</style>
<template>
    <HeaderFrontoffice></HeaderFrontoffice>
    <div class="main-content-section  d-flex align-items-center justify-content-center vh-50">
            <div class="text-center">
                <h1 class="display-1 fw-bold">404</h1>
                <p class="fs-3"> <span class="text-warning">Ups!</span> No hem pogut trobar la pàgina que busques.</p>
                <p class="lead">
                    Comprova que la URL sigui correcte.
                  </p>
                <router-link to="/" class="btn btn-warning">Anar a l'inici</router-link>
            </div>
        </div>
    
    <FooterFrontoffice></FooterFrontoffice>
</template>
<script>
import HeaderFrontoffice from '@/components/FO/HeaderFrontoffice.vue';
import FooterFrontoffice from '@/components/FO/FooterFrontoffice.vue';

export default {
    components: {
        HeaderFrontoffice,
        FooterFrontoffice
    },
}
</script>
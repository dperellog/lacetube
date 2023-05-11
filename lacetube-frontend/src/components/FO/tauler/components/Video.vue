<template>
    <div class="cursPreview">
        <div class="thumbnail border rounded-4" :style="{ backgroundImage: 'url(' + video.thumbnailURL + ')' }"></div>
        <h5 class="fw-bold mt-1">{{ video.name }}</h5>
        <h6 class="teacher-name text-secondary ">
            <i class="fa-solid fa-user-graduate"></i>&nbsp;&nbsp;<span><em>{{ video.user.name }}</em></span>
            </h6>

    </div>
</template>
    
<script>

export default {
    props: {
        video: {
            type: Object
        }
    }

}
</script>

<style scoped>
.card {
    background-color: #F9F7F3;
    border-color: #F9F7F3;
    border-radius: 42px;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}

.thumbnail {
    height: 10rem;
    overflow: hidden;
    background-position: center;
    background-size: cover;
}
</style>
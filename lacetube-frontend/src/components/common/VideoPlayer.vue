<template>
  <div>
    <video ref="videoPlayer" class="video-js"></video>
  </div>
</template>
  
<script>
import { videoPlayer } from 'vue-videojs7'

export default {
  components: {
    videoPlayer
  }
}
</script>
<template>
  <HeaderFrontoffice></HeaderFrontoffice>
  <div v-if="video.data !== null">
    <!-- <vue-plyr ref="plyr" :options="playerOptions">
      <video width="352" height="198" controls crossorigin playsinline id="videoplayer"
        ></video>
        :poster="video.data.thumbnailURL"
    </vue-plyr> -->
    <vue-plyr :options="playerOptions">
			<video
				controls
				crossorigin
				playsinline
				:data-poster="video.data.thumbnailURL"
			>
				<source
					:src="video.data.streamingPath"
					type="application/vnd.apple.mpegurl"
				/>
			</video>
		</vue-plyr>
  
  </div>
  <!-- <video width="352" height="198" controls v-if="video.data !== null">
    <source :src="video.data.streamingPath" type="application/x-mpegURL">
</video> -->

  

  <FooterFrontoffice></FooterFrontoffice>
</template>
  
<script>
import HeaderFrontoffice from '@/components/FO/HeaderFrontoffice.vue';
import FooterFrontoffice from '@/components/FO/FooterFrontoffice.vue';

import videoService from '@/services/Resources';

import VuePlyr from 'vue-plyr';
import Hls from 'hls.js';

export default {
  components: {
    HeaderFrontoffice,
    FooterFrontoffice,
    VuePlyr
  },
  props: {
    id: String
  },
  setup() {
    return {
    }
  },
  data() {
    return {
      video: {
        error: false,
        data: null
      },
      playerOptions: {
        controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'settings', 'fullscreen'],
        settings: ['quality', 'speed', 'loop'],
      }
    }
  },
  computed: {
        player() {
            console.log(this.$refs.plyr.player);
            return this.$refs.plyr.player;
        },
    },
  async beforeMount() {
    let videoID = this.id;
    this.video.data = await videoService.getVideo(videoID)
      .then(r => {
        return r.data;
      });

  },
  watch: {
    video() {
      if (video.data !== null) {
        this.videoMounted()
      }
    } 
  },
  methods: {
    videoMounted() {
        if (Hls.isSupported()) {
            const hls = new Hls();
            hls.loadSource(this.video.data.streamingPath);
            //hls.loadSource("http://api.lacetube.cat:8000/video/Y6nSEN5ggwWcy3vYFDvDgaLFzcvye4miBnoVU1tr/Y6nSEN5ggwWcy3vYFDvDgaLFzcvye4miBnoVU1tr_0_3000.m3u8");
            hls.attachMedia(this.player.media);

            window.hls = hls;
        }
    },
  }

}
</script>
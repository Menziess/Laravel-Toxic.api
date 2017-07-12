<template>
  <div>
    <div v-if="post">

      <!-- No Embed -->
      <div class="image-border">
        <div class="video-container">
          <img v-if="!embedSrc"
            class="image-drawing"
            @click="interact()"
            :title="post.relationships.resource.attributes.realurl"
            :src="post.attributes.drawing"
          >
          <button v-if="embed && !embedSrc" class="btn-video" @click="interact()"><i class="glyphicon glyphicon-play"></i></button>
        </div>
        <!-- Embed -->
        <div v-if="embedSrc" class="embed-responsive embed-responsive-16by9">
          <iframe type="text/html" width="640" height="390"
            :src="embedSrc"
            allowfullscreen="allowfullscreen"
            frameborder="0"/>
        </div>
        <div class="image-info" @click="checkout()">
          <strong>{{ resource.attributes.title }}</strong>
          <br>
          <span>{{ resource.attributes.description }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'linkbox',
  props: ['post'],
  data: () => ({
    embedSrc: null,
  }),
  computed: {
    resource() {
      return this.post.relationships.resource;
    },
    embed() {
      return this.resource.attributes.embed
    },
    atDetail() {
      return this.$route.params.id && this.$route.params.slug;
    },
  },
  methods: {
    interact() {
      if (this.embed) this.loadVideo();
      else this.openLink();
    },
    checkout() {
      this.$router.push({ 
        name: 'post',
        params: { slug: this.post.attributes.slug, id: this.post.id }
      });
    },
    loadVideo() {
      this.embedSrc = 'https://www.youtube-nocookie.com/embed/' + this.embed + '?playlist=' + this.embed + 'rel=0&autoplay=1&modestbranding=0&autohide=1&showinfo=0&controls=1';
    },
    openLink() {
      window.location.href = this.post.relationships.resource.attributes.realurl;
    }
  }
}
</script>

<style scoped>
.glyphicon-play {
  color: #30cf4f !important;
  font-size: xx-large;
  text-shadow: 2px 2px 10px rgba(0,0,0,0.2);
}
.btn-video {
  position: absolute;
  bottom: 50%;
  margin: 0px -35px -35px 0px;
  width: 70px;
  height: 70px;
  right: 50%;
  border: 6px solid #30cf4f;
  border-radius: 50%;
  background-color: rgba(255,255,255,0.8);
  font-weight: bold;
  transition: all 0.3s ease;
  outline: none;
  text-align: center;
}
.btn-video:hover {
  background-color: rgba(255,255,255,0.5);
	box-shadow: 0px 0px 10px rgba(0,0,0,0.75);
}
.video-container {
  position: relative;
  text-align: center;
}
.image-drawing {
  display: block;
  width: 100%;
}
.image-info {
  background-color: rgba(255,255,255,0.98);
  word-break: break-all;
  padding: 0.5em;
}
.embed-responsive {
  background-color: black;
}
</style>

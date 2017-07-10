<template>
  <div>
    <div v-if="post">

      <!-- No Embed -->
      <div v-if="!embed" class="image-border">
        <img 
          class="image-drawing"
          :src="post.attributes.drawing"
        >
        <div class="image-info">
          <strong>{{ resource.attributes.title }}</strong>
          <br>
          <span>{{ resource.attributes.description }}</span>
        </div>
      </div>


      <!-- Embed -->
      <div v-else class="embed-responsive embed-responsive-16by9">
        <div class="embed-responsive-item" v-html="embed"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'linkbox',
  props: ['post'],
  computed: {
    resource() {
      return this.post.relationships.resource;
    },
    embed() {
      return this.resource.attributes.embed
    }
  },
  mounted() {
    console.log(this.post);
  }
}
</script>

<style scoped>
.image-drawing {
  display: block;
  width: 100%;
}
.image-info {
  background-color: rgba(255,255,255,0.98);
  padding: 0.5em;
}
</style>

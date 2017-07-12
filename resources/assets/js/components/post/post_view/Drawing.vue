<template>
  <div @click="checkout()">
    <div v-if="post">
      <img 
        class="image-drawing image-border"
        :src="post.attributes.drawing"
      >
    </div>
  </div>
</template>

<script>
  export default {
    name: 'drawing',
    props: ['post'],
    methods: {
      checkout() {
        this.$router.push({ 
          name: 'post',
          params: { slug: this.post.attributes.slug, id: this.post.id }
        });
      },
    }
  }
</script>

<style scoped>
.image-drawing {
  display: block;
  width: 100%;
}
</style>

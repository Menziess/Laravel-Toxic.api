<template>
  <div>
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
    props: ['post']
  }
</script>

<style scoped>
.image-drawing {
  display: block;
  width: 100%;
}
</style>

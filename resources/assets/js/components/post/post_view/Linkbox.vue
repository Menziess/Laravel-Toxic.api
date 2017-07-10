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
  name: 'linkbox',
  props: ['post'],
  mounted() {
    console.log(this.post);
  }
}
</script>

<style>
.image-drawing {
  display: block;
  width: 100%;
}
</style>

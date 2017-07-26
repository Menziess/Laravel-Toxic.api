<template>
  <div @click="checkout()">
    <div v-if="post" class="panel">
      <div :class="[{ 'image-placeholder': !show }]">
        <img
          v-on:load="show = true"
          v-show="show"
          class="image-drawing"
          :src="post.attributes.drawing"
        > 
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'drawing',
    props: ['post'],
    data() {
      return {
        show: false
      }
    },
    methods: {
      checkout() {
        this.$router.push({ 
          name: 'post',
          params: { slug: this.post.attributes.slug, id: this.post.id }
        });
      }
    }
  }
</script>
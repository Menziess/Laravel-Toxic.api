<template>
  <div>
    <div v-if="post">
      <img 
        class="img-responsive image-border"
        :src="post.attributes.drawing"
        width="304" height="236"
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
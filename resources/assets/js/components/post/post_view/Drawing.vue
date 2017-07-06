<template>
  <div class="panel-content">
    <div v-if="post" class="leftist">
      <img 
        class="img-responsive"
        :src="post.attributes.drawing"
        width="200px"
        height="200px"
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

<template>
	<div @click="checkout()">
		<p class="post-content">{{ post.attributes.text }}</p>
		<div class="clearfix"></div>
	</div>
</template>

<script>
  export default {
    name: 'textbox',
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
<template>
	<div>
		<p class="post-content">{{ text }}</p>
		<div class="clearfix"></div>
	</div>
</template>

<script>
  export default {
    name: 'textbox',
    props: ['text']
  }
</script>

<style scoped>
.post-content {
	margin: 1em 0 0 1em;
	font-size: initial;
	word-wrap: break-word;
}
</style>
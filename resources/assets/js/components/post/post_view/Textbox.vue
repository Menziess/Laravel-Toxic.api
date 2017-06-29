<template>
	<div>
		<div class="col-md-6 post-content">
			<p>{{ text }}</p>
		</div>
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
	margin: 1em 0 0 0;
	font-size: initial;
	word-wrap: break-word;
}
</style>
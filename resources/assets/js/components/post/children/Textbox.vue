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
	margin: 0 1em 1em 3.5em;
}
</style>
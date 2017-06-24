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
	margin: 4em 1em 1em 4.5em;
}
</style>
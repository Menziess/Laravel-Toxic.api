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
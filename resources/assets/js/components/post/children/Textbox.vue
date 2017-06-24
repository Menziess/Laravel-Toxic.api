<template>
	<div>
		<div class="col-md-2">
			<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcREzIVuk6-jJ8zFFSCTc4lDQWn6fS2AVmRoLslW1uysVaas69IM" 
				class="img-circle noselect profile-pic"
				width="73"
				height="73"> 
		</div>
		<div class="col-md-6">
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

</style>
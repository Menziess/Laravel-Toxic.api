<template>
	<div>
		<div class="col-md-2">
			<img src="https://pbs.twimg.com/profile_images/2357255384/j70auysk95ch0chza3nw_bigger.jpeg" 
				class="img-circle noselect"
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
p {
	margin-top: 1em;
}

img {
	margin-top: 1em;
	border: lightgray solid 2px;
}
</style>
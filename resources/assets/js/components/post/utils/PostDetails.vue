<template>
  <div class="post-details">

		<div class="col-sm-2">
			<img :src="userpic" 
				class="img-circle noselect profile-pic"
				width="73"
				height="73"> 
		</div>

		<div class="col-sm-4">
			<p>/u/{{ this.userslug }}</p>
			<p>{{ this.username }}</p>
		</div>
		<div class="clearfix"></div>

  </div>
</template>

<script>
export default {
	name: 'postdetails',
	props: ['username', 'userslug', 'userpic']
}
</script>

<style scoped>
.post-details {
  margin: 1em 0;
}
</style>

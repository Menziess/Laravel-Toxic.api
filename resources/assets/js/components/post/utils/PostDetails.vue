<template>
  <div class="post-details">

		<img :src="userpic"
			class="img-circle noselect profile-pic"
			width="48"
			height="48"
			:title="username"> 
		
		<div class="user-info">

			<router-link :to="'/u/' + this.userslug" class="btn btn-secondary navbar-btn">
				<span><strong>{{ this.username }}</strong></span>
			</router-link>

			&nbsp;
			<span>/u/{{ this.userslug }}</span>
		</div>

  </div>
</template>

<script>
export default {
	name: 'postdetails',
	props: ['username', 'userslug', 'userpic']
}
</script>

<style scoped>
.user-info {
	display: inline-block;
	margin: 0.5em 0.5em 0 0.5em;
	overflow: hidden;
	z-index: -1;
}
.post-details {
	padding: 0.5em;
}
</style>

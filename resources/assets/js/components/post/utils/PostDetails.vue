<template>
  <div class="post-details">

		<img :src="userpic"
			class="img-circle noselect profile-pic"
			width="48"
			height="48"
			:title="username"> 
		
		<div class="user-info">
			<a :href="slugUrl">
				<span><strong>{{ this.username }}</strong></span>
			</a>
			&nbsp;
			<span>{{ slugUrl }}</span>
		</div>

  </div>
</template>

<script>
export default {
	name: 'postdetails',
	props: ['username', 'userslug', 'userpic'],
	computed: {
		slugUrl() {
			return 'u/' + this.userslug;
		}
	}
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

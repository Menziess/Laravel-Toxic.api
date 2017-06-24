<template>
  <div class="post-details">

		<img :src="userpic"
			class="img-circle noselect profile-pic"
			width="48"
			height="48"
			:title="username"> 

		<a :href="slugUrl">
			<span><strong>{{ this.username }}</strong></span>
		</a>
		<span>{{ slugUrl }}</span>
			

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
img, span {
	display: inline-block;
	margin: 0.5em 0.5em 0 0.5em;
}
.post-details {
	position: absolute;
	padding: 0.5em;
}
</style>

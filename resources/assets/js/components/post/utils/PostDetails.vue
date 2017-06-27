<template>
  <div class="post-details">

		<img :src="userpic"
			class="img-circle noselect profile-pic"
			width="48"
			height="48"
			:title="username"> 
		
		<div class="user-info">
			<div class="username">
				<router-link :to="'/u/' + this.userslug">
					<span><strong>{{ this.username }}</strong></span>
				</router-link>
			</div>

			<div class="userslug">
				<span>/u/{{ this.userslug }}</span>
			</div>
		</div>

		<div class="dropdown pull-right">
			<a class="btn options" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
				<i class="glyphicon glyphicon-option-horizontal"></i>
			</a>
			
			<ul role="menu" class="dropdown-menu">

				<li role="presentation">
					<a v-on:click="deletePost()" role="menuitem">Delete</a>
				</li>

				<!--<li role="presentation">
					<a href="#" role="menuitem">Button 2</a>
				</li>-->

			</ul>
		</div>

  </div>
</template>

<script>
export default {
	name: 'postdetails',
	props: ['username', 'userslug', 'userpic'],
	methods: {
		deletePost() {
			this.$emit('deletepost');
		}
	}
}
</script>

<style scoped>
.post-details {
	padding: 0.5em;
}
.user-info {
	vertical-align: top;
	display: inline-block;
	z-index: -1;
	margin: 0 0.5em 0 0.5em;
}
.options {
	display: inline-block;
}
</style>

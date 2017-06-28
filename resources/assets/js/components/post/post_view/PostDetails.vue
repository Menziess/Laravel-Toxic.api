<template>
  <div class="post-details">

		<img 
			:src="post.relationships.user.attributes.picture"
			:title="post.relationships.user.attributes.name" 
			class="img-circle noselect profile-pic"
			width="48"
			height="48"
		>
		
		<div class="info">
			<div class="text inline">
				<router-link :to="'/u/' + this.post.relationships.user.attributes.slug">
					<span><strong>{{ this.post.relationships.user.attributes.name }}</strong></span>
				</router-link>
			</div>

			<div class="text inline">
				<span>/u/{{ this.post.relationships.user.attributes.slug }}</span>
			</div>

			<div class="text inline">
				<span>{{ this.post.attributes.created_at }}</span>		
			</div>
		</div>

		
		<div class="dropdown inline pull-right">
			<button type="button" class="btn" data-toggle="dropdown" role="button" aria-expanded="false">
				<i class="glyphicon glyphicon-option-horizontal"></i>
			</button>
			
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
	props: ['post'],
	methods: {
		deletePost() {
			axios({
				method: 'delete',
				url: '/api/post/' + this.post.id
			}).then(response => {
				this.$store.commit('deletePostById', this.post.id);
			}).catch(error => {
				this.$emit('error', error);
			});
		},
	},
}
</script>

<style scoped>
.post-details {
	padding: 0.5em;
}
.info {
	display: inline-grid;
	vertical-align: top;
}
.text {
	text-overflow: ellipsis;
	vertical-align: top;
	margin: 0 0.5em 0 0.5em;
}
</style>

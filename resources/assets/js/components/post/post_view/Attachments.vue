<template>
  <div class="post-details">

		<div class="left">
			<img 
				class="img-circle noselect profile-pic"
				:src="post.relationships.user.attributes.picture"
				:title="post.relationships.user.attributes.name" 
				width="48"
				height="48"
			>
			<li class="btn"><i class="glyphicon glyphicon-menu-up"></i></li>
			<span>24234</span>
			<li class="btn"><i class="glyphicon glyphicon-menu-down"></i></li>
		</div>
		
		<div class="mid">
			<router-link class="text" :to="'/u/' + this.post.relationships.user.attributes.slug">
				<span><strong>{{ this.post.relationships.user.attributes.name }}</strong></span>
			</router-link>
			<br>
			<span class="text">/u/{{ this.post.relationships.user.attributes.slug }}</span>
			<!--<span class="text">{{ this.post.attributes.created_at }}</span>		-->

			<!-- Post Content -->
			<div class="clickable" >
				<Textbox      v-if="post.attributes.attachment === 'text'" :text="post.attributes.text"></Textbox>
				<Drawing v-else-if="post.attributes.attachment === 'drawing'" ref="myDrawing"></Drawing>
				<p v-else-if="post.attributes.attachment === 'url'">{{ post.attributes.url }}</p>
				<p v-else-if="post.attributes.attachment === 'video'">{{ post.attributes.url }}</p>
				<p v-else-if="post.attributes.attachment === 'image'">{{ post.attributes.url }}</p>
			</div>

			<!-- Buttons -->
			<div class="panel-buttons">
				<button class="btn" @click="reply()"><i class="glyphicon glyphicon-share-alt reply"></i></button>
			</div>
		</div>
		
		<div class="right">
			<button type="button" class="btn" data-toggle="dropdown" role="button" aria-expanded="false">
				<i class="glyphicon glyphicon-cog"></i>
			</button>
			
			<ul role="menu" class="dropdown-menu dropdown-menu-right">

				<li v-if="$store.getters.me.id === post.attributes.user_id" role="presentation">
					<a v-on:click="deletePost()" role="menuitem">Delete</a>
				</li>

				<!--<li role="presentation">
					<a href="#" role="menuitem">Button 2</a>
				</li>-->

			</ul>
		</div>

  </div>
</template>

<style scoped>
.text {
	margin-left: 1em;
}
.panel-buttons {
	margin-bottom: auto;
}
.post-details {
	padding: 0.5em 0 0.5em 0.5em;
	display: flex;
  flex:1;
}
.left {
	text-align: center;
	width: 50px;
  order: 1;
}
.mid {
	flex: 1;
  order: 2;
}
.right {
	position: absolute;
	right: 0.5em;
}
.clickable {
	cursor: pointer;
}
</style>

<script>
import Drawing from './Drawing.vue';
import Textbox from './Textbox.vue';
export default {
	name: 'attachments',
	props: ['post'],
	components: {
		Drawing,
		Textbox
	},
	methods: {
		deletePost() {
			this.checkLoggedInElse(
			"You must be logged in to delete a post.",
				() => axios({
					method: 'delete',
					url: '/api/post/' + this.post.id
				}).then(response => {
					this.$store.dispatch('deletePost', this.post);
				}).catch(error => {
					console.log(error);
					this.$store.dispatch('error', error);
				})
			)
		},
		reply() {
			this.checkLoggedInElse(
				"You must be logged in to reply.",	
				() => this.$emit('reply')
			);
		},
		checkLoggedInElse(message, callback) {
      if (!this.$store.getters.me) {
        this.$store.dispatch('error', {
          message: message,
          redirect: this.$store.getters.loginRoute
        });
      } else {
				callback();
			}
    }
	},
	mounted() {
		switch (this.post.attributes.attachment) {
			case 'text':
				break;
			case 'drawing':
				this.$refs.myDrawing.renderDataUrl(this.post.attributes.drawing);
				break;
			default:
				break;
		}
	}
}
</script>


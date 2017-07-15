<template>
  <div class="details">

		<!-- Left Side -->
		<div class="leftist">
			<router-link :to="'/u/' + this.post.relationships.user.attributes.slug">
				<img 
					class="img-circle noselect image-border"
					:src="post.relationships.user.attributes.picture"
					:title="post.relationships.user.attributes.name" 
					width="48"
					height="48"
				>{{ 'id: ' + post.id }}
			</router-link>
			<li class="btn" @click="authorized('upvote')">
				<i :class="[{ 'clicked': liked}, 'glyphicon glyphicon-menu-up']"></i>
			</li>
			<span>{{ score }}</span>
			<li class="btn" @click="authorized('downvote')">
				<i :class="[{ 'clicked': disliked }, 'glyphicon glyphicon-menu-down']"></i>
			</li>
		</div>
		
		<!-- Right Mid Side -->
		<div class="mid">
			<router-link class="text" :to="'/u/' + this.post.relationships.user.attributes.slug">
				<span><strong>{{ this.post.relationships.user.attributes.name }}</strong></span>
			</router-link>
			<span class="text">/u/{{ this.post.relationships.user.attributes.slug }}</span>
			<!--<span class="text">{{ this.post.attributes.created_at }}</span>-->

			<!-- Post Content -->
			<div class="clickable post-content">
				<Textbox      v-if="post.attributes.attachment === 'text'" :post="post"></Textbox>
				<Drawing v-else-if="post.attributes.attachment === 'drawing'" :post="post"></Drawing>
				<Linkbox v-else-if="post.attributes.attachment === 'url'" :post="post"></Linkbox>
			</div>

			<!-- Buttons -->
			<div class="button-bar">
				<button class="btn" data-toggle="modal" data-target="#postModal" @click="authorized('reply')">
					<i class="glyphicon glyphicon-share-alt reply"></i>
				</button>{{ post.attributes.replies_count || 0 }}&nbsp;

				<button class="btn" @click="authorized('resend')">
					<i class="glyphicon glyphicon-repeat"></i>
				</button>{{ post.attributes.resend_count || 0 }}&nbsp;
			</div>
		</div>

  </div>
</template>

<script>
import Drawing from './Drawing.vue';
import Textbox from './Textbox.vue';
import Linkbox from './Linkbox.vue';
export default {
	name: 'attachments',
	props: ['post'],
	components: {
		Drawing,
		Textbox,
		Linkbox
	},
	computed: {
		me() {
			return this.$store.getters.me
		},
		score() {
			return this.post.attributes.likes_count - this.post.attributes.dislikes_count || 0;
		},
		userHasLiked() {
			return (this.post.relationships.likes);
		},
		liked() {
			return this.userHasLiked && this.post.relationships.likes[0].relationships.pivot.attributes.type == 1;
		},
		disliked() {
			return this.userHasLiked && this.post.relationships.likes[0].relationships.pivot.attributes.type == 0;
		}
	},
	methods: {
		authorized(action) {
      (this.me) ?
				this[action]() :
				this.$router.push({ name: 'settings' });
    },
    myPost() {
      return this.me.id === this.post.attributes.user_id;
    },
		reply() {
			if (this.$store.getters.replying === this.post.id)
				this.$store.dispatch('toggleReplying', null);
			else
				this.$store.dispatch('toggleReplying', this.post.id);
		},
		resend() {
			alert("tba");	
		},
		upvote() {
			this.$store.dispatch('like', {
				id: this.post.id,
			});
		},
		downvote() {
			this.$store.dispatch('dislike', {
				id: this.post.id,
			});
		}
	}
}
</script>

<style scoped>
.button-bar {
	margin-top: auto;
}
.post-content {
	margin: 0.5em 0.5em 0 0;
	font-size: initial;
	word-wrap: break-word;
}
.clicked {
	font-weight: bold;
	font-size: larger;
	color: #2baf43 !important;
}
</style>
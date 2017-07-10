<template>
  <div class="details">

		<div class="leftist">
			<router-link :to="'/u/' + this.post.relationships.user.attributes.slug">
				<img 
					class="img-circle noselect image-border"
					:src="post.relationships.user.attributes.picture"
					:title="post.relationships.user.attributes.name" 
					width="48"
					height="48"
				>
			</router-link>
			<li class="btn" @click="upvote()">
				<i :class="[{ 'clicked': liked}, 'glyphicon glyphicon-menu-up']"></i>
			</li>
			<span>{{ score }}</span>
			<li class="btn" @click="downvote()">
				<i :class="[{ 'clicked': disliked }, 'glyphicon glyphicon-menu-down']"></i>
			</li>
		</div>
		
		<div class="mid">
			<router-link class="text" :to="'/u/' + this.post.relationships.user.attributes.slug">
				<span><strong>{{ this.post.relationships.user.attributes.name }}</strong></span>
			</router-link>
			<br>
			<span class="text">/u/{{ this.post.relationships.user.attributes.slug }}</span>
			<!--<span class="text">{{ this.post.attributes.created_at }}</span>		-->

			<!-- Post Content -->
			<div class="clickable post-content" @click="clickGotoPost()">
				<Textbox      v-if="post.attributes.attachment === 'text'" :text="post.attributes.text"></Textbox>
				<Drawing v-else-if="post.attributes.attachment === 'drawing'" :post="post"></Drawing>
				<Linkbox v-else-if="post.attributes.attachment === 'url'" :post="post"></Linkbox>
			</div>

			<!-- Buttons -->
			<div class="panel-buttons">
				<button class="btn" @click="reply()"><i class="glyphicon glyphicon-share-alt reply"></i></button> 
				<strong>{{ post.attributes.replies_count || 0 }}</strong>
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
			return this.userHasLiked &&
			this.post.relationships.likes[0].relationships.pivot.attributes.type == 1;
		},
		disliked() {
			return this.userHasLiked && 
			this.post.relationships.likes[0].relationships.pivot.attributes.type == 0;
		}
	},
	methods: {
		authorized() {
      return (this.me);
    },
    myPost() {
      return this.me.id === this.post.attributes.user_id;
    },
		reply() {
			if (this.authorized) this.$emit('reply')
			else this.$router.push({ name: 'user' });
		},
		clickGotoPost() {
			window.scrollTo(0, 0);
			this.$router.push({ 
				name: 'post',
				params: { slug: this.post.attributes.slug, id: this.post.id }
			});
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
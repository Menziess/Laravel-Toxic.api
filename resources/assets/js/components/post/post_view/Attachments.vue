<template>
  <div class="details">

		<!-- Left Side -->
		<div class="leftist">
			<img 
				@click="zoomed = true"
				class="img-circle clickable zoomable image-border"
				:src="user.attributes.picture"
				:title="user.attributes.name" 
				width="48"
				height="48"
			>
			<li class="btn" @click="authorized('upvote')">
				<i :class="[{ 'liked': liked}, 'glyphicon glyphicon-menu-up']"></i>
			</li>
			<span>{{ score }}</span>
			<li class="btn" @click="authorized('downvote')">
				<i :class="[{ 'disliked': disliked }, 'glyphicon glyphicon-menu-down']"></i>
			</li>
		</div>

		<!-- Modal -->
    <Modal 
			:show="zoomed"
			:src="user.attributes.picture"
			:title="user.attributes.name" 
		></Modal>
		
		<!-- Right Mid Side -->
		<div class="mid">
			<router-link v-if="user.id != 1" class="text" :to="'/u/' + user.attributes.slug">
				<span><strong>{{ user.attributes.name }}</strong></span>
			</router-link>
			<span v-else><strong>{{ user.attributes.name }}</strong></span>			
			<span v-if="user.id != 1" class="text">/u/{{ user.attributes.slug }}</span>
			<!--<span class="text">{{ this.post.attributes.created_at }}</span>-->

			<!-- Post Content -->
			<div class="clickable post-content">
				<Textbox      v-if="content.attributes.attachment === 'text'" :post="content"></Textbox>
				<Drawing v-else-if="content.attributes.attachment === 'drawing'" :post="content"></Drawing>
				<Linkbox v-else-if="content.attributes.attachment === 'url'" :post="content"></Linkbox>
			</div>

			<!-- Repost Author -->
			<small v-if="repost" style="margin-top: 0.5em;">Resent 
				<router-link v-if="repost.relationships.user.id !== 1" class="text" :to="'/u/' + repost.relationships.user.attributes.slug">
					<strong>{{ repost.relationships.user.attributes.name }}'s</strong>
				</router-link> original
				<router-link class="text" :to="'/t/' + repost.attributes.slug + '/' + repost.id">
					<strong>post</strong>
				</router-link>
			</small>

			<!-- Buttons -->
			<div class="button-bar">
				<button class="btn" data-toggle="modal" data-target="#postModal" @click="reply()">
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
import Modal from '../../utils/Modal';
export default {
	name: 'attachments',
	props: ['post'],
	components: {
		Drawing,
		Textbox,
		Linkbox,
		Modal
	},
	created() {
		if (this.repost)
			this.content = this.repost;
		else this.content = this.post;
		console.log(this.content.relationships.user.id)
	},
	data() {
		return {
			zoomed: false,
			content: null
		}
	},
	computed: {
		me() { return this.$store.getters.me },
		user() { return this.post.relationships.user; },
		score() { return this.post.attributes.likes_count - this.post.attributes.dislikes_count || 0; },
		liked() { return this.userHasLiked && this.post.relationships.likes[0].relationships.pivot.attributes.type == 1; },
		repost() { return this.post.relationships.repost; },
		disliked() { return this.userHasLiked && this.post.relationships.likes[0].relationships.pivot.attributes.type == 0; },
		userHasLiked() { return (this.post.relationships.likes); },
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
			// if (this.submitted) { return false; }
			// this.submitted = true;
			// this.$store.dispatch('create', {
			// 	endpoint: 'api/post',
			// 	post: this.getForm(),
			// }).then(response => {
			// 	this.submitted = false;
			// 	this.$router.push({ name: 'home' });
			// 	window.scroll(0, 0);
			// }).catch(error => {
			// 	this.submitted = false;
			// 	this.$router.push({ name: 'error'});
			// })
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
.liked {
	font-weight: bold;
	font-size: larger;
	color: #2baf43 !important;
}
.disliked {
	font-weight: bold;
	font-size: larger;
	color: #ff4500 !important;
}
</style>
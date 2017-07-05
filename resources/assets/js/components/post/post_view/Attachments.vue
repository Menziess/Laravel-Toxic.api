<template>
  <div class="details">

		<div class="leftist">
			<router-link :to="'/u/' + this.post.relationships.user.attributes.slug">
				<img 
					class="img-circle noselect profile-pic"
					:src="post.relationships.user.attributes.picture"
					:title="post.relationships.user.attributes.name" 
					width="48"
					height="48"
				>
			</router-link>
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
			<div class="clickable" @click="clickGotoPost()">
				<Textbox      v-if="post.attributes.attachment === 'text'" :text="post.attributes.text"></Textbox>
				<Drawing v-else-if="post.attributes.attachment === 'drawing'" ref="myDrawing"></Drawing>
				<p v-else-if="post.attributes.attachment === 'url'">{{ post.attributes.url }}</p>
				<p v-else-if="post.attributes.attachment === 'video'">{{ post.attributes.url }}</p>
				<p v-else-if="post.attributes.attachment === 'image'">{{ post.attributes.url }}</p>
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
export default {
	name: 'attachments',
	props: ['post'],
	components: {
		Drawing,
		Textbox
	},
	data() {
		return {
			me: null
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
		}
	},
	mounted() {
		this.me = this.$store.getters.me;
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
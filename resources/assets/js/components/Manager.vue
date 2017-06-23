<template>
  <div>

		<!-- Posts -->
		<div v-if="posts.length > 0">
			<Post v-for="post in posts"
					:key="post.id"
					:post="post"
			>
			</Post>
		</div>

		<!-- Empty State -->
		<div v-else>
			<h3 class="text-center landing">There doesn't seem to be anything here... Be the first one to make a post 😉</h3>
		</div>

  </div>
</template>

<script>
  import Post from './post/Post.vue';
  export default {
    name: 'manager',
    props: ['json'],
    components: {
      Post
    },
    data() {
			return {
				posts: [

				]
			}
    },
    methods: {
      
    },
    mounted() {
			this.posts = JSON.parse(this.json);
    }
  }
</script>
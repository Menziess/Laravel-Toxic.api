<template>
  <div>

		<!-- Loading -->
		<div v-if="loading">
			<h3 class="text-center" style="margin-top: 10vw;">Loading posts...</h3>
		</div>

		<!-- Error -->
    <div v-if="error">
      <h3 class="text-center text-danger" style="margin-top: 10vw;">{{ error }}</h3>
    </div>

		<!-- Empty State -->
		<div v-if="empty">
			<h3 class="text-center" style="margin-top: 10vw;">There doesn't seem to be anything here... Be the first one to make a post 😉</h3>
		</div>

		<!-- Posts -->
		<div v-if="posts.length > 0">
			<Post v-for="post in posts"
					:key="post.id"
					:post="post"
			>
			</Post>
		</div>

  </div>
</template>

<script>
  import Post from './post/Post.vue';
  export default {
    name: 'posts',
    props: ['json'],
    components: {
      Post
    },
    data() {
			return {
				loading: true,
				empty: false,
				error: null,
				posts: [

				]
			}
    },
		watch: {
			'$route': 'fetchData'
		},
		created() {
			this.fetchData();
		},
    methods: {
      fetchData() {
				axios.get('/api/post')
          .then(response => {
						this.posts = response.data.data;
						console.log(response);
          }).catch(error => {
						this.error = response.error.title;
            console.error(error);
          });
				this.loading = false;
				this.empty = this.posts.length === 0;
			}
		}
  }
</script>
<template>
  <div>

		<!-- Subject -->
		<div v-if="slug">
			<h1 class="text-center" style="margin-top: 2vw;">
				<small>/t/</small>
				{{ slug }} {{ id }}
			</h1>
		</div>

		<!-- Loading -->
		<div v-if="loading">
			<h3 class="text-center" style="margin-top: 10vw;">Loading posts...</h3>
		</div>

		<!-- Error -->
    <div v-if="error">
      <h3 class="text-center text-danger" style="margin-top: 10vw;">{{ error }}</h3>
    </div>

		<!-- Posts -->
		<Post v-for="post in posts"
				:key="post.id"
				:post="post"
				v-on:error="displayError"
		></Post>

		<!-- Empty State -->
		<div v-if="posts.length < 1 && loading === false">
			<h3 class="text-center" style="margin-top: 10vw;">There doesn't seem to be anything here... Be the first one to make a post 😉</h3>
		</div>

  </div>
</template>

<script>
  import Post from './post/PostView.vue';
  export default {
    name: 'posts',
    props: ['json', 'slug', 'id'],
    components: {
      Post
    },
		computed: {
			posts() {
				return this.$store.getters.posts;
			}
		},
		watch: {
			'$route': 'init'
		},
    data() {
			return {
				loading: true,
				empty: false,
				error: null
			}
    },
		created() {
			this.init();
		},
    methods: {
			init() {
				if (this.posts.length > 0) {
					this.loading = false;
				} else {
					this.fetchData();
				};
			},
      fetchData() {
				axios.get('/api/post')
          .then(response => {
						this.$store.commit('setInitialPosts', response.data.data);
						this.empty = this.posts.length === 0;
						this.loading = false;
          }).catch(error => {
						this.error = response.error.title;
						this.loading = false;
          });
			},
			displayError(error) {
				this.error = response.error.title;
			}
		}
  }
</script>
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

		<!-- Posts -->
		<div class="row">
			<PostView v-for="post in posts"
					:hidereplies="!slug"
					:key="post.id"
					:post="post"
			></PostView>
		</div>

		<!-- Empty State -->
		<div v-if="posts.length < 1 && loading === false">
			<h3 class="text-center" style="margin-top: 10vw;">There doesn't seem to be anything here... Be the first one to make a post 😉</h3>
		</div>

  </div>
</template>

<script>
  import PostView from './post/PostView.vue';
  export default {
    name: 'posts',
    props: ['slug', 'id'],
    components: {
      PostView
    },
		computed: {
			posts() {
				return this.$store.getters.posts;
			},
		},
		watch: {
			'$route': 'init'
		},
    data() {
			return {
				loading: true,
				empty: false
			}
    },
		created() {
			this.init();
		},
    methods: {
			init() {
				// If id
				if (this.id && this.posts.length > 0 ) {
					// Check if posts contain id
					if (this.onePostContainsId(this.id)) {

					} else {
						this.fetchId();
					}
				}
					
				// If slug
				else if (this.slug && this.posts.length > 0) {
					// Check if posts all contain slug
					if (this.allPostContainsSlug(this.slug)) {

					} else {
						this.fetchSlug();
					}
				}

				// If default
				else {
					this.fetchDefault();
				};
			},
      fetchDefault() {
				axios.get('/api/post')
          .then(response => {
						this.$store.commit('setInitialPosts', response.data.data);
						this.empty = this.posts.length === 0;
						this.loading = false;
          }).catch(error => {
						this.loading = false;
						this.$store.dispatch('error', error);
          });
			},
			fetchSlug() {
				axios.get('/api/post/' + this.slug)
          .then(response => {
						this.$store.commit('setInitialPosts', response.data.data);
						this.empty = this.posts.length === 0;
						this.loading = false;
          }).catch(error => {
						this.loading = false;
						this.$store.dispatch('error', error);
          });
			},
			fetchId() {
				axios.get('/api/post/' + this.id)
          .then(response => {
						this.$store.commit('setInitialPosts', [response.data.data]);
						this.empty = this.posts.length === 0;
						this.loading = false;
          }).catch(error => {
						this.loading = false;
						this.$store.dispatch('error', error);
          });
			},
			allPostContainsSlug(slug) {
				console.log("All posts contain slug.");
				this.posts.every(post => {
					return post.attributes.slug === slug;
				});
			},
			onePostContainsId(id) {
				console.log("One post contains id.");				
				this.posts.find(post => {
					return post.id === id;
				});
			}
		}
  }
</script>
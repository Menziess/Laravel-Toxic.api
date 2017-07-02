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
					:hidereplies="!id"
					:key="post.id"
					:post="post"
			></PostView>
		</div>

		<!-- Empty State -->
		<div v-if="empty">
			<h3 class="text-center" style="margin-top: 10vw;">There doesn't seem to be anything here... Be the first one to make a post 😉</h3>
		</div>

  </div>
</template>

<script>
  import PostView from './post/PostView.vue';
	import store from '../store';
  export default {
    name: 'posts',
    props: ['slug', 'id'],
    components: { PostView },
		watch: { '$route': 'init' },
    data() { return { loading: false } },
		created() { this.init(); },

		computed: {
			posts() {
				// If showing one particular post
				if (this.id) {
					return this.$store.getters.post;
				// If showing particular subject
				} else if (this.slug || this.$store.getters.search) {
					return this.$store.getters.searchPosts;
				}
				// If showing default
				return this.$store.getters.posts;
			},
			empty() {
				return this.posts.length < 1 && this.loading === false;
			}
		},

    methods: {
			init() {
				// If id check if posts contain id
				this.loading = true;
				if (this.id) {
					if (this.posts.length < 1 || this.posts[0].id != this.id) {
						this.fetchId();
					} else {
						this.loading = false;
					}
				}
					
				// If slug check if post contains slug
				else if (this.slug && (this.posts.length < 1 || this.posts[0].attributes.slug != this.slug)) {
					this.fetchSlug();
				}

				// If default
				else if (this.posts.length < 1) {
					this.fetchDefault();
				}

				// App is not loading
				else this.loading = false;
			},
      fetchDefault() {
				axios.get('/api/post')
          .then(response => {
						this.$store.commit('setInitialPosts', response.data.data);
						this.empty = this.posts.length === 0;
						this.loading = false;
          }).catch(error => {
						this.$store.dispatch('error', error);
          });
			},
			fetchSlug() {
				axios.get('/api/post/' + this.slug)
          .then(response => {
						this.$store.commit('setInitialSearchPosts', response.data.data);
						this.empty = this.posts.length === 0;
						this.loading = false;
          }).catch(error => {
						this.$store.dispatch('error', error);
          });
			},
			fetchId() {
				axios.get('/api/post/' + this.id)
          .then(response => {
						this.$store.commit('setInitialPost', [response.data.data]);
						this.empty = this.posts.length === 0;
						this.loading = false;
          }).catch(error => {
						this.$store.dispatch('error', error);
          });
			},
			onePostContainsId(id) {
				this.posts.find(post => {
					return post.id === id;
				});
			}
		}
  }
</script>
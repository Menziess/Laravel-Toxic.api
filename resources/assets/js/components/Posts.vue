<template>
	<div class="col-md-6">

		<!-- Posts -->
		<PostView 
			v-for="post in posts"
			v-if="post.relationships && post.relationships.user" 
			:hidereplies="!atDetail"
			:key="post.id"
			:post="post"
		></PostView>

		<!-- Loading -->
		<Loading v-if="!empty" :loading="loading" message="No more posts"></Loading>

		<!-- Empty State -->
		<div v-if="empty">
			<div class="panel" style="text-align: center;">
				<h3 class="text-center" style="margin: 10vw 0 10vw 0;">There doesn't seem to be anything here... Be the first one to make a post 😉</h3>
			</div>
		</div>
	</div>
</template>

<script>
  import PostView from './post/PostView.vue';
	import Loading from './utils/Loading.vue';
	import store from '../store';
  export default {
    props: ['slug', 'id'],
    components: {
			PostView, 
			Loading 
		},

		watch: { 
			'$route': 'init', 
			'search': 'init',
		},

    data: () => ({ 
			loading: false,
			scrollPos: null
		}),

		mounted() {
			this.init();			
		},

		created() { 
    	window.addEventListener('scroll', this.handleScroll);
		},

		destroyed() {
			window.removeEventListener('scroll', this.handleScroll);
		},

		beforeRouteLeave(to, from, next) {
			let name = this.atSearch ? 'searchPosts' : 'posts';			
			this.$store.dispatch('resetHasMore');
			this.cleanup(name);
			next();
		},

		computed: {
			atHome() {
				return !this.id && !this.slug;
			},
			atSearch() {
				return !this.id && this.slug;
			},
			atDetail() {
				return this.id && this.slug;
			},
			posts() {
				if (this.atDetail) {
					return this.$store.getters.post;
				} else if (this.atSearch) {
					return this.$store.getters.searchPosts;
				} else
				return this.$store.getters.posts;
			},
			empty() {
				return this.posts.length < 1 && this.loading === false;
			}
		},

    methods: {
			handleScroll() {
				if (this.loading || !this.$store.getters.hasMore) return;
				this.scrollPos = document.body.scrollHeight - window.innerHeight - document.body.scrollTop;   
				if (this.scrollPos < 200) {
					this.infiniteScroll();
				}
			},

			/**
			 * Called when this componens is created or recreated to 
			 * fetch initial content from the API.
			 */
			init() {
				if (this.loading) return;
				else this.loading = true;
				if (this.atDetail) {
					if (this.posts.length > 0 && this.posts[0].id === this.id) {
						this.loading = false;
					} else {
						this.$store.commit('replace', { name: 'post', collection: [] });
						this.fetchId();
					}
				}
				else if (this.atSearch && (this.posts.length < 1 || this.posts[0].slug != this.slug)) {
					this.$store.commit('replace', { name: 'searchPosts', collection: [] });
					this.fetchSlug();
				}
				else if (this.posts.length < 1) {
					this.fetchDefault();
				}
				else this.loading = false;
				this.handleScroll();
			},

			/**
			 * Fetching more content where possible.
			 */
			infiniteScroll() {
				if (this.loading) return;
				else this.loading = true;

				if (this.atDetail)
					this.fetchId();
				else if (this.atSearch)
					this.fetchSlug();
				else
					this.fetchDefault();
			},

			/**
			 * Generic fetch methods.
			 */
			api(endpoint, mutation, name) {
				return this.$store.dispatch('fetch', {
					endpoint, mutation, name
				}).then(response => {
					this.empty = this.posts.length === 0;
					this.loading = false;
				}).catch(error => {
					this.$router.push({ name: 'error' });
				});
			},
      fetchDefault() {
				if (this.posts.length > 0)
				this.api('/api/post?amount=14&after=' + this.$store.getters.postsLast.id, 'push', 'posts');
				else
				this.api('/api/post', 'push', 'posts');
			},
			fetchSlug() {
				if (this.posts.length > 0)
				this.api('/api/post/' + this.slug + '?amount=14&after=' + this.$store.getters.searchPostsLast.id, 'push', 'searchPosts');
				else
				this.api('/api/post/' + this.slug, 'push', 'searchPosts');
			},
			fetchId() {
				if (this.posts.length > 0) 
				this.api('/api/post/' + this.slug + '/' + this.id + '?skip=' + this.posts[0].relationships.replies.length + '&amount=14', 'pushReplies', 'post');
				else
				this.api('/api/post/' + this.slug + '/' + this.id, 'push', 'post');
			},
			cleanup(name) {
				this.$store.dispatch('cleanup', { 
					name: name
				});
			}
		}
  }
</script>
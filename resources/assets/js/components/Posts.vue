<template>
  <div>

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
			<div v-if="loading">
				<h3 class="text-center" style="margin-top: 10vw;">Loading posts...</h3>
			</div>

			<!-- Empty State -->
			<div v-if="empty">
				<h3 class="text-center" style="margin-top: 10vw;">There doesn't seem to be anything here... Be the first one to make a post 😉</h3>
			</div>
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
		watch: { '$route': 'init', 'search': 'init' },
    data: () => ({ 
			loading: false,
			scrollPos: null
		}),

		created() { 
			this.init();
    	window.addEventListener('scroll', this.handleScroll);
		},

		destroyed() {
			window.removeEventListener('scroll', this.handleScroll);
		},

		beforeRouteLeave(to, from, next) {
			let name = this.atSearch ? 'searchPosts' : 'posts';			
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
			},
			morepages() {
				return true;
				// if (this.id) {
					
				// } else if (this.slug) {

				// }
				// return true;
			}
		},

    methods: {
			handleScroll() {
				if (!this.morepages || this.loading) return;
				this.scrollPos = document.body.scrollHeight - window.innerHeight - document.body.scrollTop;   
				if (this.scrollPos < 120) {
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
					if (this.posts.length < 1 || this.posts[0].id != this.id) {
						this.$store.commit('replace', { name: 'post', collection: [] });						
						this.fetchId();
					} else {
						this.loading = false;
					}
				}
				else if (this.atSearch && (this.posts.length < 1 || this.posts[0].attributes.slug != this.slug)) {
					this.$store.commit('replace', { name: 'searchPosts', collection: [] });
					this.fetchSlug();
				}
				else if (this.posts.length < 1) {
					this.fetchDefault();
				}
				else this.loading = false;
			},

			/**
			 * Fetching more content where possible.
			 */
			infiniteScroll() {
				if (this.loading) return;
				else this.loading = true;

				if (this.atDetail)
					this.fetchIdReplies();
				else if (this.atSlug)
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
				this.api('/api/post', 'push', 'posts');
			},
			fetchSlug() {
				this.api('/api/post/' + this.slug, 'push', 'searchPosts');
			},
			fetchId() {
				this.api('/api/post/' + this.id, 'replace', 'post');
			},
			fetchIdReplies() {
				//@TODO: make endpoint this.api('/api/post/' + this.id + '@TODO', 'replace', 'post');
			},
			onePostContainsId(array, id) {
				return array.find(post => {
					return post.id == id;
				});
			},
			cleanup(name) {
				this.$store.dispatch('cleanup', { 
					name: name
				});
			}
		}
  }
</script>
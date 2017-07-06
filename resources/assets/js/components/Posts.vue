<template>
  <div>

		<div class="col-md-6">

			<!-- Posts -->
			<PostView 
				v-for="post in posts"
				v-if="post.relationships && post.relationships.user" 
				:hidereplies="!id"
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
    data() { 
			return { 
				loading: false,
				scrollPos: null
			} 
		},

		created() { 
			this.init();
    	window.addEventListener('scroll', this.handleScroll);
		},

		destroyed() {
			window.removeEventListener('scroll', this.handleScroll);
		},

		computed: {
			posts() {
				if (this.id) {
					return this.$store.getters.post;
				} else if (this.slug) {
					return this.$store.getters.searchPosts;
				}
				return this.$store.getters.posts;
			},
			empty() {
				return this.posts.length < 1 && this.loading === false;
			},
			notlastpage() {
				return true;
				// if (this.id) {
					
				// } else if (this.slug) {

				// }
				// return true;
			}
		},

    methods: {
			handleScroll() {
				this.scrollPos = document.body.scrollHeight - window.innerHeight - document.body.scrollTop;   
				if (document.body.scrollHeight - window.innerHeight - document.body.scrollTop == 0
					&& this.notlastpage
					// @TODO: check paginator					
				) {
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
				if (this.id) {
					if (this.posts.length < 1 || this.posts[0].id != this.id) {
						this.$store.commit('replace', { name: 'post', collection: [] });						
						this.fetchId();
					} else {
						this.loading = false;
					}
				}
				else if (this.slug && (this.posts.length < 1 || this.posts[0].attributes.slug != this.slug)) {
					this.$store.commit('replace', { name: 'searchPosts', collection: [] });
					this.fetchSlug();
				}
				else if (this.posts.length < 1) {
					this.fetchDefault();
				}
				else this.loading = false;
			},

			infiniteScroll() {
				if (this.loading) return;
				else this.loading = true;
				if (this.id) {
					this.fetchIdReplies();
				} else if (this.slug) {
					this.fetchSlug();
				} 
				else this.fetchDefault();
			},

			/**
			 * Generic fetch methods.
			 */
			fetch(endpoint, mutation, store) {
				return this.$store.dispatch('fetch', {
					endpoint, mutation, store
				}).then(response => {
					this.empty = this.posts.length === 0;
					this.loading = false;
				}).catch(error => {
					this.$router.push({ name: 'error' });
				});
			},
      fetchDefault() {
				this.fetch('/api/post', 'push', 'posts');
			},
			fetchSlug() {
				this.fetch('/api/post/' + this.slug, 'push', 'searchPosts');
			},
			fetchId() {
				this.fetch('/api/post/' + this.id, 'replace', 'post');
			},
			fetchIdReplies() {
				//@TODO: make endpoint this.fetch('/api/post/' + this.id + '@TODO', 'replace', 'post');
			},
			onePostContainsId(array, id) {
				return array.find(post => {
					return post.id == id;
				});
			}
		}
  }
</script>
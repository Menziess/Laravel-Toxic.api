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
				<div class="panel panel-default" style="text-align: center;">
					<img width="100" height="100" src="/img/ticking.gif"></img>
				</div>
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
			this.$store.dispatch('resetHasMore');
			this.cleanup(name);
			this.resetMeta();
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
				else if (this.atSearch)
					this.fetchSlug();
				else
					this.fetchDefault();
			},

			/**
			 * Update meta information in head of page.
			 */
			updateMeta() {
				if (this.posts.length < 1) return;
				const image = this.posts[0].attributes.drawing;
				const text = this.posts[0].attributes.text;
				const title = this.posts[0].attributes.subject;
				if (this.atDetail) {
					if (text) {
						document.querySelector('meta[name="description"]').setAttribute("content", text);
						document.querySelector('meta[property="og:description"]').setAttribute("content", text);
					}
					if (image)
					document.querySelector('meta[property="og:image"]').setAttribute("content", image);
					document.querySelector('meta[property="og:title"]').setAttribute("content", title);
				}
				document.querySelector('meta[property="og:title"]').setAttribute("content", title);
			},
			resetMeta() {
				const text = "Censorship feeds the dirty mind more than the four-letter word itself.";
				const image = window.location.hostname + "/favicons/apple-touch-icon.png";
				const title = "Combating Censorship";
				document.querySelector('meta[name="description"]').setAttribute("content", text);
				document.querySelector('meta[property="og:description"]').setAttribute("content", text);
				document.querySelector('meta[property="og:image"]').setAttribute("content", image);
				document.querySelector('meta[property="og:title"]').setAttribute("content", title);
				document.querySelector('meta[property="og:title"]').setAttribute("content", title);
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
					this.updateMeta();
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
				this.api('/api/post/' + this.id, 'replace', 'post');
			},
			fetchIdReplies() {
				//@TODO: make endpoint this.api('/api/post/' + this.id + '@TODO', 'replace', 'post');
			},
			cleanup(name) {
				this.$store.dispatch('cleanup', { 
					name: name
				});
			}
		}
  }
</script>
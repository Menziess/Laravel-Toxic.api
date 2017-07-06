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
				// If showing one particular post
				if (this.id) {
					return this.$store.getters.post;
				// If showing particular subject
				} else if (this.slug) {
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
			handleScroll() {
				this.scrollPos = document.body.scrollHeight - window.innerHeight - document.body.scrollTop;   
					console.log(this.scrollPos);
				// if (document.body.scrollHeight - window.innerHeight - document.body.scrollTop == -10) {
				if (this.scrollPos < 200) {
					console.log("load");
						// load more data here...
				}
			},
			init() {
				// Protecting rapid init calls
				if (this.loading) return;
				else this.loading = true;

				// If id check if posts contain id
				if (this.id) {
					if (this.posts.length < 1 || this.posts[0].id != this.id) {
						this.$store.commit('replace', { name: 'post', collection: [] });						
						this.fetchId();
					} else {
						this.loading = false;
					}
				}
					
				// If slug check if post contains slug
				else if (this.slug && (this.posts.length < 1 || this.posts[0].attributes.slug != this.slug)) {
					this.$store.commit('replace', { name: 'searchPosts', collection: [] });
					this.fetchSlug();
				}

				// If default
				else if (this.posts.length < 1) {
					this.fetchDefault();
				}

				// App is not loading
				else this.loading = false;
			},
			fetch(endpoint, mutation, store) {
				return this.$store.dispatch('fetch', {
					endpoint, mutation, store
				});
			},
      fetchDefault() {
				this.fetch('/api/post', 'push', 'posts')
          .then(response => {
						this.empty = this.posts.length === 0;
						this.loading = false;
          }).catch(error => {
						this.$router.push({ name: 'error' });
          });
			},
			fetchSlug() {
				this.fetch('/api/post/' + this.slug, 'push', 'searchPosts')
          .then(response => {
						this.empty = this.posts.length === 0;
						this.loading = false;
          }).catch(error => {
						this.$router.push({ name: 'error' });
          });
			},
			fetchId() {
				this.fetch('/api/post/' + this.id, 'replace', 'post')
          .then(response => {
						console.log(this.$store.getters.post);
						this.empty = this.posts.length === 0;
						this.loading = false;
          }).catch(error => {
						this.$router.push({ name: 'error' });
          });
			},
			onePostContainsId(array, id) {
				return array.find(post => {
					return post.id == id;
				});
			}
		}
  }
</script>
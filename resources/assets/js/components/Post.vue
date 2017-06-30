<template>
  <div>

		<!-- Subject -->
		<div v-if="slug">
			<h1 class="text-center" style="margin-top: 2vw;">
				<small>/t/</small>
				{{ slug }} {{ id }}
			</h1>
		</div>

		<!-- Posts -->
		<div class="row">
			<PostView
				:post="post"
				v-if="post"
			></PostView>
		</div>

  </div>
</template>

<script>
  import PostView from './post/PostView.vue';
  export default {
    name: 'post',
    props: ['slug', 'id'],
    components: {
      PostView
    },
		computed: {
			post() {
				return this.$store.getters.post;
			}
		},
		created() {
			this.init();
		},
    methods: {
			init() {
				if (!this.post || this.post.id !== this.id) {
					this.fetchData();
				};
			},
      fetchData() {
				axios.get('/api/post/' + this.id)
          .then(response => {
						this.$store.commit('setPost', response.data.data);
          }).catch(error => {
						this.error = response.error.title;
          });
			}
		}
  }
</script>
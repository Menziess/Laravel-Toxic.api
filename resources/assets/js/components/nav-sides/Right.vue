<template>
  <div class="right">

    <!-- Post Options -->
    <div v-if="showPostOptions" class="row">
      <div class="panel panel-default">
        <div class="panel-body">
          
					<a v-if="showDeletePost"
             v-on:click="deletePost()" role="menuitem"
          >Delete</a>

        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: 'right',
  computed: {

    me() {
      return this.$store.getters.me;
    },
    post() {
      return this.$store.getters.post[0];
    },
    myPost() {
      if (!this.post || !this.me) return;
      return this.me.id === this.post.attributes.user_id;
    },

    /**
     * Only show post options when all buttons are included
     */
    showPostOptions() {
      return this.showDeletePost;
    },
    showDeletePost() {
      return this.myPost 
        && this.$route.name === "post"
        && this.$route.params.id;
    }
  },
  methods: {
    deletePost() {
      if (confirm("Delete post?"))
        axios({
          method: 'delete',
          url: '/api/post/' + this.post.id
        }).then(response => {
          this.$store.dispatch('deletePost', this.post);
        }).catch(error => {
          this.$store.dispatch('error', error);
        });
		}
  }
}
</script>

<style scoped>
.row {
  margin-left: 0 !important;
  margin-right: 0 !important;
}
</style>
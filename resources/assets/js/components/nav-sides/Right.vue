<template>
  <div class="right">

    <!-- Post Options -->
    <div v-if="showPostOptions" class="panel">
      <div class="panel-body">
        
        <!-- Delete Post -->
        <a v-if="showDeletePost"
            v-on:click="deletePost()" role="menuitem"
        >Delete</a>

      </div>
    </div>

    <!-- Login Options -->
    <div v-if="showLoginOptions" class="panel text-center">
      <div class="panel-body">
        
        <!-- Login -->
        <router-link v-if="showLogin" tag="button" class="btn btn-success" to="/settings"
        >Login</router-link>

        <!-- Logout -->
        <a v-if="showUserSettings" role="presentation" class="btn btn-danger" 
          v-on:click.prevent="submitLogout()"
        >Logout</a>

        <form :action="logout" method="POST" style="display: none;" ref="logoutform">
          <input type="hidden" name="_token" :value="$store.getters.csrfToken">
        </form>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: 'right',
  computed: {
    logout() {
      return this.$store.getters.domainExt + 'logout';
    },
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
    },

    /**
     * Only show logout when sitting on settings page
     */
    showLoginOptions() {
      return this.showLogin || this.showUserSettings;
    },
    showLogin() {
      return !this.me && this.$route.name !== 'settings';
    },
    showUserSettings() {
      return this.me && this.$route.name === 'settings';
    }
  },
  methods: {
    submitLogout() {
      this.$refs.logoutform.submit();
    },
    deletePost() {
      if (confirm("Delete post?"))
      this.$store.dispatch('delete', {
        endpoint: '/api/post/' + this.post.id,
        post: this.post,
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
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

    <!-- Login Options -->
    <div v-if="showLoginOptions">
      <div class="panel panel-default">
        <div class="panel-body">
          
          <!-- Login -->
          <a v-if="showLogin" type="button" class="btn btn-success" :href="login" role="menuitem"
          >Login</a>

          <!-- Logout -->
          <a v-if="showUserSettings" role="presentation" class="btn btn-danger" 
            v-on:click.prevent="submitLogout()"
          >Logout</a>

          <!-- Delete Account -->
          <a v-if="showUserSettings" role="presentation" class="btn btn-danger" 
            v-on:click.prevent="deleteUser()"
          >Disable Account</a>

          <form :action="logout" method="POST" style="display: none;" ref="logoutform">
            <input type="hidden" name="_token" :value="crsf_token">
          </form>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: 'right',
  data() {
    return {
      crsf_token: null,
      login: null,
      logout: null,
    }
  },
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
    },

    /**
     * Only show logout when sitting on settings page
     */
    showLoginOptions() {
      return this.showLogin || this.showUserSettings;
    },
    showLogin() {
      return !this.me;
    },
    showUserSettings() {
      return this.me && this.$route.name === 'settings';
    },
    submitLogout() {
      this.$refs.logoutform.submit();
    }
  },
  methods: {
    deletePost() {
      if (confirm("Delete post?"))
      this.$store.dispatch('delete', {
        endpoint: '/api/post/' + this.post.id,
        post: this.post,
      });
		},
    deleteUser() {
      if (confirm("Delete account?"))
      this.$store.dispatch('deleteUser', this.me.id);
		}
  },
  mounted() {
    this.crsf_token = document.head.querySelector('meta[name="csrf-token"]').content;
    this.login = this.$store.getters.loginRoute;
    this.logout = this.$store.getters.logoutRoute;
  }
}
</script>

<style scoped>
.row {
  margin-left: 0 !important;
  margin-right: 0 !important;
}
</style>
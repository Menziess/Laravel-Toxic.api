<template>
  <div>

    <button v-if="me" role="presentation" class="btn"><a role="menuitem" 
      v-on:click.prevent="submitLogout()">Logout</a>
    </button>

    <a v-else type="button" class="btn" :href="login" role="menuitem">Login</a>

    <form :action="logout" method="POST" style="display: none;" ref="logoutform">
      <input type="hidden" name="_token" :value="crsf_token">
    </form>
  </div>
</template>

<script>
export default {
  name: 'settings',
  computed: {
    me() {
      return this.$store.getters.me;
    }
  },
  mounted() {
    this.crsf_token = document.head.querySelector('meta[name="csrf-token"]').content;
    this.login = this.$store.getters.loginRoute;
    this.logout = this.$store.getters.logoutRoute;
  },
  data() {
    return {
      crsf_token: null,
      login: null,
      logout: null,
    }
  },
  methods: {
    submitLogout() {
      this.$refs.logoutform.submit();
    }
  } 
}
</script>

<style>

</style>

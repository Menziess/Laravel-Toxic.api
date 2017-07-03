<template>
  <div>

    <div class="col-md-3">
			<!-- Left Nav -->
			<div class="row">
        <div class="panel panel-default">
          <div class="panel-body">
            <router-link to="/u/">Main</router-link>
          </div>
        </div>
      </div>
		</div>

		<div class="col-md-6">
			<!-- Settings -->
      <div class="row">
        <div class="panel panel-default">
          <div class="panel-body">

            <!-- Logout -->
            <button v-if="me" role="presentation" class="btn"><a role="menuitem" 
              v-on:click.prevent="submitLogout()">Logout</a>
            </button>

            <!-- Login -->
            <a v-else type="button" class="btn" :href="login" role="menuitem">Login</a>

            <!-- Support -->
            <a class="btn-patreon" href="https://www.patreon.com/bePatron?u=4945387" data-patreon-widget-type="become-patron-button">Become a Patron!</a>

            <!-- Logout Form -->
            <form :action="logout" method="POST" style="display: none;" ref="logoutform">
              <input type="hidden" name="_token" :value="crsf_token">
            </form>
          </div>
        </div>
      </div>          
		</div>
  </div>

  <!--<div class="panel panel-default">

  </div>-->
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
.btn-patreon {
  font-family: 'America', sans-serif;
  background-color: #F96854;
  text-transform: uppercase;
  padding: 0.5rem 0.75rem;
  border: 1px solid #F96854;
  color: #FFFFFF !important;
  font-weight: 700;
  transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1);
}
</style>

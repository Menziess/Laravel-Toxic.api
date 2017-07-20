<template>
  <div class="col-md-6">

    <!-- Settings -->
    <div v-if="me" class="panel">
      <div class="panel-body">
        <div class="details">
          <div class="leftist">
            <img 
              class="img-circle noselect image-border"
              :src="me.picture"
              :title="me.name" 
              width="200px"
              height="200px"
            >
          </div>
        </div>
      </div>
    </div>

    <!-- Register -->
    <Register :me="me"></Register>
    
    <!-- Login Options -->
    <Login :me="me"></Login>

    <!-- Social Login -->
    <Social :me="me"></Social>

    <!-- Support -->
    <div class="panel text-center">
      <h3>Like What I Do?</h3>
        
      💬&ensp;<router-link to="/t/feedback/new">Give feedback</router-link>
      <br>
      💖&ensp;<a data-toggle="collapse" data-target="#support">Support me!</a>

      <div class="panel-body">
        <div id="support" class="collapse">
          <hr>
          <p>Become a patreon and support the development and upkeep of this application.</p>
          <hr>
          <a class="btn btn-primary btn-patreon" href="https://www.patreon.com/bePatron?u=4945387" data-patreon-widget-type="become-patron-button">Become a Patron!</a>
        </div>
      </div>
    </div>

    <!-- Deactivate Account -->
    <div v-if="me" class="panel text-center">
      <h3>Disable Account</h3>
      <div class="panel-body">
        <p>If you decide to no longer make use of this app, you may deactivate your account,
          all your information, including posts and profile data will be kept hidden until you login again.</p>
        <hr>
        <a role="presentation" class="btn btn-danger" 
          v-on:click.prevent="deleteUser()"
        >Disable Account</a>
      </div>
    </div>
  </div>
</template>

<script>
import Register from './Register';
import Social from './Social';
import Login from './Login';
export default {
  name: 'settings',
  components: {
    Register,
    Social,
    Login
  },
  computed: {
    me() {
      return this.$store.getters.me;
    },
  },
  methods: {
    deleteUser() {
      if (confirm("Delete account?"))
      this.$store.dispatch('deleteUser', this.me.id);
		}
  }
}
</script>

<style scoped>
.btn-patreon {
  font-family: 'America', sans-serif;
  background-color: #F96854 !important;
  text-transform: uppercase;
  padding: 0.5rem 0.75rem;
  border: 1px solid #F96854;
  color: #FFFFFF !important;
  font-weight: 700;
  transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1);
}
</style>

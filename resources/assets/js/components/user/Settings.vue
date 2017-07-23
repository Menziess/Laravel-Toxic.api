<template>
  <div class="col-md-6">

    <!-- Activate Account -->
    <Activate :me="me"></Activate>

    <!-- Settings -->
    <Picture :me="me"></Picture>

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
      💖&ensp;<a href="https://paypal.me/DevStefanSchenk">Support me!</a>
      <div class="panel-body">
        <!-- -->
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
import Activate from './Activate';
import Picture from './Picture';
import Social from './Social';
import Login from './Login';
export default {
  name: 'settings',
  components: {
    Register,
    Activate,
    Picture,
    Social,
    Login,
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
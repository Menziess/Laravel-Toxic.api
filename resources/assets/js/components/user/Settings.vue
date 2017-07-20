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
      💖&ensp;<a href="https://www.patreon.com/bePatron?u=4945387">Support me!</a>
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
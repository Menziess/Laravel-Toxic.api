<template>
  <div class="col-md-6">

    <!-- Activate Account -->
    <Activate :me="me"></Activate>

    <!-- Settings -->
    <Upload :me="me"></Upload>

    <!-- Login Options -->
    <Login :me="me"></Login>

    <!-- Register -->
    <Register :me="me"></Register>

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
      <h3><a data-toggle="collapse" data-target="#delete-info"><i class="glyphicon glyphicon-info-sign"></i></a> Disable Account</h3>

      <!-- Deactivate Button -->
      <br>
      <a role="presentation" class="btn btn-danger" v-on:click.prevent="deleteUser()">Disable Account</a>

      <!-- More info -->
      <div class="panel-body">
        <div id="delete-info" class="collapse">
          <hr>
          <h4 class="text-left">The following data will be deleted:</h4>
          <ul class="text-left">
            <li><strong>Profile picture:</strong> Your profile picture will be deleted right away.</li>
            <li><strong>Posts:</strong> Unless you reactivate your account, your posts will be deleted after 7 days.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Register from './Register';
import Activate from './Activate';
import Upload from '../utils/Upload';
import Social from './Social';
import Login from './Login';
export default {
  name: 'settings',
  components: {
    Register,
    Activate,
    Upload,
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
<template>
  <div class="navigation">
    <nav class="navbar navbar-default navbar-static-top">
        
      <div class="container">

        <!-- Posts Feed -->
        <router-link to="/" tag="li" class="btn btn-secondary navbar-btn">
          <i class="glyphicon glyphicon-home"></i>
        </router-link>

        <!-- Something else -->
        <router-link to="/landing" tag="li" class="btn btn-secondary navbar-btn">
          <i class="glyphicon glyphicon-heart-empty"></i>
        </router-link>

        <!-- New Post -->
        <button type="button" class="btn btn-success navbar-btn pull-right" 
          data-toggle="modal" data-target="#postModal"
          title="Create a new post" v-on:click="checkLoggedIn()">New</button>

        <!-- Profile Picture -->
        <Picture></Picture>

        <!-- Search Field -->
        <div class="input-group nav-search pull-right">
          <input type="text" class="form-control" placeholder="Search">
        </div>

      </div>
    </nav>
  </div>
</template>

<script>
import Picture from './Picture';
export default {
  name: 'navbar',
  components: {
    Picture
  },
  methods: {
    checkLoggedIn() {
      if (!this.$store.getters.me) {
        this.$store.dispatch('error', {
          message: "You can draw and write, but you have to login in order to post.",
          redirect: this.$store.getters.loginRoute
        });
      }
    }
  }
}
</script>

<style scoped>
nav {
  background-color: rgba(255,255,255,0.9);
  transform: translateZ(0);
  position: fixed;
  width: 100vw;
}
.navigation {
  margin-bottom: 2.1em;
  height: 20px;
}
.nav .open > a, .nav .open > a:hover, .nav .open > a:focus {
  background-color: transparent !important;
}
.nav-search input {
  border-radius: 20px !important;
}
.nav-search {
  display: inline-block;
  margin: 8px 15px;
}
</style>
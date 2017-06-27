<template>
  <div v-show="this.$router.history.current.path !== '/landing'" class="navigation">
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">

        <!-- Posts Feed -->
        <router-link to="/" tag="button" class="btn btn-secondary navbar-btn">
          <i class="glyphicon glyphicon-home"></i>
        </router-link>

        <!-- Something else -->
        <router-link to="/landing" tag="button" class="btn btn-secondary navbar-btn">
          <i class="glyphicon glyphicon-heart-empty"></i>
        </router-link>

        <!-- New Post -->
        <button type="button" class="btn btn-success navbar-btn pull-right" 
          data-toggle="modal" data-target="#newPost"
          title="Create a new post">New</button>

        <!-- Profile Picture -->
        <Picture :currentuser="currentuser" :logout="logout" :login="login"></Picture>

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
  props: ['destination', 'currentuser', 'logout', 'login'],
  mounted() {
    // If new user, destination is set so he must see landing page
    if (this.destination) {
      this.$router.push('/landing');
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
  /*box-shadow: 0 0 23px #95d7a1;*/
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
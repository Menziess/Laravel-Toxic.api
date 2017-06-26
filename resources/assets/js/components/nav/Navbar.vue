<template>
  <div class="navigation">
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">

        <!-- Posts Feed -->
        <router-link to="/" tag="button" class="btn btn-secondary navbar-btn">
          Posts
        </router-link>

        <!-- Something else -->
        <router-link to="/u" tag="button" class="btn btn-secondary navbar-btn">
          Users
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
      this.$router.push('/landing')
    }
  }
}
</script>

<style scoped>
nav {
  background-color: rgba(255,255,255,0.9);
  position: fixed;
  width: 100vw;
}
.navigation {
  margin-bottom: 4em;
  height: 20px;
}
</style>

<template>
  <div class="navigation">

    <!-- New Post Mobile -->
    <router-link :to="newRoute" tag="button" v-if="!this.$store.getters.replying"
      class="btn btn-lg btn-success navbar-btn pull-right mobile-new-button"
      title="Create a new post" v-on:click="checkLoggedIn()">
      <i class="glyphicon glyphicon-plus"></i>
    </router-link>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top"> 
      <div class="container">

        <!-- Posts Feed -->
        <router-link :to="homeRoute" tag="li" class="btn btn-secondary navbar-btn">
          <i class="glyphicon glyphicon-home"></i>&ensp;<span class="mobile-hidden">Home</span>
        </router-link>

        <!-- Something else -->
        <!--<router-link to="/landing" tag="li" class="btn btn-secondary navbar-btn">
          <i class="glyphicon glyphicon-bell"></i>&ensp;<span class="mobile-hidden">Notifications</span>
        </router-link>-->

        <!-- New Post -->
        <router-link :to="newRoute" tag="button" class="btn btn-success navbar-btn pull-right mobile-hidden"
          title="Create a new post" v-on:click="checkLoggedIn()">
          New
        </router-link>

        <!-- Profile Picture -->
        <Picture></Picture>

        <!-- Search Field -->
        <div class="input-group nav-search pull-right">
          <form v-on:submit.prevent="submitSearch()" style="margin: 0; padding: 0;">
            <input type="text" class="form-control" :placeholder="$route.params.slug || 'Search...'" v-model="search">
          </form>
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
  data() {
    return {
      search: null
    }
  },
  computed: {
    homeRoute() {
      return this.$route.name === 'home' ? '/trends' : '/';
    },
    newRoute() {
      return this.$route.name === 'new' ? '/' : 
        this.$route.params.slug ? '/t/' + this.$route.params.slug + '/new' : '/t/general/new';
    }
  },
  methods: {
    submitSearch() {
      alert(this.search);
    },
    checkLoggedIn() {
      if (!this.$store.getters.me) {
        this.$store.dispatch('error', "You can draw and write, but you have to login in order to post.");
        this.$router.push({ name: 'error' });
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
  width: 12em;
  border-radius: 20px !important;
  text-transform: capitalize;
}
.nav-search {
  display: inline-block;
  margin: 8px 15px;
}
.mobile-new-button {
  position: fixed;
  bottom: 0;
  right: .5em;
  z-index: 999;
  background-color: rgba(255,255,255,0.98) !important;
  border-radius: 50%;
  height: 3em;
  width: 3em;
  box-shadow: 0px 3px 35px rgba(0, 0, 0, 0.15);
  -moz-box-shadow: 0px 3px 35px rgba(0, 0, 0, 0.15);
  -webkit-box-shadow: 0px 3px 35px rgba(0, 0, 0, 0.15);
  outline: none;
}
</style>
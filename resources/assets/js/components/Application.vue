<template>
  <div class="application">
    <!-- Application -->
    <div v-if="error" class="error">

      <div v-if="typeof error === 'string' || error instanceof String" class="alert alert-success" role="alert">
        {{ error }}
        <li class="inline pull-right" v-on:click="clearError()">
          <i class="glyphicon glyphicon-remove"></i>
        </li>
      </div>

      <div v-else-if="error.redirect" class="alert alert-success" role="alert">
        {{ error.message }}
        <li class="inline pull-right" v-on:click="clearError()">
          <i class="glyphicon glyphicon-remove"></i>
        </li>
        <br><br>
        <button class="btn btn-success" v-on:click="redirect(error.redirect)">
          Continue
        </button>
      </div>

      <div v-else class="alert alert-danger" role="alert">
        {{ error.name }}: {{ error.message }}
        <br><br>
        <button class="btn btn-warning" data-toggle="collapse" data-target="#stack">
          <i class="glyphicon glyphicon-wrench"></i>
        </button>
        <button class="btn btn-success" v-on:click="clearError()">
          <i class="glyphicon glyphicon-ok"></i>
        </button>
      </div>

      <div id="stack" class="collapse">
        <p v-if="error.stack">{{ error.stack }}</p>
        <p v-else>{{ error }}</p>
      </div>
    </div>
    
  </div>
</template>

<script>
export default {
  name: 'application',
  props: ['me', 'login', 'logout', 'destination'],
  computed: {
    error() {
      return this.$store.getters.error;
    }
  },
  methods: {
    redirect(url) {
      this.clearError();
      window.location.replace(url);
    },
    clearError() {
      this.$store.dispatch('error', null);
    },
    valid(value) {
      return (value && value != undefined && value != "undefined");
    }
  },
  mounted() {
    const store = this.$store;
    this.error = store.getters.error;

    if (this.valid(this.me)) store.dispatch('setMe', this.me);

    if (this.valid(this.login)) store.dispatch('setLogin', this.login);

    if (this.valid(this.logout)) store.dispatch('setLogout', this.logout);

    // Contains a redirect, should be at the bottom of mounted
    if (this.valid(this.destination)) {
      if (this.$store.getters.me) {
      // If logged in, redirect to the page where user came from
      } else {
      // Else, redirect to landing page, because the user is new
        store.dispatch('setDestination', this.destination);
        this.$router.push({ name: 'landing' });
      }
    }
  }
}
</script>

<style scoped>
i:hover {
  color: black;
}
.application {
  position: fixed;
  z-index: 9999;
  width: 55vh;
  left: 50%;
  top: 20%;
}
.error {
  position: relative;
  left: -50%;
}
.collapse {
  background-color: #272822;
  color: #F92672;
}
</style>
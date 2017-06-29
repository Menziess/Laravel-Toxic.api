<template>
  <div class="application">
    <!-- Application -->
    <div v-if="error" class="error">

      <div v-if="typeof error === 'string' || error instanceof String" class="alert alert-success" role="alert">
        {{ error }}
        <li class="inline pull-right" v-on:click="$store.dispatch('error', null)">
          <i class="glyphicon glyphicon-remove"></i>
        </li>
      </div>

      <div v-else class="alert alert-danger" role="alert">
        {{ error.name }}: {{ error.message }}
        <br><br>
        <button class="btn btn-warning" data-toggle="collapse" data-target="#stack">
          <i class="glyphicon glyphicon-wrench"></i>
        </button>
        <button class="btn btn-success" v-on:click="$store.dispatch('error', null)">
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
  props: ['me', 'destination'],
  computed: {
    error() {
      return this.$store.getters.error;
    }
  },
  mounted() {
    const store = this.$store;
    this.error = store.getters.error;
    if (typeof this.me !== 'undefined') {
      store.dispatch('setMe', this.me);
    }
    if (this.destination !== 'undefined') {
      store.dispatch('setDestination', this.destination);
      this.$router.push('/landing');
    }
  }
}
</script>

<style scoped>
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
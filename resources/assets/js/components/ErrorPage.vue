<template>
  <div class="col-md-6">

    <!-- Error -->
    <div class="panel">
      <div class="panel-body" v-if="error">
        <h1>Error</h1>

        <div v-if="typeof error === 'string'">
          {{ error }}
        </div>
        <div v-else>
          {{ error.message }}
        </div>

        <div v-if="me && me.slug === 'stefan-schenk'">
          <hr>
          <div v-if="error.response">
            <span v-html="error.response.data"></span>  
          </div>
        </div>

        <a v-on:click="$router.go(-1)">
          Back
        </a>
      </div>

      <!-- 404 -->
      <div class="panel-body" v-else>
        <h1>404</h1>
        <p>
          Page not found...
        </p>
        <a v-on:click="$router.go(-1)">
          Back
        </a>
      </div>
    </div>

    <!-- Feedback -->
    <div v-if="me" class="panel text-center">
      <div class="panel-body">
        <h3>🔨💀🔧
        <br><br>Let me know what went wrong.</h3>
        <p>I can read error reports all day, but sometimes it's more usefull to know what actually happened! Thank you.</p>
        <hr>
        <router-link to="/t/feedback/new" tag="button" class="btn btn-warning" role="menuitem">Give Feedback</router-link>
      </div>
    </div>


  </div>
</template>

<script>
export default {
  name: 'errorpage',
  computed: {
    error() {
      return this.$store.getters.error;
    },
    me() {
      return this.$store.getters.me;
    }
  }
}
</script>
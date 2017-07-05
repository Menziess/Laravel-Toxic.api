<template>
  <div class="col-md-6">
    <div class="panel panel-default">

      <!-- Error -->
      <div class="panel-body" v-if="error">
        <h1>Error</h1>

        <div v-if="typeof error === 'string'">
          {{ error }}
        </div>

        <div v-else-if="me.slug === 'stefan-schenk'">
          {{ error.name }}: {{ error.message }}
          <hr>
          <div v-if="error.stack">
            {{ error.stack }}
          </div>
          <div v-else>
            {{ error }}
          </div>
        </div>

        <div v-else>
          {{ error.message }}
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
  },
  watch: {
    error() {
      this.$router.push({ name: 'error' });
    }
  }
}
</script>
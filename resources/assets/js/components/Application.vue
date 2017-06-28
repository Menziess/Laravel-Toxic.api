<template>
  <div>
    <!-- Application -->
    <div v-if="error" class="error panel panel-footer">
      <i class="text-danger">{{ error }}</i>
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
    store.dispatch('setError', this.me);
    if (this.me != 'undefined') {
      store.dispatch('setMe', this.me);
    }
    if (this.destination != 'undefined') {
      store.dispatch('setDestination', this.destination);
      this.$router.push('/landing');
    }
  }
}
</script>

<style scoped>
.error {
  bottom: 0;
  position: absolute;
  z-index: 9999;
}
</style>
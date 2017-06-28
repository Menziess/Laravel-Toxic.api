<template>
  <div>
    <!-- Application -->
  </div>
</template>

<script>
export default {
  name: 'application',
  props: ['me', 'destination'],
  mounted() {
    const store = this.$store;
    if (this.me != 'undefined') {
      store.commit('setMe', this.me);
    }
    if (this.destination != 'undefined') {
      store.commit('setDestination', this.destination);
      this.$router.push('/landing');
    }
  }
}
</script>

<style scoped>
div {
  display: none;
}
</style>

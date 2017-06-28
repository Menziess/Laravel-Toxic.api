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
    if (this.me) store.commit('setMe', this.me);
    if (this.destination) {
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

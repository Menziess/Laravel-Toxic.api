<template>
  <div>
    <!-- Application -->
  </div>
</template>

<script>
export default {
  name: 'application',
  props: ['me', 'login', 'logout', 'destination', 'topics'],
  methods: {
    valid(value) {
      return (value && value != undefined && value != "undefined");
    }
  },
  mounted() {
    const store = this.$store;

    if (this.valid(this.me)) store.dispatch('setMe', this.me);

    if (this.valid(this.login)) store.dispatch('setLogin', this.login);

    if (this.valid(this.logout)) store.dispatch('setLogout', this.logout);

    if (this.valid(this.topics)) store.dispatch('setTopics', this.topics);

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
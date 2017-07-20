<template>
  <div>
    <!-- Application -->
  </div>
</template>

<script>
export default {
  name: 'application',
  props: ['me', 'sessions', 'destination', 'topics'],
  methods: {
    valid(value) {
      return (value && value != undefined && value != "undefined");
    }
  },
  mounted() {
    const store = this.$store;

    let domain_ext = document.head.querySelector('meta[name="domain_ext"]').content;
    if (domain_ext === '/') domain_ext = '';
    store.dispatch('setDomainExt', domain_ext);

    let csrf_token = document.head.querySelector('meta[name="csrf-token"]').content;
    if (csrf_token) store.dispatch('setCsrfToken', csrf_token);

    if (this.valid(this.sessions)) store.dispatch('setSessions', this.sessions);

    if (this.valid(this.me)) store.dispatch('setMe', this.me);

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
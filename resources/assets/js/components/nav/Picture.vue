<template>
  <div class="dropdown pull-right">

    <router-link :to="pictureRoute" class="navbar-brand">
      <span v-if="me && !me.confirmed" class="badge">!</span>
      <img v-if="me" class="img-circle noselect profile-pic"                     
        :src="me.picture"
        :title="me.name"
        alt="Profile picture">


      <span v-else title="Register / Login"><svg class="img-circle noselect image-border profile-pic"/></span>
    </router-link>

  </div>
</template>

<script>
export default {
  name: 'picture',
  computed: {
    me() {
      return this.$store.getters.me;
    },
    pictureRoute() {
      return this.$route.name === 'settings' ? '/' : '/settings';
    }
  } 
}
</script>

<style scoped>
.navbar-brand {
  padding: 14px 15px;
}
.badge {
  background-color: orangered;
  position: absolute;
  left: -6px;
  top: 25px;
}
</style>

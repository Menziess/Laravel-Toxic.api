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
.badge {
  animation: updown 3s infinite ease-in-out;
  background-color: orangered;
  position: absolute;
  right: 40px; 
  top: 25px;
}
@keyframes updown {
  0% { transform: translateY(-2px); }
  50% { transform: translateY(2px); }
  100% { transform: translateY(-2px); }
}
</style>

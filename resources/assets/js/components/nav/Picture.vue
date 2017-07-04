<template>
  <div class="dropdown pull-right">

    <router-link to="/settings" class="navbar-brand">
      <img v-if="me" class="img-circle noselect profile-pic-nav"                     
        :src="me.picture"
        :title="me.name"
        alt="Profile picture">

      <span v-else title="Register / Login"><svg class="img-circle noselect profile-pic profile-pic-nav"/></span>
    </router-link>

  </div>
</template>

<script>
export default {
  name: 'picture',
  computed: {
    me() {
      return this.$store.getters.me;
    }
  } 
}
</script>

<style scoped>
.navbar-brand {
  padding: 14px 15px;
}
</style>

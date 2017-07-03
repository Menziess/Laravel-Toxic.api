<template>
  <div>
    Settings

    <li v-if="me" role="presentation"><a role="menuitem" 
      v-on:click.prevent="submitLogout()">Logout</a>
    </li>

    <li v-else role="presentation"><a :href="login" role="menuitem">Login</a></li>

    <form :action="logout" method="POST" style="display: none;" ref="logoutform">
      <input type="hidden" name="_token" :value="crsf_token">
    </form>
  </div>
</template>

<script>
export default {
  name: 'settings'
}
</script>

<style>

</style>

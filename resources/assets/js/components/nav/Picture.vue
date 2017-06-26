<template>
  <div class="dropdown pull-right">
    <a class="navbar-brand" href="#" data-toggle="dropdown" role="button" aria-expanded="false">

      <img v-if="user" class="img-circle noselect profile-pic-nav"                     
        :src="user.picture"
        :title="user.name"
        alt="Profile picture">

      <span v-else title="Register / Login"><svg class="img-circle noselect profile-pic profile-pic-nav"/></span>

    </a>
    
    <ul role="menu" class="dropdown-menu">

      <li v-if="user" role="presentation"><a href="#" role="menuitem" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">Logout</a>
      </li>

      <li v-else role="presentation"><a :href="login" role="menuitem">Login</a></li>

      <form id="logout-form" :action="logout" method="POST" style="display: none;">
        <input type="hidden" name="_token" :value="crsf_token">
      </form>

    </ul>
  </div>
</template>

<script>
export default {
  name: 'picture',
  props: ['currentuser', 'logout', 'login'],
  data() {
    return {
      crsf_token: null,
      user: null
    }
  },
  mounted() {
    this.crsf_token = document.head.querySelector('meta[name="csrf-token"]').content;
    this.user = this.currentuser instanceof Object ? this.currentuser : null;
  }
}
</script>

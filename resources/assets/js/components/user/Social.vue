<template>
  <div v-if="!me" class="panel text-center">
    <h3><a data-toggle="collapse" data-target="#privacy"><i class="glyphicon glyphicon-info-sign"></i></a> Social</h3>
      
    <br>
    <a type="button" class="btn btn-primary facebook" :href="facebookLogin" role="menuitem">Facebook Login</a>
      
    <!-- Privacy -->
    <div class="panel-body">
      <div id="privacy" class="collapse">
        <hr>
        <h4 class="text-left">Why social login?</h4>
        <ul class="text-left">
          <li>Your user profile is automatically created upon logging in.</li>
          <li>You don't have to remember a password.</li>
        </ul>
        <hr>
        <h4 class="text-left">What about my privacy?</h4>
        <ul class="text-left">
          <li><strong>Email:</strong> Like any registration, an email address is used to identify a user.</li>
          <li><strong>Public Profile:</strong> Public profile data is used to create a user profile:
            <ol>
              <li>Profile picture</li>
              <li>First and last name</li>
              <li>Gender</li>              
            </ol>
          </li>
        </ul>
        <hr>
        <p><a href="https://www.facebook.com/help/223184117694507">Facebooks privacy statement</a></p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'social',
  props: ['me'],
  computed: {
    facebookLogin() {
      return this.$store.getters.domainExt + 'login/facebook';
    }
  }
}
</script>

<style scoped>
.facebook {
  background-color: #3B5998 !important;
  color: white !important;
}
.twitter {
  background-color: #55ACEE !important;
  color: white !important;
}
.google {
  background-color: #DD4B39 !important;
  color: white !important;
}
</style>
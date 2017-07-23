<template>
  <div>
    <div v-if="!me" class="panel text-center">
      <h3><a data-toggle="collapse" data-target="#reasons"><i class="glyphicon glyphicon-info-sign"></i></a> Register</h3>

      <!-- Create Account -->
      <br>
      <a type="button" class="btn btn-primary" :href="registerRoute">Create New Account</a>

      <!-- Collapse -->
      <div class="panel-body">
        <div id="reasons" class="collapse">
          <hr>
          <h4 class="text-left">You'll be able to:</h4>
          <ul class="text-left">
            <li>Upvote&emsp;<i class="glyphicon glyphicon-menu-up"></i></li>
            <li>Downvote&emsp;<i class="glyphicon glyphicon-menu-down"></i></li>
            <li>Repost&emsp;<i class="glyphicon glyphicon-repeat"></i></li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  name: 'register',
  props: ['me'],
  computed: {
    registerRoute() {
      return this.$store.getters.domainExt + 'register';
    }
  }
}
</script>
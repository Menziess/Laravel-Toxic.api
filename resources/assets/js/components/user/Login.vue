<template>
  <div>
    <div v-if="!me" class="panel text-center">
      <h3>Login</h3>

      <div class="panel-body">
        <form class="form-horizontal" role="form">

          <!-- Email -->
          <div :class="['input-group', emailError ? 'has-error' : '']">
            <span class="input-group-addon" id="email-addon">email</span>
            <input id="email" type="email" class="form-control" name="email" aria-describedby="email-addon" :value="oldEmail" required autofocus>

            <span class="help-block">
              <strong>{{ emailError }}</strong>
            </span>
          </div>

          <br>

          <!-- Password -->
          <div :class="['input-group', passwordError ? 'has-error' : '']">
            <span class="input-group-addon" id="password-addon">password</span>
            <input id="password" type="password" class="form-control" name="password" aria-describedby="password-addon" required>

            <span v-if="passwordError" class="help-block">
              <strong>{{ passwordError }}</strong>
            </span>
          </div>

          <br>

          <!-- Remember Me -->
          <input hidden type="checkbox" name="remember" checked>

          <!-- Submit -->
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Login</button>
            <br><br>
            <a :href="passwordRequestRoute">Forgot Your Password?</a>
          </div>
        </form>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  name: 'login',
  props: ['me'],
  computed: {
    passwordRequestRoute() {
      return this.$store.getters.domainExt + 'password/reset';
    },
    sessions() {
      return this.$store.getters.sessions;
    },
    emailError() {

    },
    passwordError() {

    },
    oldEmail() {
      
    }
  }
}
</script>

<template>
  <div>
    <div v-if="!me" class="panel text-center">
      <h3>Login</h3>

      <div class="panel-body">
        <form class="form-horizontal" role="form">

          <!-- Email -->
          <div :class="['input-group', emailError && email.length > 0 ? 'has-error' : '']">
            <span class="input-group-addon" id="email-addon">email</span>
            <input id="email" type="email" class="form-control" name="email" 
              aria-describedby="email-addon" v-model="email" required autofocus>
          </div>

          <span class="help-block">
            <strong>{{ emailError }}</strong>
          </span>

          <br>

          <!-- Password -->
          <div :class="['input-group', passwordError && password.length > 0 ? 'has-error' : '']">
            <span class="input-group-addon" id="password-addon">password</span>
            <input id="password" type="password" class="form-control" name="password" 
              aria-describedby="password-addon" required minlength=3 v-model="password">
          </div>

          <span v-if="passwordError" class="help-block">
            <strong>{{ passwordError }}</strong>
          </span>

          <br>

          <!-- Submit -->
          <div class="form-group">
            <button :disabled="disabled" v-on:click="submit()" type="button" class="btn btn-primary">Login</button>
            <br><br>
            <a :href="passwordRequestRoute">Forgot Your Password?</a>
          </div>
        </form>
      </div>

    </div>
  </div>
</template>

<script>
const validEmail = email => /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/
  .test(email);
export default {
  name: 'login',
  props: ['me'],
  data: () => ({
    errors: [],
    submitted: false,
    remember: 'on',
    password: '',
    email: '',
  }),
  computed: {
    passwordRequestRoute() { return this.$store.getters.domainExt + 'password/reset'; },
    passwordError() { return this.password.length < 6; },
    emailError() { return !validEmail(this.email); },
    disabled() { return this.passwordError || this.emailError; },
    sessions() { return this.$store.getters.sessions; }
  },
  methods: {
    submit() {
      if (this.submitted) { return false; }
      this.submitted = true;
      this.$store.dispatch('login', {
        remember: this.remember,
        password: this.password,
        email: this.email
      }).then(
        this.submitted = false
      ).catch(
        error => console.log(error)
      );
    }
  }
}
</script>

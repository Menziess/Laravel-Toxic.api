<template>
  <div>
    <div v-if="!me" class="panel text-center">
      <h3>Login</h3>

      <div class="panel-body">
        <form class="form-horizontal" role="form">

          <!-- Email -->
          <div :class="emailStyle">
            <span class="input-group-addon" id="email-addon">email</span>
            <input id="email" type="email" class="form-control" name="email" 
              aria-describedby="email-addon" v-model="email" required autofocus>
          </div>

          <br>

          <span v-if="emailFeedback" class="help-block">
            <strong>{{ emailFeedback }}</strong>
          </span>

          <br>

          <!-- Password -->
          <div :class="passwordStyle">
            <span class="input-group-addon" id="password-addon">password</span>
            <input id="password" type="password" class="form-control" name="password" 
              aria-describedby="password-addon" required minlength=3 v-model="password">
          </div>

          <br>

          <span v-if="defaultFeedback || passwordFeedback" class="help-block">
            <strong>{{ defaultFeedback || passwordFeedback }}</strong>
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
    errors: null,
    submitted: false,
    remember: 'on',
    password: '',
    email: '',
  }),
  watch: {
    email() { this.errors = null; },
    password() { this.errors = null; }
  },
  computed: {
    passwordStyle() { 
      return {
        'input-group': true,
        'has-error': (this.defaultFeedback || this.passwordFeedback) && !this.passwordError,
        'has-warning': this.passwordError,
      }
    },
    emailStyle() {
      return {
        'input-group': true,
        'has-error': this.emailFeedback && !this.emailError,
        'has-warning': this.emailError,
      }
    },
    defaultFeedback() { if (this.errors && !this.emailFeedback && !this.passwordFeedback) return this.errors.message[0]; },
    passwordFeedback() { if (this.errors && this.errors.hasOwnProperty('password')) return this.errors.password[0]; },
    emailFeedback() { if (this.errors && this.errors.hasOwnProperty('email')) return this.errors.email[0]; },
    passwordRequestRoute() { return this.$store.getters.domainExt + 'password/reset'; },
    passwordError() { return this.password.length < 6 && this.email.length > 0; },
    emailError() { return !validEmail(this.email) && this.email.length > 0; },
    disabled() { return this.passwordError || this.emailError; },
    sessions() { return this.$store.getters.sessions; }
  },
  methods: {
    submit() {
      if (this.submitted) { return false; }
      this.submitted = true;
      axios({
        method: 'post',
        url: 'api/login',
        data: {
          remember: this.remember,
          password: this.password,
          email: this.email
        }
      }).then(response => {
        this.$store.dispatch('setMe', response.data.data[0].attributes);
        this.submitted = false
      }).catch(error => {
        this.errors = error.response.data.data;
        this.submitted = false
      });
    }
  }
}
</script>

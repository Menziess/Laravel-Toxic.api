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

          <span v-if="passwordFeedback" class="help-block">
            <strong>{{ passwordFeedback }}</strong>
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
        'has-error': this.passwordFeedback && !this.passwordError,
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
    passwordFeedback() { if (this.errors && this.errors.hasOwnProperty('password')) return this.errors.password; },
    emailFeedback() { if (this.errors && this.errors.hasOwnProperty('email')) return this.errors.email; },
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
        withCredentials: true,
        method: 'post',
        url: 'login',
        data: {
          remember: this.remember,
          password: this.password,
          email: this.email
        }
      }).then(response => {
        this.$store.dispatch('setMe', response.data);
        this.setApiToken(response.data);
        this.submitted = false;
      }).catch(error => {
        this.errors = this.flattenErrors(error.response.data);
        this.submitted = false;
      });
    },
    setApiToken(user) {
      if (!user.public_token) return Error("Something went wrong during authorization.");
      window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + user.public_token;
      const api_token = document.head.querySelector('meta[name="api_token"]');
      if (api_token) api_token.setAttribute('content', user.public_token);
      this.refreshContent();
    },
    refreshContent() {
      this.$store.dispatch('cleanupAll');
    },
    flattenErrors(object) {
      for (const key in object) {
        if (Array.isArray(object[key]))
        object[key] = object[key][0];
      }
      return object;
    }
  }
}
</script>

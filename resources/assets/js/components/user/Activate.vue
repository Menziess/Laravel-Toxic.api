<template>
  <div v-if="me && !me.confirmed" class="panel text-center">
    <h3><span v-if="me && !me.confirmed" class="badge">!</span> Activate Account</h3>
    <div class="panel-body">
      <p>You haven't activated your account yet, please check your mailbox (spam folder) for your activation mail,
        or click "Resend Activation Email" for a new activation link.</p>
      <hr>
      <a role="presentation" class="btn btn-danger" 
        v-on:click.prevent="resendActivationEmail()"
        :disabled="linkSent"
      >{{ buttonText }}</a>
    </div>
  </div>
</template>

<script>
const DEFAULT_BUTTON = 'Resend Activation Email';
const SENT_BUTTON = 'Activation Email Sent';
const FAIL_BUTTON = 'Something Went Wrong..';
export default {
  name: 'activate',
  props: ['me'],
  data() {
    return {
      linkSent: false,
      buttonText: DEFAULT_BUTTON,
    }
  },
  methods: {
    success() {
      this.linkSent = true;
      this.buttonText = SENT_BUTTON;
    },
    somethingWrong() {
      this.linkSent = true;
      this.buttonText = FAIL_BUTTON;
      setTimeout(() => {
        this.linkSent = false;
        this.buttonText = DEFAULT_BUTTON;
      }, 5000);
    },
    resendActivationEmail() {
      if (this.linkSent) return;
      axios({
        method: 'post',
        url: 'api/verify'
      })
      .then(response => this.success())
      .catch(error => {
        this.somethingWrong()
        console.log(error)
      });
		}
  }
}
</script>

<style scoped>
.badge {
  background-color: orangered;
}
</style>

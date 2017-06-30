<template>
  <div>    
    <div class="container">

      <div class="row" style="margin: 10vw 0 5vw 0;">
        <div class="col-sm-6 col-sm-offset-3">

          <!-- Bad Quote -->
          <blockquote>
            <p>You take the blue pill, the story ends. You wake up in your bed and believe whatever you want to believe.</p>
            <footer>Morpheus</footer>
          </blockquote>

        </div>
      </div>
      
      <div class="row" style="margin: 2vw">
        <div class="button-group text-center">

          <!-- Leave Button -->     
          <div class="text-center inline" style="margin-right: 10vw;">
            <a href="http://www.google.com" class="btn btn-lg btn-primary">Leave</a>
          </div>

          <!-- Enter Button -->
          <div class="text-center inline">
            <a v-on:click="redirectDestination()" class="btn btn-lg btn-danger">
              Continue
            </a>       
          </div>
        </div>
      </div>

      <div class="row" style="margin: 5vw 0 2em 0;">
        <div class="col-sm-6 col-sm-offset-3">
          
          <!-- Good Quote -->
          <blockquote class="blockquote-reverse">
            <p>You take the red pill, you stay in Wonderland, and I show you how deep the rabbit hole goes.</p>
            <footer>Morpheus</footer>
          </blockquote>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'landing',
  methods: {
    redirectDestination() {
      const destination = this.$store.getters.destinationRoute;
      if (destination) {
        this.$store.dispatch('setDestination', '/');
        this.$router.push(destination);
      }
      this.$router.push('/');
    }
  }
}
</script>

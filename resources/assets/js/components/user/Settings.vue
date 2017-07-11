<template>
  <div class="col-md-6">

    <!-- Settings -->
    <div v-if="me" class="panel panel-default">
      <div class="panel-body">
        <div class="details">
          <div class="leftist">
            <img 
              class="img-circle noselect image-border"
              :src="me.picture"
              :title="me.name" 
              width="200px"
              height="200px"
            >
          </div>
        </div>
      </div>
    </div>

    <!-- Support -->
    <div class="panel panel-default">
      <div class="panel-body">
        <p>Become a patreon and support the development and upkeep of this application!</p>
        <hr>
        <a class="btn-patreon" href="https://www.patreon.com/bePatron?u=4945387" data-patreon-widget-type="become-patron-button">Become a Patron!</a>
      </div>
    </div>

    <!-- Deactivate Account -->
    <div v-if="me" class="panel panel-default">
      <div class="panel-body">
        <p>If you decide to no longer make use of this app, you may deactivate your account,
          which will hide your posts and profile information from other users.</p>
        <hr>
        <a role="presentation" class="btn btn-danger" 
          v-on:click.prevent="deleteUser()"
        >Disable Account</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'settings',
  computed: {
    me() {
      return this.$store.getters.me;
    }
  },
  methods: {
    deleteUser() {
      if (confirm("Delete account?"))
      this.$store.dispatch('deleteUser', this.me.id);
		}
  }
}
</script>

<style scoped>
.panel-body {
  text-align: center;
}
.btn-patreon {
  font-family: 'America', sans-serif;
  background-color: #F96854;
  text-transform: uppercase;
  padding: 0.5rem 0.75rem;
  border: 1px solid #F96854;
  color: #FFFFFF !important;
  font-weight: 700;
  transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1);
}
</style>

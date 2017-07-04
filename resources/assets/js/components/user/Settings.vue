<template>
  <div>
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">

          <!-- Support -->
          <a class="btn-patreon" href="https://www.patreon.com/bePatron?u=4945387" data-patreon-widget-type="become-patron-button">Become a Patron!</a>

        </div>
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
  } 
}
</script>

<style>
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

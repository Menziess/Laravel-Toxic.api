<template>
  <div class="col-md-6">
    <div class="panel">
      <div class="panel-body">
        <router-link v-for="topic in topics"
          :key="topic.id"
          :to="'/t/' + topic.slug"
        >
          <strong>{{ topic.subject }}</strong><br>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'trends',
  computed: {
    topics() {
      return this.$store.getters.topics;
    }
  }
}
</script>

<style scoped>
.panel-body {
  text-align: center;
  font-size: x-large;
}
</style>
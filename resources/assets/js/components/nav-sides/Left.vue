<template>
  <div class="left">

    <!-- Popular Topics -->
    <div v-if="showPopularTopics" class="row">
      <div class="panel">
        <div class="panel-body">

          <router-link v-for="topic in topics"
            :key="topic.id"
            :to="'/t/' + topic.slug"
          >
            <strong>{{ topic.subject }}</strong>&ensp;<i>({{ topic.posts_count }})</i><br>
          </router-link>
          <br>
          <router-link to="/trends">more...</router-link>

        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: 'left',
  computed: {
    topics() {
      return this.$store.getters.topics;
    },

    /**
     * Only show popular topics when...
     */
    showPopularTopics() {
      if (!this.$route) return;
      return this.$route.name === "home";
    }
  }
}
</script>

<style scoped>
.row {
  margin-left: 0 !important;
  margin-right: 0 !important;
}
</style>

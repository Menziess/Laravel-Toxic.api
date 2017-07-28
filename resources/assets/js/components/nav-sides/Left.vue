<template>
  <div class="left">

    <!-- Back Button -->
    <div v-if="atDetail && homeVisited" class="row">
      <div class="panel">
        <div class="panel-body">
          <a v-on:click="prev()" class="btn-back"><i class="glyphicon glyphicon-arrow-left"></i></a>
        </div>
      </div>
    </div>

    <!-- Popular Topics -->
    <div v-if="atHome" class="row">
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
    atHome() {
      if (!this.$route) return;
      return this.$route.name === "home";
    },
    atDetail() {
      if (!this.$route) return;
      return this.$route.params.id;
    },
    topics() { return this.$store.getters.topics; },
    homeVisited() { return this.$store.getters.posts.length > 0 || this.$store.getters.searchPosts.length > 0; }
  },
  methods: {
    prev() { if (this.homeVisited) this.$router.go(-1); }
  }
}
</script>

<style scoped>
.row {
  margin-left: 0 !important;
  margin-right: 0 !important;
}
.btn-back {
  margin-left: 12px;
}
</style>

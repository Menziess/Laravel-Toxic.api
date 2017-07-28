<template>
  <div class="left">

    <!-- Back Button -->
    <div v-if="atDetail && homeVisited" class="row">
      <button
        class="btn btn-lg btn-success navbar-btn mobile-button"
        title="Back" v-on:click="prev()">
        <i class="glyphicon glyphicon-arrow-left"></i>
      </button>

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
.mobile-button {
  display: none;
  position: fixed;
  bottom: 0;
  left: .5em;
  z-index: 999;
  background-color: rgba(255,255,255,0.98) !important;
  border-radius: 50%;
  height: 3em;
  width: 3em;
  box-shadow: 0px 3px 35px rgba(0, 0, 0, 0.15);
  -moz-box-shadow: 0px 3px 35px rgba(0, 0, 0, 0.15);
  -webkit-box-shadow: 0px 3px 35px rgba(0, 0, 0, 0.15);
  outline: none;
}
</style>

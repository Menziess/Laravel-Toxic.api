<template>
  <div>
    <div class="row">
      <div class="panel panel-default">
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

    <div class="row">
      <div class="panel panel-default">
        <div class="panel-body">
          <a>Test 1</a>
          <br>
          <a>Test 2</a>
          <br>
          <a>Test 3</a>
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
    }
  }
}
</script>

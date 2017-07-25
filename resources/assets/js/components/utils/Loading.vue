<template>
  <div class="panel text-center">
    <img v-if="loading" width="100" height="100" :src="$store.getters.domainExt + '/img/ticking.gif'"></img>
    <h3 v-else class="min-height" v-text="message"></h3>
  </div>
</template>

<script>
export default {
  name: 'loading',
  props: ['loading', 'message']
}
</script>

<style scoped>
.min-height {
  line-height: 3.5em;
  min-height: 100px;
}
</style>

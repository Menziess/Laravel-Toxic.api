<template>
  <div v-if="loading" class="panel text-center">
    <img width="100" height="100" src="/img/ticking.gif"></img>
  </div>
</template>

<script>
export default {
  name: 'loading',
  props: ['loading']
}
</script>

<style scoped>
.min-height {
  line-height: 3.5em;
  min-height: 100px;
}
</style>

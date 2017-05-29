<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">
          <span v-text="title"></span>
        </div>

        <div class="panel-body">
          <Drawing></Drawing>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
  import Drawing from '../draw/Drawing.vue';
  export default {
    name: 'box',
    components: {
      Drawing
    },
    data() {
      return {
        title: 'Box'
      }
    }
  }
</script>

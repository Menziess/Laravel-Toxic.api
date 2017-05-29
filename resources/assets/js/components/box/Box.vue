<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">
          <span v-text="title"></span>
        </div>

        <div class="panel-body">
          
        </div>

      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'box',
    data() {
      return {
        title: 'Box'
      }
    }
  }
</script>

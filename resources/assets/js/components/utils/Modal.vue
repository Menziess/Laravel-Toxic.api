<template>
  <div v-if="show" @click="close()" id="zoom" class="modal fade noselect" role="dialog" ref="modal">
    <img
      class="img-circle zoom"
      :src="src"
      :title="title"
    >
  </div>
</template>

<script>
export default {
  name: 'modal',
  props: ['show', 'src', 'title'],
  updated() {
    $('#zoom').modal('show');
  },
  methods: {
    close() {
      $('#zoom').modal('hide');
      this.$parent.zoomed = false;
    }
  }
}
</script>

<template>
  <canvas ref="myCanvas" v-on:mousemove="putPoint($event)">
    Sorry, your browser sucks.
  </canvas>
</template>

<script>
  export default {
    name: 'drawing',
    data() {
      return {
        context: null,
        endRadius: Math.PI*2,
        rect: null,
        radius: 2,
      }
    },
    methods: {
      putPoint: function(e) {
        this.context.beginPath();
        this.context.arc(
          e.clientX - this.rect.left, 
          e.clientY - this.rect.top, 
          this.radius, 0, this.endRadius);
        this.context.fill();
      }
    },
    mounted () {
      const canvas = this.$refs.myCanvas;
      this.context = canvas.getContext('2d');
      this.rect = canvas.getBoundingClientRect();
    }
  }
</script>

<style scoped>
canvas {
    width: 100%;
}
</style>

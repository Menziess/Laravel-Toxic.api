<template>
  <div class="panel-content">
    <canvas ref="myCanvas"
      class="noselect"
    >
        Sorry, your browser sucks.
    </canvas>
  </div>
</template>

<script>
  export default {
    name: 'drawing',
    data() {
      return {
        canvas: null,
        context: null
      }
    },
    methods: {
      renderDataUrl(drawing) {
        let img = new Image;
        let self = this;
        img.onload = function() {
          self.context.drawImage(img, 0, 0);
        }
        img.src = drawing;
      }
    },
    mounted() {
      this.canvas = this.$refs.myCanvas;

      this.canvas.width  = this.canvas.offsetWidth;
      this.canvas.height = this.canvas.offsetHeight

      this.context = this.canvas.getContext('2d');
    }
  }
</script>

<style scoped>
canvas {
  width: 100%;
  height: 40vh;
}
</style>

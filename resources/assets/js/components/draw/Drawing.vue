<template>
  <canvas ref="myCanvas" :height="height"
    v-on:mousemove="putPoint($event)" 
    v-on:mousedown="start"
    v-on:mouseup="stop"
    v-on:mouseout="stop"
    v-on:mouseover="mouseOver($event)"
    class="noselect"
  >
      Sorry, your browser sucks.
  </canvas>
</template>

<script>
  export default {
    name: 'drawing',
    props: ['height'],  
    data() {
      return {
        context: null,
        startAngle: 0,
        endAngle: 2 * Math.PI,
        dragging: false,
        rect: null,
        radius: 2,
      }
    },
    computed: {
      //
    },
    methods: {
      start: function(e) { 
        this.dragging = true;
        this.putPoint(e);
      },
      stop: function(e) { 
        this.dragging = false; 
        this.context.beginPath();
      },
      mouseOver: function(e) {
        if (e.buttons === 1)
          this.dragging = true;
      },
      putPoint: function(e) {
        if (this.dragging) {  
          let x = (e.pageX - this.rect.left) * this.$refs.myCanvas.width / this.rect.width;
          let y = (e.pageY - this.rect.top) * this.$refs.myCanvas.height / this.rect.height;

          this.context.lineTo(x, y);
          this.context.stroke();
          this.context.beginPath();
          this.context.arc(x, y, this.radius, this.startAngle, this.endAngle);
          this.context.fill();
          this.context.beginPath();
          this.context.moveTo(x, y);
        }
      }
    },
    mounted () {
      const canvas = this.$refs.myCanvas;

      canvas.width  = canvas.offsetWidth;
      canvas.height = canvas.offsetHeight

      this.context = canvas.getContext('2d');
      this.context.lineWidth = this.radius * 2;
      this.rect = canvas.getBoundingClientRect();
    }
  }
</script>

<style scoped>
canvas {
  width: 100%;
  height: auto;
}
</style>

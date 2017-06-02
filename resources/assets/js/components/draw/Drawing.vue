<template>
  <div class="panel-drawing">
    <canvas ref="myCanvas"
      v-on:mouseup="stop"
      v-on:mouseout="stop"
      v-on:mousedown="start"
      v-on:mouseover="mouseOver($event)"
      v-on:mousemove="putPoint($event)" 
      v-bind:class="{ mouseDown: dragging }"
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
        context: null,
        startAngle: 0,
        endAngle: 2 * Math.PI,
        dragging: false,
        rect: null,
        radius: 2,
      }
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
        if (e.buttons === 1) {
          this.dragging = true;
        }
      },
      putPoint: function(e) {
        if (this.dragging) {  
          let x = (e.pageX - this.rect.left) * this.canvas.width / this.rect.width;
          let y = (e.pageY - this.rect.top) * this.canvas.height / this.rect.height;

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
      this.canvas = this.$refs.myCanvas;

      this.canvas.width  = this.canvas.offsetWidth;
      this.canvas.height = this.canvas.offsetHeight

      this.context = this.canvas.getContext('2d');
      this.context.lineWidth = this.radius * 2;
      this.rect = this.canvas.getBoundingClientRect();
    }
  }
</script>

<style scoped>
canvas {
  width: 100%;
  height: 40vh;
}

canvas.mouseDown:hover {
  cursor: pointer;
}
</style>

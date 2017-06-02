<template>
  <canvas ref="myCanvas" 
    v-on:mousemove="putPoint($event)" 
    v-on:mousedown="start"
    v-on:mouseup="stop">
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
      putPoint: function(e) {
        if (this.dragging) {  
          let x = (e.pageX - this.rect.left) * this.$refs.myCanvas.width / this.rect.width;
          let y = (e.pageY - this.rect.top) * this.$refs.myCanvas.height / this.rect.height;

          this.context.lineTo(x, y);
          this.context.stroke();
          this.context.beginPath();
          this.context.arc(x, y, this.radius, 0, this.endRadius);
          this.context.fill();
          this.context.beginPath();
          this.context.moveTo(x, y);
        }
      }
    },
    mounted () {
      const canvas = this.$refs.myCanvas;
      this.context = canvas.getContext('2d');
      this.context.lineWidth = this.radius * 2;
      this.rect = canvas.getBoundingClientRect();
    }
  }
</script>

<style scoped>
canvas {
    width: 100%;
}
</style>

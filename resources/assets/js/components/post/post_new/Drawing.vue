<template>
  <div class="panel-content">
    <canvas ref="myCanvas"

      v-on:mouseup.prevent="stop"
      v-on:mouseout.prevent="stop"
      v-on:mousedown.prevent="start"
      v-on:mousemove.prevent="mousePos($event)" 
      v-on:mouseover="mouseOver($event)"
      
      v-on:touchend.prevent="stop"
      v-on:touchstart.prevent="start"
      v-on:touchmove.prevent="touchPos($event)"
      
      v-bind:class="{ mouseDown: dragging }"
      class="noselect"
    >
        Sorry, your browser sucks.
    </canvas>
  </div>
</template>

<script>
// Get a regular interval for drawing to the screen
window.requestAnimFrame = (function (callback) {
        return window.requestAnimationFrame || 
           window.webkitRequestAnimationFrame ||
           window.mozRequestAnimationFrame ||
           window.oRequestAnimationFrame ||
           window.msRequestAnimaitonFrame ||
           function (callback) {
        window.setTimeout(callback, 1000/60);
           };
})();
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
      hasInput: false,
      x: 0,
      y: 0,
    }
  },
  watch: {
    hasInput() {
      this.$emit('hasInput', true);        
    }
  },
  methods: {
    start(e) {
      if (this.canvas.width === 0) { this.init(); } 
      this.dragging = true;
      this.mousePos(e);
    },
    stop(e) { 
      this.dragging = false; 
      this.context.beginPath();
    },
    mouseOver(e) {
      if (e.buttons === 1) {
        this.dragging = true;
      }
    },
    renderCanvas() {
      if (this.dragging) {  
        this.hasInput = true;

        this.context.lineTo(this.x, this.y);
        this.context.stroke();
        this.context.beginPath();
        this.context.arc(this.x, this.y, this.radius, this.startAngle, this.endAngle);
        this.context.fill();
        this.context.beginPath();
        this.context.moveTo(this.x, this.y);
      }
    },
    draw() {
      requestAnimationFrame(this.draw);
      this.renderCanvas();
    },
    mousePos(e) {
      this.rect = this.canvas.getBoundingClientRect();
      this.x = e.pageX - this.rect.left - window.pageXOffset;
      this.y = e.pageY - this.rect.top - window.pageYOffset;
    },
    touchPos(e) {
      this.rect = this.canvas.getBoundingClientRect();
      this.x = e.touches[0].pageX - this.rect.left - window.pageXOffset;
      this.y = e.touches[0].pageY - this.rect.top - window.pageYOffset;
    },
    getDataUrl() {
      return this.canvas !== 'undefined' ? this.canvas.toDataURL() : null;
    },
    init() {
      this.canvas.width = this.canvas.parentElement.clientWidth;
      this.canvas.height = this.canvas.width / 2.031;
      this.context = this.canvas.getContext('2d');
      this.context.lineWidth = this.radius * 2;
      this.lineJoin = this.context.lineCap = 'round';
      this.draw();
    }
  },
  mounted() {
    this.canvas = this.$refs.myCanvas;
    this.init();
  }
}
</script>

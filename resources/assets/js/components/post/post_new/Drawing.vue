<template>
  <div class="panel-content">
    <canvas ref="myCanvas"

      v-on:mouseup.prevent="stop"
      v-on:mouseout.prevent="stop"
      v-on:mousedown.prevent="start"
      v-on:mousemove.prevent="putPoint($event)" 
      v-on:mouseover="mouseOver($event)"
      
      v-on:touchend.prevent="stop"
      v-on:touchstart.prevent="start"
      v-on:touchmove.prevent="putPoint($event)"
      
      v-bind:class="{ mouseDown: dragging }"
      class="noselect"
      width="522" 
      height="294"
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
        userHasDrawn: false
      }
    },
    watch: {
      'userHasDrawn': 'hasInput'
    },
    methods: {
      hasInput() {
        if (this.hasInput)
          this.$emit('hasInput', true);
        else
          this.$emit('hasInput', false);
      },
      start(e) {
        // Make sure canvas is properly rendered
        if (this.canvas.width === 0) { this.init(); } 
        this.dragging = true;
        this.userHasDrawn = true;
        this.putPoint(e);
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
      putPoint(e) {
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
      },
      getDataUrl() {
        return this.canvas !== 'undefined' ? this.canvas.toDataURL() : null;
      },
      renderDataUrl(drawing) {
        let img = new Image;
        let self = this;
        img.onload = function() {
          this.context.drawImage(img,0,0);
        }
        img.src = drawing;
      },
      init() {
        this.canvas.width = this.canvas.parentElement.clientWidth;
        this.canvas.height = this.canvas.parentElement.clientHeight;

        this.context = this.canvas.getContext('2d');
        this.context.lineWidth = this.radius * 2;
        this.lineJoin = this.context.lineCap = 'round';
        this.rect = this.canvas.getBoundingClientRect();
      }
    },
    mounted() {
      this.canvas = this.$refs.myCanvas;
      this.init();
    }
  }
</script>

<style scoped>
canvas {
  width: 100%;
  height: 56%;
  display: block;
}
canvas.mouseDown:hover {
  cursor: pointer;
}
</style>

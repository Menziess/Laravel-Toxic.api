<template>
  <div class="panel-drawing">
    <canvas ref="myCanvas"
      v-on:mouseup="stop"
      v-on:mouseout="stop"
      v-on:mousedown="start"
      v-on:mouseover="mouseOver($event)"
      v-on:mousemove="putPoint($event)" 
      
      v-on:touchend="stop"
      v-on:touchstart="start"
      v-on:touchmove="putPoint($event)"
      
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
        e.preventDefault();
        this.dragging = true;
        this.putPoint(e);
      },

      stop: function(e) { 
        e.preventDefault();
        this.dragging = false; 
        this.context.beginPath();
        this.loadDataUrl();//TODO
      },

      mouseOver: function(e) {
        if (e.buttons === 1) {
          this.dragging = true;
        }
        console.log("\nDrawing:" + this.dataUrl());
      },

      putPoint: function(e) {
        e.preventDefault();
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

      loadDataUrl: function() { //TODO
        let api_token = localStorage.getItem('api_token');
        axios.get('/toxic.api/public/api/post/1?api_token=' + api_token + '&')
          .then(response => {
            console.log(response);
            let img = new Image;
            img.src = response.data.data.drawing;
            this.context.drawImage(img,0,0);
          }).catch(error => {
            console.log(error);
          });
      
      },

      dataUrl: function() {
        return this.canvas !== 'undefined' ? this.canvas.toDataURL() : null;
      }
    },
    mounted () {
      this.canvas = this.$refs.myCanvas;

      this.canvas.width  = this.canvas.offsetWidth;
      this.canvas.height = this.canvas.offsetHeight

      this.context = this.canvas.getContext('2d');
      this.context.lineWidth = this.radius * 2;
      this.lineJoin = this.context.lineCap = 'round';
      this.rect = this.canvas.getBoundingClientRect();
    }
  }
  // Prevent scrolling when touching the canvas
  document.body.addEventListener("touchstart", function (e) {
    if (e.target == canvas) {
      e.preventDefault();
    }
  }, false);
  document.body.addEventListener("touchend", function (e) {
    if (e.target == canvas) {
      e.preventDefault();
    }
  }, false);
  document.body.addEventListener("touchmove", function (e) {
    if (e.target == canvas) {
      e.preventDefault();
    }
  }, false);
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

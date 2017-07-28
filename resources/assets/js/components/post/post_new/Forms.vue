<template>
  <div v-on:keyup.ctrl.enter="$parent.submit()">

    <!-- Content -->
		<Textbox :text="text" ref="myTextbox"></Textbox>
		<Drawing v-show="drawing" ref="myDrawing" class="panel-separator"></Drawing>
		<Linkbox v-show="linking" ref="myLinkbox" class="panel-separator"></Linkbox>

		<!-- Buttons -->
		<div class="panel-footer">
			<button type="button" v-on:click="toggleDrawing()" class="btn btn-info" v-html="drawButton"></button>
			<button type="button" v-on:click="clearDrawing()" v-if="drawstate === 0" class="btn btn-danger">Delete</button>
			<button type="button" v-on:click="toggleLinking()" class="btn btn-info"><i class="glyphicon glyphicon-paperclip"></i></button>
			&ensp;<span>{{ text.length }} / 170</span>
			<button :disabled="!submitEnabled" v-on:click="$parent.submit()" type="button" class="btn btn-primary pull-right" ref="mySubmit">Post</button>
			<div class="clearfix"></div>
		</div>
  </div>
</template>

<script>
const NOT_DRAWN = -1, DRAWING = 0, DRAWN = 1;
import Drawing from './Drawing.vue';
import Textbox from './Textbox.vue';
import Linkbox from './Linkbox.vue';
export default {
  name: 'forms',
	components: {
		Drawing,
		Textbox,
		Linkbox
	},
	data() {
		return {
			url: '',
			text: '',
			canvas: null,
			wasDrawn: false,

			drawing: false,
			linking: false,
		}
	},
	computed: {
		drawstate() { return this.wasDrawn ? this.drawing ? DRAWING : DRAWN : NOT_DRAWN; },
		drawButton() {
			switch (this.drawstate) {
				case DRAWING: return 'Save'; break;
				case DRAWN: return 'Draw &#10003;'; break;
				default: return 'Draw';
			}
		},
		submitEnabled() { return this.text.length > 0 || this.url.length > 0 || this.wasDrawn; }
	},
	methods: {
		getUrl() { return this.url.length > 0 ? this.url : null; },
		getText() { return this.text; },
		getDrawing() { return this.canvas !== 'undefined' && this.wasDrawn ? this.canvas.toDataURL() : null; },
		clearDrawing() { this.canvas.width = 0; this.wasDrawn = false; this.drawing = false; },
		toggleDrawing() { 
			if (!this.url.length > 0 || confirm("Replace attachment by a drawing?")) {
				this.drawing = !this.drawing; 
				this.linking = false;
				this.url = '';
			}
		},
		toggleLinking() {
			if (!this.wasDrawn || confirm("Replace image by attachment?")) {
				this.linking = !this.linking; 
				this.drawing = false;
				this.clearDrawing();
			}
		}
	}
}
</script>

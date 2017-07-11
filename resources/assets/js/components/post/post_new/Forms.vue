<template>
  <div v-on:keyup.ctrl.enter="$parent.submit()">

    <!-- Textbox -->
		<Textbox v-if="attachment === 'text'" 
			@hasInput="enableSubmit"
			ref="myTextbox" 
			placeholder="Write your reply here..."
		></Textbox>

    <!-- Drawing -->
		<Drawing v-if="attachment === 'drawing'" 
			@hasInput="enableSubmit"
			ref="myDrawing"
		></Drawing>

    <!-- Linkbox -->
		<Linkbox v-if="attachment === 'url'" 
			@hasInput="enableSubmit"
			ref="myLinkbox"
		></Linkbox>	

		<!-- Buttons -->
		<div class="panel-footer">

			<button type="button" v-on:click="attachment = 'text'" class="btn btn-info">
				Write
			</button>

			<button type="button" v-on:click="attachment = 'drawing'" class="btn btn-info">
				Draw
			</button>

			<button type="button" v-on:click="attachment = 'url'" class="btn btn-info">
				<i class="glyphicon glyphicon-paperclip"></i>
			</button>

			<button :disabled="!submitEnabled" v-on:click="$parent.submit()" type="button" class="btn btn-primary pull-right" ref="mySubmit">
				Post
			</button>
			<div class="clearfix"></div>
		</div>
  </div>
</template>

<script>
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
			subject: null,
			submitted: false,
			attachment: "text",
			submitEnabled: false
		}
	},
	watch: {
		attachment() {
			this.enableSubmit(false);
		}
	},
	methods: {
		enableSubmit(enable) {
			this.submitEnabled = enable;
		},
	}
}
</script>

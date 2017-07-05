<template>
	<div v-on:keyup.ctrl.enter="$refs.mySubmit.click()"
		class="panel-separator">
		
		<!-- Contents -->
		<Textbox v-if="attachment === 'text'" 
			@hasInput="enableSubmit"
			ref="myTextbox" 
			placeholder="Write your reply here..."
		></Textbox>

		<Drawing v-if="attachment === 'drawing'" 
			@hasInput="enableSubmit"
			ref="myDrawing"
		></Drawing>

		<!-- Buttons -->
		<div class="modal-footer">

			<button type="button" v-on:click="attachment = 'text'" class="btn btn-info pull-left">
				Write
			</button>

			<button type="button" v-on:click="attachment = 'drawing'" class="btn btn-info pull-left">
				Draw
			</button>

			<button disabled type="button" v-on:click="attachment = 'url'" class="btn btn-info pull-left">
				<i class="glyphicon glyphicon-paperclip"></i>
			</button>

			<button :disabled="!submitEnabled" v-on:click="submit()" type="button" class="btn btn-primary" ref="mySubmit">Post</button>
		</div>
	
	</div>
</template>

<script>
  import Drawing from './post_new/Drawing.vue';
  import Textbox from './post_new/Textbox.vue';
  export default {
    name: 'postreply',
		props: ['post'],
    data() {
      return {
        subject: null,
				submitted: false,
        attachment: "text",
				submitEnabled: false
			}
    },
    components: {
      Drawing,
      Textbox
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
			submit() {
				if (this.submitted) { return false; }
				this.submitted = true;
				axios({
					method: 'post',
					url: '/api/post',
					data: {
						post_id: this.post.id,
						subject: this.post.attributes.subject,
						attachment: this.attachment,
						drawing: this.$refs.myDrawing ? this.$refs.myDrawing.getDataUrl() : null,
						text: this.$refs.myTextbox ? this.$refs.myTextbox.text : null,
						url: null
					}
				}).then(response => {
					const post = response.data.data;
					this.submitted = false;
					this.$emit('submit');
					this.$store.dispatch('addPost', post);
					this.$router.push({
						name: 'post',
						params: {
							slug: this.post.attributes.slug,
							id: this.post.id
						}
					});
					window.scroll(0, 0);
				}).catch(error => {
					this.submitted = false;
					this.$emit('submit');					
					this.$store.dispatch('error', error);
					this.$router.push({ name: 'error' });
				});
			}
		}
  }
</script>
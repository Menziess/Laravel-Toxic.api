<template>
	<div id="postModal" class="modal fade" role="dialog">
		<div v-on:keyup.ctrl.enter="$refs.mySubmit.click()" class="modal-dialog">
			<div class="modal-content">

				<!-- Subject -->				
				<div class="modal-header">
					<input type="text" class="form-control" v-model="subject" maxlength="60"
						:placeholder="this.$route.params.slug || defaultSubject()">
				</div>
				
				<!-- Contents -->
				<Textbox v-if="attachment === 'text'" 
					@hasInput="enableSubmit" 
					ref="myTextbox"
					placeholder="Write your message here..."
				></Textbox>  

				<Drawing v-if="attachment === 'drawing'" 
					@hasInput="enableSubmit" 
					ref="myDrawing"
				></Drawing>

				<Linkbox v-if="attachment === 'url'" 
					@hasInput="enableSubmit" 
					ref="myLinkbox"
					placeholder="www..."
				></Linkbox>				

				<!-- Buttons -->
				<div class="modal-footer">

					<button type="button" v-on:click="attachment = 'text'" class="btn btn-info pull-left">
						Write
					</button>

					<button type="button" v-on:click="attachment = 'drawing'" class="btn btn-info pull-left">
						Draw
					</button>

					<button type="button" v-on:click="attachment = 'url'" class="btn btn-info pull-left">
						<i class="glyphicon glyphicon-paperclip"></i>
					</button>

					<button :disabled="!submitEnabled" v-on:click="submit()" data-dismiss="modal" type="button" class="btn btn-primary" ref="mySubmit">
						Post
					</button>
				</div>
			
			</div>
		</div>
	</div>
</template>

<script>
  import Drawing from './post_new/Drawing.vue';
  import Textbox from './post_new/Textbox.vue';
  import Linkbox from './post_new/Linkbox.vue';
  export default {
    name: 'postmodal',
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
      Textbox,
			Linkbox
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
				this.$store.dispatch('create', {
					endpoint: 'api/post',
					post: this.getForm(),
				}).then(response => {
					this.submitted = false;
					this.$router.push({ name: 'home' });
					window.scroll(0, 0);
				}).catch(error => {
					this.submitted = false;
					this.$router.push({ name: 'error'});
				})
			},
			getForm() {
				return {
					post_id: null,
					subject: this.getSubject(this.subject),
					attachment: this.attachment,
					drawing: this.$refs.myDrawing ? this.$refs.myDrawing.getDataUrl() : null,
					text: this.$refs.myTextbox ? this.$refs.myTextbox.text : null,
					url: this.$refs.myLinkbox ? this.$refs.myLinkbox.url : null
				}
			},
			defaultSubject() {
				switch (this.attachment) {
					case 'drawing':
						return "Drawings";
						break;
					case 'url':
						return "Links";
						break;
					default:
						return "General";
						break;
				}
			},
			getSubject(subject) {
				if (!subject) {
					return this.defaultSubject();
				}
				return subject.replace(/^[a-z0-9-]+$/, ' ');
			}
		}
  }
</script>

<style scoped>
input {
  text-transform: capitalize;
}
</style>
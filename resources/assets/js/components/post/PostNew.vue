<template>
	<div class="col-md-6">
    <div class="panel panel-default" v-on:keyup.ctrl.enter="$refs.mySubmit.click()">

				<!-- Subject -->				
				<div class="panel-heading">
					<div class="input-group">
						<span class="input-group-addon" id="subject-addon">/ t /</span>
						<input type="text" class="form-control" v-model="subject" maxlength="60"
							aria-describedby="subject-addon"
							:placeholder="defaultSubject()">
					</div>
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
				></Linkbox>				

				<!-- Buttons -->
				<div class="panel-footer">

					<button type="button" v-on:click="attachment = 'text'" class="btn btn-info pull-left">
						Write
					</button>

					<button type="button" v-on:click="attachment = 'drawing'" class="btn btn-info pull-left">
						Draw
					</button>

					<button type="button" v-on:click="attachment = 'url'" class="btn btn-info pull-left">
						<i class="glyphicon glyphicon-paperclip"></i>
					</button>

					<button :disabled="!submitEnabled" v-on:click="submit()" type="button" class="btn btn-primary pull-right" ref="mySubmit">
						Post
					</button>
					<div class="clearfix"></div>
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
		created() {
			this.$store.dispatch('toggleReplying', -1);
		},
		destroyed() {
			this.$store.dispatch('toggleReplying', null);
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
				if (this.$route.params.slug) return this.$route.params.slug;
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
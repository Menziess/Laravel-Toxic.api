<template>
	<div id="postModal" class="modal fade" role="dialog">
		<div v-on:keyup.ctrl.enter="$refs.mySubmit.click()" class="modal-dialog">
			<div class="modal-content">

				<!-- Subject -->				
				<div class="modal-header">
					<input type="text" class="form-control" v-model="subject" maxlength="60"
						:placeholder="defaultSubjectName()">
				</div>
				
				<!-- Attachments -->
				<Textbox v-show="attachment === 'text'" ref="myTextbox"></Textbox>  
				<Drawing v-show="attachment === 'drawing'" ref="myDrawing"></Drawing>

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

					<button v-on:click="submit()" data-dismiss="modal" type="button" class="btn btn-primary" ref="mySubmit">Post</button>
				</div>
			
			</div>
		</div>
	</div>
</template>

<script>
  import Drawing from './post_new/Drawing.vue';
  import Textbox from './post_new/Textbox.vue';
  export default {
    name: 'postmodal',
    data() {
      return {
        subject: null,
				submitted: false,
        attachment: "text"
			}
    },
    components: {
      Drawing,
      Textbox
    },
		methods: {
			submit() {
				if (this.submitted) { return false; }
				this.submitted = true;
				axios({
					method: 'post',
					url: '/api/post',
					data: this.getForm()
				}).then(response => {
					const post = response.data.data;
					this.submitted = false;
					this.$store.dispatch('addPost', post);
					this.$router.push({ name: 'home' });
				}).catch(error => {
					this.submitted = false;
					// this.$store.dispatch('error', error);
				});
			},
			getForm() {
				return {
					post_id: null,
					subject: this.getSubject(this.subject),
					attachment: this.attachment,
					drawing: this.$refs.myDrawing.getDataUrl(),
					text: this.$refs.myTextbox.text,
					url: null
				}
			},
			defaultSubjectName() {
				switch (this.attachment) {
					case 'drawing':
						return "Drawings";
						break;
					case 'video':
						return "Videos";
						break;
					case 'image':
						return 'Images';
						break;
					default:
						return "General";
						break;
				}
			},
			getSubject(subject) {
				if (!subject) {
					return this.defaultSubjectName();
				}
				return subject.replace(/[^a-z0-9]/gi,' ');
			}
		}
  }
</script>
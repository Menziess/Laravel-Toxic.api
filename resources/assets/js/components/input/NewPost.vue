<template>
	<!-- Modal -->
	<div id="newPost" class="modal fade" role="dialog">
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

				<div class="modal-footer">
					<button type="button" v-on:click="attachment = 'text'" class="btn btn-info pull-left">
						<span class="glyphicon glyphicon-asterisk"></span>
					</button>
					<button type="button" v-on:click="attachment = 'drawing'" class="btn btn-info pull-left">Draw</button>
					<button disabled type="button" v-on:click="attachment = 'url'" class="btn btn-info pull-left">📎</button>
					<!--<button disabled type="button" v-on:click="attachment = 'video'" class="btn btn-secondary pull-left">Video</button>
					<button disabled type="button" v-on:click="attachment = 'image'" class="btn btn-secondary pull-left">Image</button>-->

					<button v-on:click="submit()" data-dismiss="modal" type="button" class="btn btn-primary" ref="mySubmit">Post</button>
				</div>
			
			</div>
		</div>
	</div>
</template>

<script>
  import Drawing from './children/Drawing.vue';
  import Textbox from './children/Textbox.vue';
  export default {
    name: 'newpost',
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
					data: {
						subject: this.getSubject(this.subject),
						attachment: this.attachment,
						drawing: this.$refs.myDrawing.getDataUrl(),
						text: this.$refs.myTextbox.text,
						url: null
					}
				}).then(response => {
					this.submitted = false;
					this.$store.commit('addPost', response.data.data);
				}).catch(error => {
					this.submitted = false;
					this.$emit('error', error);
				});
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
				// LOL(); // <-- error
				
				if (!subject) {
					return this.defaultSubjectName();
				}
				return subject.replace(/[^a-z0-9]/gi,' ');
			}
		}
  }
</script>
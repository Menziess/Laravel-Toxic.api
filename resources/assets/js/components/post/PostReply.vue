<template>
	<div v-on:keyup.ctrl.enter="$refs.mySubmit.click()">
		
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
						post_id: this.post.id,
						subject: this.post.attributes.subject,
						attachment: this.attachment,
						drawing: this.$refs.myDrawing.getDataUrl(),
						text: this.$refs.myTextbox.text,
						url: null
					}
				}).then(response => {
					const post = response.data.data;
					this.submitted = false;
					this.$store.dispatch('addPost', post); // MAKE SURE ITS TIED TO THE PARENT
				}).catch(error => {
					this.submitted = false;
					this.$store.dispatch('error', error);
				});
			}
		}
  }
</script>
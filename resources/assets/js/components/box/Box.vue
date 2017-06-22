<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">

				<!-- Subject -->
				<div class="panel-heading">
					<input type="text" class="form-control" v-model="subject" maxlength="60"
						:placeholder="defaultSubjectName()">
				</div>

				<!-- Attachments -->
				<Textbox v-show="attachment === 'text'" ref="myTextbox"></Textbox>  
				<Drawing v-show="attachment === 'drawing'" ref="myDrawing"></Drawing>

				<!-- Buttons -->
				<div class="panel-footer">
					<button type="button" v-on:click="attachment = 'text'" class="btn btn-secondary">Write</button>
					<button type="button" v-on:click="attachment = 'drawing'" class="btn btn-secondary">Draw</button>

					<button v-on:click="submit()" type="button" class="btn btn-primary pull-right">Post</button>
					<div class="clearfix"></div>
				</div>     

      </div>
    </div>
  </div>
</template>

<script>
  import Drawing from './children/Drawing.vue';
  import Textbox from './children/Textbox.vue';
  export default {
    name: 'box',
    data() {
      return {
        subject: null,
        attachment: "text"
			}
    },
    components: {
      Drawing,
      Textbox
    },
		methods: {
			submit() {
				let api_token = sessionStorage.getItem('api_token');
				let domain_ext = document.getElementById("domain_ext").content;
				axios({
					headers: { Authorization: 'Bearer ' + api_token },					
					method: 'post',
					url: domain_ext + '/api/post',
					data: {
						subject: this.validateSubject(this.subject),
						attachment: this.attachment,
						drawing: this.$refs.myDrawing.getDataUrl(),
						text: this.$refs.myTextbox.text,
						url: null
					}
				}).then(response => {
					location.reload();
					console.log(response)
				}).catch(error => {
					console.error(error)
				});
			},
			defaultSubjectName() {
				switch (this.attachment) {
					case 'drawing':
						return "Drawings";
						break;
					default:
						return "General";
						break;
				}
			},
			validateSubject(subject) {
				if (!subject) {
					return this.defaultSubjectName();
				}
				return subject.replace(/[^a-z0-9]/gi,' ');
			}
		}
  }
</script>
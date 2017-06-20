<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">

				<div class="panel-heading">
					<input type="text" class="form-control" placeholder="Subject" v-model="subject">
				</div>

				<Drawing v-show="attachment === 0"></Drawing>
				<Textbox v-show="attachment === 1" :maxlength="maxlength"></Textbox>  

				<div class="panel-footer">
					<button type="button" v-on:click="attachment = 0" class="btn btn-secondary">Draw</button>
					<button type="button" v-on:click="attachment = 1" class="btn btn-secondary">Write</button>

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
    name: 'editbox',
    data() {
      return {
				// Max amount of characters for text
        maxlength: 255,

        subject: null,
        attachment: 0
      }
    },
    components: {
      Drawing,
      Textbox
    },
		methods: {
			submit() {
				let api_token = sessionStorage.getItem('api_token');
				axios.post('/toxic.api/public/api/post/', {
					headers: { Authorization: 'Bearer ' + api_token },
					data: {
						subject: this.subject,
						attachment: this.attachment
					}
				}).then(response => {
					console.log(response)
				}).catch(error => {
					throw(error)
				});
			}
		}
  }
</script>
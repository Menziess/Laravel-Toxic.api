<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">

        <!-- Subject -->
        <div class="panel-heading">
            <a :href="slugRoute()">{{ subject }}</a>
        </div>

        <!-- Attachments -->
        <Textbox v-if="attachment === 'text'" :text="text"></Textbox>
        <Drawing v-else-if="attachment === 'drawing'" ref="myDrawing"></Drawing>
        <p v-else-if="attachment === 'url'">{{ url }}</p>
        <p v-else-if="attachment === 'video'">{{ url }}</p>
        <p v-else-if="attachment === 'image'">{{ url }}</p>

        <!-- Buttons -->
        <div class="panel-footer">
          <button v-on:click="deletePost()" type="button" class="btn btn-danger pull-right">Delete</button>
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
    name: 'post',
    props: ['id', 'slug', 'subject', 'attachment', 'drawing', 'text', 'url'],
    components: {
      Drawing,
      Textbox
    },
    methods: {
      deletePost() {
				axios({
					headers: { Authorization: 'Bearer ' + api_token.content },					
					method: 'delete',
					url: domain_ext.content + '/api/post/' + this.id
				}).then(response => {
					location.reload();
					console.error(response)
				}).catch(error => {
					console.error(error)
				});
      },
      slugRoute() {
        return domain_ext.content + '/t/' + this.slug;
      }
    },
    mounted() {
      switch (this.attachment) {
        case 'text':
          break;
        case 'drawing':
          this.$refs.myDrawing.renderDataUrl(this.drawing);
          break;
        default:
          break;
      }
    }
  }
</script>
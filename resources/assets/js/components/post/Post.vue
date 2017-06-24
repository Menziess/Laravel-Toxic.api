<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">

        <!-- Subject -->
        <div class="panel-heading">
            <a :href="slugRoute()">{{ post.subject }}</a>
        </div>

        <!-- Post Details -->
        <PostDetails :username="post.user.name" :userslug="post.user.slug" :userpic="post.user.picture"></PostDetails>
        
        <!-- Post Content -->
        <Textbox      v-if="post.attachment === 'text'" :text="post.text"></Textbox>
        <Drawing v-else-if="post.attachment === 'drawing'" ref="myDrawing"></Drawing>
        <p v-else-if="post.attachment === 'url'">{{ post.url }}</p>
        <p v-else-if="post.attachment === 'video'">{{ post.url }}</p>
        <p v-else-if="post.attachment === 'image'">{{ post.url }}</p>

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
  import PostDetails from './utils/PostDetails.vue';
  import Drawing from './children/Drawing.vue';
  import Textbox from './children/Textbox.vue';
  export default {
    name: 'post',
    props: ['id', 'post'],
    components: {
      PostDetails,
      Drawing,
      Textbox,
    },
    methods: {
      deletePost() {
				axios({
					method: 'delete',
					url: '/api/post/' + this.post.id
				}).then(response => {
					location.reload();
					console.error(response)
				}).catch(error => {
					console.error(error)
				});
      },
      slugRoute() {
        return domain_ext.content + '/t/' + this.post.slug;
      }
    },
    mounted() {
      switch (this.post.attachment) {
        case 'text':
          break;
        case 'drawing':
          this.$refs.myDrawing.renderDataUrl(this.post.drawing);
          break;
        default:
          break;
      }
    }
  }
</script>
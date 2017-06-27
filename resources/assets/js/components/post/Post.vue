<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">

        <!-- Subject -->
        <!--<div class="panel-heading">
            <router-link :to="'/t/' + post.attributes.slug + '/' + post.id">
              <span><strong>{{ post.attributes.subject }}</strong></span>
            </router-link>
        </div>-->

        <!-- Post Details -->
        <PostDetails 
          :username="post.relationships.user.name" 
          :userslug="post.relationships.user.slug" 
          :userpic="post.relationships.user.picture"
          v-on:deletepost="deletePost"
        ></PostDetails>
        
        <!-- Post Content -->
        <Textbox      v-if="post.attributes.attachment === 'text'" :text="post.attributes.text"></Textbox>
        <Drawing v-else-if="post.attributes.attachment === 'drawing'" ref="myDrawing"></Drawing>
        <p v-else-if="post.attributes.attachment === 'url'">{{ post.attributes.url }}</p>
        <p v-else-if="post.attributes.attachment === 'video'">{{ post.attributes.url }}</p>
        <p v-else-if="post.attributes.attachment === 'image'">{{ post.attributes.url }}</p>

        <!-- Post Replies -->
        <Reply v-for="reply in post.relationships.replies"
          :key="reply.id"
          :reply="reply"
        ></Reply>

        <!-- Buttons -->
        <div class="panel-buttons">
          <a class="btn" href="#">
            <i class="glyphicon glyphicon-share-alt" 
              style="transform: scale(1, -1);"></i>
          </a>

          <a class="btn" href="#">
            <i class="glyphicon glyphicon-thumbs-up"></i>
          </a>

          <a class="btn" href="#">
            <i class="glyphicon glyphicon-thumbs-down"></i>
          </a>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
  import PostDetails from './utils/PostDetails.vue';
  import Drawing from './children/Drawing.vue';
  import Textbox from './children/Textbox.vue';
  import Reply from './utils/Reply.vue';
  export default {
    name: 'post',
    props: ['id', 'post'],
    components: {
      PostDetails,
      Drawing,
      Textbox,
      Reply
    },
    methods: {
      deletePost() {
				axios({
					method: 'delete',
					url: '/api/post/' + this.post.id
				}).then(response => {
					this.$store.commit('deletePostById', this.post.id);
				}).catch(error => {
          this.$emit('error', error);
				});
      },
    },
    mounted() {
      switch (this.post.attributes.attachment) {
        case 'text':
          break;
        case 'drawing':
          this.$refs.myDrawing.renderDataUrl(this.post.attributes.drawing);
          break;
        default:
          break;
      }
    }
  }
</script>

<style>
.panel-buttons {
  margin-left: 3.7em;
}
</style>
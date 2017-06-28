<template>
	<div :class="[original ? ['col-md-8', 'col-md-offset-2'] : 'panel-separator']">
		<div :class="[original ? ['panel', 'panel-default'] : '']">
      <div>

        <!-- Subject -->
        <!--<div class="panel-heading">
            <router-link :to="'/t/' + post.attributes.slug + '/' + post.id">
              <span><strong>{{ post.attributes.subject }}</strong></span>
            </router-link>
        </div>-->

        <!-- Post Details -->
        <PostDetails 
          :post="post"
          v-on:error="error"
        ></PostDetails>
        
        <!-- Post Content -->
        <Textbox      v-if="post.attributes.attachment === 'text'" :text="post.attributes.text"></Textbox>
        <Drawing v-else-if="post.attributes.attachment === 'drawing'" ref="myDrawing"></Drawing>
        <p v-else-if="post.attributes.attachment === 'url'">{{ post.attributes.url }}</p>
        <p v-else-if="post.attributes.attachment === 'video'">{{ post.attributes.url }}</p>
        <p v-else-if="post.attributes.attachment === 'image'">{{ post.attributes.url }}</p>

        <!-- Buttons -->
        <div class="panel-buttons">
          <a class="btn" href="#"><i class="glyphicon glyphicon-share-alt reply"></i></a>
          <a class="btn" href="#"><i class="glyphicon glyphicon-thumbs-up"></i></a>
          <a class="btn" href="#"><i class="glyphicon glyphicon-thumbs-down"></i></a>
        </div>

        <!-- Reply Box -->
        <PostNew></PostNew>

        <!-- Post Replies -->
        <PostView v-for="post in post.relationships.replies"
          :key="post.id"
          :post="post"
          modal="false"
        ></PostView>

      </div>
    </div>
  </div>
</template>

<script>
  import PostDetails from './post_view/PostDetails.vue';
  import PostNew from './PostNew.vue';
  import Drawing from './post_view/Drawing.vue';
  import Textbox from './post_view/Textbox.vue';
  export default {
    name: 'PostView',
    props: ['id', 'post'],
    components: {
      PostDetails,
      PostNew,
      Drawing,
      Textbox
    },
    computed: {
      original() {
        return !this.post.attributes.post_id;
      }
    },
    methods: {
      error() {
        console.log("ERROR from PostView");
        console.log(error);
      }
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
.reply {
  transform: scale(1, -1);
}
</style>
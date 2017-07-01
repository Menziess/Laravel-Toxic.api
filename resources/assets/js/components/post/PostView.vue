<template>
	<div :class="[ischild ? 'panel-separator' : ['col-md-8', 'col-md-offset-2']]">
		<div :class="[ischild ? '' : ['panel', 'panel-default']]">
      <div>

        <!-- Subject -->
        <div v-if="!post.attributes.post_id" class="panel-heading">
            <router-link :to="'/t/' + post.attributes.slug + '/' + post.id">
              <strong class="heading-text">/t/{{ post.attributes.subject }}</strong>
            </router-link>
        </div>

        <!-- Attachments -->
        <Attachments 
          :post="post"
          v-on:reply="replying = !replying"
        ></Attachments>

        <!-- Reply Form -->
        <PostReply v-if="replying" 
          :post="post"
          v-on:submit="replying = !replying"
        ></PostReply>

        <!-- Replies -->
        <div v-if="!hidereplies">
        <PostView v-for="post in post.relationships.replies"
          :ischild="true"
          :post="post"
          :key="post.id"
        ></PostView>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
  import Attachments from './post_view/Attachments.vue';
  import PostReply from './PostReply.vue';
  import Drawing from './post_view/Drawing.vue';
  import Textbox from './post_view/Textbox.vue';
  export default {
    name: 'PostView',
    props: ['post', 'hidereplies', 'ischild'],
    components: {
      Attachments,
      PostReply,
      Drawing,
      Textbox
    },
    data() {
      return {
        replying: false
      }
    }
  }
</script>
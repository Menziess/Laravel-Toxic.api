<template>
  <div :class="{ 'panel-separator': child, 
                  'panel panel-default': parent,
                  'new': isNew }
              ">

    <!-- Content -->
    <div :class="{ 'line': conversation && !isconversation, 
                    'line-start line': conversation && isconversation,
                    'line-start': !conversation && isconversation }">

      <div v-if="!ischild && $router.history.current.name === 'home'" class="panel-heading">
        <router-link :to="'/t/' + post.attributes.slug">
          <strong class="heading-text">/t/{{ post.attributes.subject }}</strong>
        </router-link>
      </div>
      <Attachments 
        :post="post"
      ></Attachments>
    </div>

    <!-- Reply Form -->
    <div ref="postreply">
      <PostReply
        v-if="replying === post.id" 
        :post="post"
      ></PostReply>
    </div>

    <!-- Conversations -->
    <div v-if="conversation">
      <PostView v-if="conversation[0].relationships && conversation[0].relationships.user"
        :isconversation="true"
        :post="conversation[0]"
        :key="conversation[0].id"
      ></PostView>
    </div>

    <!-- Replies -->
    <div v-if="!hidereplies">
    <PostView v-for="post in post.relationships.replies"
      :ischild="true"
      :post="post"
      :key="post.id"
    ></PostView>
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
    props: ['post', 'hidereplies', 'ischild', 'isconversation'],
    components: {
      Attachments,
      PostReply,
      Drawing,
      Textbox
    },
    mounted() {
      console.log(this.post);
    },
    watch:  {
      replying() {
        if (this.replying !== this.post.id) return;
      }
    },
    computed: {
      replying() {
        return this.$store.getters.replying;
      },
      conversation() {
        return this.post.relationships.conversation;
      },
      child() {
        return this.ischild && !this.isconversation;
      },
      parent() {
        return !this.ischild && !this.isconversation
      },
      isNew() {
        return this.post.hasOwnProperty('new');
      }
    }
  }
</script>
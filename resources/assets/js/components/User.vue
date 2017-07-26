<template>
  <div class="col-md-6">

    <!-- User Details -->
    <div class="panel">
      <div class="panel-body">
        <h1>{{ $route.params.slug }}</h1>
        <div v-if="user">
          <Picture :title="user.attributes.name" :src="user.attributes.picture"></Picture> 
        </div>
      </div>
    </div>

    <!-- Posts -->
    <div v-if="userHasPosts">
      <PostView v-for="post in user.relationships.posts"
        :hidereplies="true"
        :key="post.id"
        :post="post"
      ></PostView>
    </div>

    <!-- Loading -->
    <Loading :loading="loading"></Loading>

  </div>
</template>

<script>
import PostView from './post/PostView.vue';
import Loading from './utils/Loading.vue';
import Picture from './utils/Picture.vue';
export default {
  name: 'user',
  components: {
    PostView,
    Loading,
    Picture
  },
  data() {
    return {
      loading: false,
      user: null
    }
  },
  created() {
    this.init();
  },
  computed: {
    userHasPosts() {
      if (!this.user) return;
      return this.user.relationships && this.user.relationships.posts;
    }
  },
  methods: {
    init() {
      this.loading = true;
      axios.get('/api/u/' + this.$route.params.slug)
      .then(response => {
        this.user = response.data.data.pop();
        this.loading = false;
      }).catch(error => {
        this.$store.dispatch('error', error);
        this.$router.push({ name: 'error' });
      });
    }
  }
}
</script>

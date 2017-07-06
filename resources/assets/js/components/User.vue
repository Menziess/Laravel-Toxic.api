<template>
  <div>
    <div class="col-md-6">
      <div class="panel panel-default">
        <!-- User Details -->
        <div class="panel-body">
          
          <h1>{{ $route.params.slug }}</h1>
          <hr>
          <div class="details">
            <div v-if="user" class="leftist">
              <img 
                class="img-circle noselect profile-pic"
                :src="user.attributes.picture"
                :title="user.attributes.name" 
                width="200px"
                height="200px"
              >
            </div>
          </div>

          <!-- Loading -->
          <div v-if="loading">
            <h3 class="text-center" style="margin-top: 10vw;">Loading posts...</h3>
          </div>
          
        </div>
      </div>
    </div>

    <!-- Posts -->
    <div class="col-md-6 col-md-offset-3" v-if="userHasPosts">
      <PostView v-for="post in user.relationships.posts"
        :hidereplies="true"
        :key="post.id"
        :post="post"
      ></PostView>
    </div>
  </div>
</template>

<script>
import PostView from './post/PostView.vue';
export default {
  name: 'user',
  components: {
    PostView
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

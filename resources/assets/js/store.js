import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const state = {
  posts: [

  ]
};

const getters = {
  posts: state => {
    return state.posts;
  },
  getPostById: (state, getters) => (id) => {
    return state.posts.find(post => post.id === id);
  },
};

const mutations = {
  setInitialPosts(state, posts) {
    state.posts = posts;
  },
  deletePostById(state, id) {
    let remove = state.posts.map(post => {
      return post.id;
    }).indexOf(id);
    state.posts.splice(remove, 1);
  },
  addPost(state, post) {
    state.posts.unshift(post);
  }
};

export default new Vuex.Store({
  state,
  getters,
  mutations
});
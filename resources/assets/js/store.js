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
  }
};

const mutations = {
  setInitialPosts(state, posts) {
    state.posts = posts;
  }
};

export default new Vuex.Store({
  state,
  getters,
  mutations
});
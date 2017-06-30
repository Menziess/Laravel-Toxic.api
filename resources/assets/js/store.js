import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const find = {
  elementById(array, id) {
    return array.map(element => {
      return element.id;
    });
  },
  indexById(array, id) {
    return find.elementById(array, id)
      .indexOf(id);
  },
  // findParentByChild(array, child) {
  //   if (!child.attributes.post_id) {
  //     return child;
  //   }
  //   let parent = find.elementById(array, child.attributes.post_id)
  //   findParentByChild(array, find)
  // }
}

const state = {
  // Posts
  posts: [

  ],

  // Me
  me: null,
  
  // Routes
  logoutRoute: null,
  loginRoute: null,
  destinationRoute: null,

  //Error
  error: null,
};

const getters = {
  // Posts
  posts: state => { return state.posts; },
  getPostById: (state, getters) => (id) => { return state.posts.find(post => post.id === id); },

  // Me
  me: state => { return state.me; },

  // Routes
  loginRoute: state => { return state.loginRoute; },
  logoutRoute: state => { return state.logoutRoute; },
  destinationRoute: state => { return state.destinationRoute; },

  // Error
  error: state => { return state.error; },
};

const mutations = {
  // Posts
  setInitialPosts(state, posts) { state.posts = posts; },
  deletePostById(state, id) {
    const remove = find.indexById(state.posts, id);
    state.posts.splice(remove, 1);
  },
  addPost(state, post) { state.posts.unshift(post); },
  addReply(state, post) {
    const parentId = post.attributes.post_id;
    const parent = find.elementById(state.posts, parentId);
    console.log(parent);
    parent.relationships.push(post);
  },

  // Me
  setMe(state, me) { state.me = me; },

  // Routes
  setLogin(state, route) { state.loginRoute = route; },
  setLogout(state, route) { state.logoutRoute = route; },
  setDestination(state, route) { state.destinationRoute = route; },

  // Error
  error(state, error) { state.error = error; },
};

const actions = {

  // Posts
  deletePostById(context, id) { context.commit('deletePostById', id); },
  addPost(context, post) { context.commit('addPost', post); },
  addReply(context, post) { context.commit('addReply', post); },

  // Me
  setMe(context, me) { context.commit('setMe', me); },

  // Destination
  setLogin(context, route) { context.commit('setLogin', route); },
  setLogout(context, route) { context.commit('setLogout', route); },
  setDestination(context, route) { context.commit('setDestination', route); },

  // Error
  error(context, error) { context.commit('error', error); },
}

export default new Vuex.Store({
  state,
  getters,
  mutations,
  actions
});
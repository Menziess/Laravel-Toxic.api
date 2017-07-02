import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

/**
 * Contains methods to find elements in arrays.
 */
const find = {
  elementById(array, id) {
    return array.find(element => {
      return element.id === id;
    });
  },
  indexById(array, id) {
    return array.map(element => {
      return element.id;
    }).indexOf(id);
  },
  addPost(array, post) {
    // If top parent
    if (!post.attributes.post_id) {
      array.unshift(post); 
    } 
    // else reply to some parent
    else {
      const parentId = post.attributes.post_id;
      const parent = find.elementById(array, parentId);
      
      if (!parent) return;

      if (parent.relationships.replies) {
        parent.relationships.replies.unshift(post);
      } else {
        parent.relationships.replies = [ post ];
      }
    }
  },
  deletePost(array, post) {
    // If top parent
    if (!post.attributes.post_id) {
      const index = find.indexById(array, post.id);
      array.splice(index, 1);
    } 
    // else delete some child
    else {
      const parentId = post.attributes.post_id;
      const parent = find.elementById(array, parentId);

      if (!parent) return;

      const replies = parent.relationships.replies;
      const index = find.indexById(replies, post.id);
      replies.splice(index, 1);
    }
  }
}

/**
 * Modifying store.
 */
const mutations = {

  deletePost(state, post) { find.deletePost(state.posts, post); },
  addPost(state, post) { find.addPost(state.posts, post); },
  deleteSearchPost(state, post) { find.deletePost(state.searchPosts, post); },
  addSearchPost(state, post) { find.addPost(state.searchPosts, post); },

  // Setters
  setInitialPost(state, post) { state.post = post; },
  setInitialPosts(state, posts) { state.posts = posts; },
  setInitialSearchPosts(state, posts) { state.searchPosts = posts; },

  setDestination(state, route) { state.destinationRoute = route; },
  setLogout(state, route) { state.logoutRoute = route; },
  setLogin(state, route) { state.loginRoute = route; },
  setSearch(state, search) { state.search = search; },
  error(state, error) { state.error = error; },
  setMe(state, me) { state.me = me; },
};


const state = {
  searchPosts: [

  ],
  posts: [

  ],
  post: [

  ],
  me: null,
  search: null,
  logoutRoute: null,
  loginRoute: null,
  destinationRoute: null,
  error: null,
};


const getters = {
  destinationRoute: state => { return state.destinationRoute; },
  logoutRoute: state => { return state.logoutRoute; },
  loginRoute: state => { return state.loginRoute; },
  error: state => { return state.error; },
  posts: state => { return state.posts; },
  post: state => { return state.post; },
  searchPosts: state => { return state.searchPosts; },
  search: state => { return state.search; }, 
  me: state => { return state.me; },
};


const actions = {
  deleteSearchPost(context, post) { context.commit('deleteSearchPost', post); },
  setDestination(context, route) { context.commit('setDestination', route); },
  addSearchPost(context, post) { context.commit('addSearchPost', post); },
  deletePost(context, post) { context.commit('deletePost', post); },
  setLogout(context, route) { context.commit('setLogout', route); },
  setSearch(context, search) { context.commit('setSearch', search); },
  setLogin(context, route) { context.commit('setLogin', route); },
  addPost(context, post) { context.commit('addPost', post); },
  setMe(context, me) { context.commit('setMe', me); },
  error(context, error) { context.commit('error', error); },
};


export default new Vuex.Store({
  state,
  getters,
  mutations,
  actions
});
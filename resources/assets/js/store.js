import Vue from 'vue';
import Vuex from 'vuex';
import Post from './Models/Post';

Vue.use(Vuex);

const views = ['posts', 'searchPosts', 'post'];

/**
 * Store data.
 */
const state = {
  topics: [

  ],
  searchPosts: [

  ],
  posts: [

  ],
  post: [

  ],
  me: null,
  search: null,
  hasMore: true,
  replying: null,
  logoutRoute: null,
  loginRoute: null,
  destinationRoute: null,
  error: null,
};


/**
 * Getters.
 */
const getters = {
  replying: state => { return state.replying; },
  destinationRoute: state => { return state.destinationRoute; },
  logoutRoute: state => { return state.logoutRoute; },
  loginRoute: state => { return state.loginRoute; },
  topics: state => { return state.topics; },
  error: state => { return state.error; },
  hasMore: state => { return state.hasMore; },
  posts: state => { return state.posts; },
  postsLast: state => { return state.posts[state.posts.length - 1]; },
  post: state => { return state.post; },
  searchPosts: state => { return state.searchPosts; },
  searchPostsLast: state => { return state.searchPosts[state.searchPosts.length - 1]; },
  search: state => { return state.search; }, 
  me: state => { return state.me; },
};

/**
 * Helpers for finding elements in arrays.
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
}

/**
 * Helpers for manipulating posts.
 */
const execute = {
  objectifyJsonArray: jsonArray => jsonArray.map(post => new Post(post)),
  original(post) {
    return (!post.parent);
  },
  slugSameAsSearch(slug) {
    return state.searchPosts[0] ?
      slug === state.searchPosts[0].slug : false;
  },
  idSameAsDetail(id) {
    return state.post[0] ?
      id === state.post[0].id : false;
  },
  // Generic callback function applied to all posts with same id
  // that are found in any of the views defined in the view
  // array located at the top of this file.
  forEachViewHavingId(id, func) {
    let index = -1;
    views.map(view => {
      index = find.indexById(state[view], id);
      if (index !== -1)
        func(state[view], index);
    })
  },
  repliesHavingId(id, func) {
    let index = -1;
    index = find.indexById(state.post[0].replies, id);
    if (index !== -1) {
      let post = state.post[0].replies[index];
      if (!Post.isPost(post)) state.post[0].replies[index] = new Post(post);
      func(state.post[0].replies, index);
    }
  }
}

/**
 * Modifying store state.
 */
const mutations = {
  likeDislike(state, post) {
    const func = (array, index) => array[index].copyLikesDislikes(post);
    if (!Post.isPost(post)) post = new Post(post);
    if (execute.original(post)) {
      execute.forEachViewHavingId(post.id, func);
    } else {
      execute.repliesHavingId(post.id, func);
    }
  },
  delete(state, post) {
    if (!Post.isPost(post)) post = new Post(post);
    if (execute.original(post)) {
      execute.forEachViewHavingId(
        post.id,
        (array, index) => {
          array.splice(index, 1)
        }
      )
    } else {
      execute.repliesHavingId(
        1,
        () => {}
      )
    }
  },

  // If it's an original post, it's added to views, else
  // it's parents reply_count is updated in all views
  // and the reply is added to the post in detail.
  unshift(state, jsonPost) {
    const post = new Post(jsonPost);
    if (execute.original(post)) {
      if (execute.slugSameAsSearch(post.slug))
        state.searchPosts.unshift(new Post(jsonPost));
      state.posts.unshift(new Post(jsonPost));
    } else {
      if (execute.idSameAsDetail(post.parent))
        state.post[0].replies.unshift(new Post(jsonPost));
      else
        execute.addReplyToConversation(new Post(jsonPost));
      execute.forEachViewHavingId(
        post.parent,
        (array, index) => array[index].attributes.replies_count++
      )
    }
  },
  push(state, data) {
    state[data.name].push.apply(state[data.name], execute.objectifyJsonArray(data.collection)); 
  },
  replace(state, data) { 
    state[data.name] = execute.objectifyJsonArray(data.collection);
  },
  cleanup(state, data) {
    if (state[data.name].length > 7)
    state[data.name] = state[data.name].splice(0, 7);
  },
  toggleReplying(state, id) { state.replying = id; },
  hasMore(state, boolean) {state.hasMore = boolean; },
  setDestination(state, route) { state.destinationRoute = route; },
  setTopics(state, topics) { state.topics = topics; },
  setLogout(state, route) { state.logoutRoute = route; },
  setLogin(state, route) { state.loginRoute = route; },
  setSearch(state, search) { state.search = search; },
  setMe(state, me) { state.me = me; },
  error(state, error) { state.error = error; },
};

/**
 * API for talking to store.
 */
const actions = {
  new(data) {
    return axios({
      method: 'post',
      url: data.endpoint,
      data: data.post
    });
  },
  create(context, data) {
    return actions.new(data).then(response => {
      context.commit('unshift', response.data.data[0]);
    });
  },
  like(context, data) {
    return axios({
      method: 'post',
      url: 'api/post/like/' + data.id,
      data: data.type
    }).then(response => {
      context.commit('likeDislike', response.data.data[0]);
    });
  },
  dislike(context, data) {
    return axios({
      method: 'post',
      url: 'api/post/dislike/' + data.id,
      data: data.type
    }).then(response => {
      context.commit('likeDislike', response.data.data[0]);
    });
  },
  fetch(context, data) {
    return axios.get(data.endpoint)
    .then(response => {
      if (response.data.data.length > 0)
      context.commit(data.mutation, {
        name: data.name, 
        collection: response.data.data
      });
      else context.commit('hasMore', false);
    });
  },
  cleanup(context, data) { context.commit('cleanup', data); },
  delete(context, data) {
    return axios({
      method: 'delete',
      url: data.endpoint
    }).then(response => {
      context.commit('delete', data.post);
    });
  },
  deleteUser(context, id) {
    return axios({
      method: 'delete',
      url: '/api/user/' + id
    }).then(response => {
      context.commit('setMe', null);
    });
  },
  toggleReplying(context, id) { context.commit('toggleReplying', id); },
  resetHasMore(context) { context.commit('hasMore', true); },
  setDestination(context, route) { context.commit('setDestination', route); },
  setLogout(context, route) { context.commit('setLogout', route); },
  setSearch(context, search) { context.commit('setSearch', search); },
  setTopics(context, topics) { context.commit('setTopics', topics); },
  setLogin(context, route) { context.commit('setLogin', route); },
  setMe(context, me) { context.commit('setMe', me); },
  error(context, error) { context.commit('error', error); },
};


export default new Vuex.Store({
  state,
  getters,
  mutations,
  actions,
});
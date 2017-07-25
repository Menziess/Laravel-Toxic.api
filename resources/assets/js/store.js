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
  sessions: [

  ],
  error: null,
  search: null,
  hasMore: true,
  replying: null,
  destinationRoute: null,

  domainExt: null,
  csrfToken: null,
  
  me: null,
};


/**
 * Getters.
 */
const getters = {
  replying: state => { return state.replying; },
  destinationRoute: state => { return state.destinationRoute; },
  topics: state => { return state.topics; },
  error: state => { return state.error; },
  sessions: state => { return state.sessions; },
  hasMore: state => { return state.hasMore; },
  posts: state => { return state.posts; },
  postsLast: state => { return state.posts[state.posts.length - 1]; },
  post: state => { return state.post; },
  postLast: state => { return state.post[0].replies[state.post[0].replies.length - 1]; },
  searchPosts: state => { return state.searchPosts; },
  searchPostsLast: state => { return state.searchPosts[state.searchPosts.length - 1]; },
  search: state => { return state.search; },

  domainExt: state => { return state.domainExt; }, 
  csrfToken: state => { return state.csrfToken; }, 

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
    if (state.post.length < 1) return;
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
    const func = (array, index) => array.splice(index, 1)    
    if (!Post.isPost(post)) post = new Post(post);
    if (execute.original(post)) {
      execute.forEachViewHavingId(post.id, func);
    } else {
      execute.repliesHavingId(post.id, func);
    }
  },

  /* 
   * If it's an original post, it's added to views, else
   * it's parents reply_count is updated in all views
   * and the reply is added to the post in detail.
   */
  unshift(state, jsonPost) {
    // Convert to Post
    const post = new Post(jsonPost);
    // Check if it's a new post
    if (execute.original(post)) {
      // Add to home and search views
      if (execute.slugSameAsSearch(post.slug))
        state.searchPosts.unshift(new Post(jsonPost));
      state.posts.unshift(new Post(jsonPost));
    // If it's a reply
    } else {
      // And it's loaded in the detail view
      if (execute.idSameAsDetail(post.parent))
        state.post[0].replies.unshift(new Post(jsonPost));
      // Or if it's a reply to post on detail view
      execute.repliesHavingId(
        post.parent, 
        (array, index) => {
          array[index].replaceConversation(new Post(jsonPost));
        }
      )
      // Also update replycount when it's a reply to original
      execute.forEachViewHavingId(
        post.parent,
        (array, index) => array[index].attributes.replies_count++
      )
    }
  },
  push(state, data) {
    state[data.name].push.apply(
      state[data.name], execute.objectifyJsonArray(data.collection)
    );
  },
  pushReplies(state, data) {
    state[data.name][0].relationships.replies.push.apply(
      state[data.name][0].relationships.replies, execute.objectifyJsonArray(data.collection)
    );
  },
  replace(state, data) { 
    state[data.name] = execute.objectifyJsonArray(data.collection);
  },
  cleanup(state, data) {
    if (state[data.name].length > 7)
    state[data.name] = state[data.name].splice(0, 7);
  },
  cleanupAll(state) { state.post = []; state.posts = []; state.searchPosts = []; },
  toggleReplying(state, id) { state.replying = id; },
  hasMore(state, boolean) {state.hasMore = boolean; },
  setTopics(state, topics) { state.topics = topics; },
  setDestination(state, route) { state.destinationRoute = route; },
  setDomainExt(state, route) { state.domainExt = route; },
  setCsrfToken(state, route) { state.csrfToken = route; },
  setSessions(state, sessions) { state.sessions = sessions; },
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
      if (response.data.data.length < 7) 
        context.commit('hasMore', false);
    });
  },
  cleanup(context, data) { context.commit('cleanup', data); },
  cleanupAll(context) { context.commit('cleanupAll'); },
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
  setMe(context, me) { context.commit('setMe', me); },
  toggleReplying(context, id) { context.commit('toggleReplying', id); },
  resetHasMore(context) { context.commit('hasMore', true); },
  setDestination(context, route) { context.commit('setDestination', route); },
  setSearch(context, search) { context.commit('setSearch', search); },
  setTopics(context, topics) { context.commit('setTopics', topics); },
  setDomainExt(context, route) { context.commit('setDomainExt', route); },
  setSessions(context, sessions) { context.commit('setSessions', sessions); },
  setCsrfToken(context, route) { context.commit('setCsrfToken', route); },
  error(context, error) { context.commit('error', error); },
};

export default new Vuex.Store({
  state,
  getters,
  mutations,
  actions,
});
export default class Post {
  
  constructor(data) {
    if (data.type !== 'posts') 
      throw new TypeError('Wrong object type passed in Post constructor');
    Object.assign(this, data);
  }

  get slug() { return this.attributes.slug; }
  get parent() { return this.attributes.post_id; }
  get drawing() { return this.attributes.drawing; }
  get attachment() { return this.attributes.attachment; }

  get replies() { return this.relationships.replies; }
  
  get isLiked() { return this.relationships.likes[0].relationships.pivot.attributes.type == 1; }
  get isDisliked() { return this.relationships.likes[0].relationships.pivot.attributes.type == 0; }

  set likes(likes) { Vue.set(this.relationships, 'likes', likes); }

  replaceConversation(post) {
    this.attributes.replies_count++;    
    Vue.set(this.relationships, 'conversation', [post]);
  }
  copyLikesDislikes(post) {
    this.attributes.likes_count = post.attributes.likes_count;
    this.attributes.dislikes_count = post.attributes.dislikes_count;
    Vue.set(this.relationships, 'likes', [post.relationships.likes[0]]);
  }

  static isPost(data) {
    return data instanceof Post;
  }
}

export default class Post {
  
  constructor(data) {
    if (data.type !== 'posts') 
      throw new TypeError('Wrong object type passed in Post constructor');

    this.id = data.id;
    this.attributes = data.attributes;
    this.relationships = data.relationships;
    
    this.user = data.relationships.user;
    this.topic = data.relationships.topic;
    this.replies = data.relationships.replies;
    this.conversation = data.relationships.conversation;
  }

  get slug() { return this.attributes.slug; }
  get parent() { return this.attributes.post_id; }
  get drawing() { return this.attributes.drawing; }

  get isLiked() { return this.relationships.likes[0].relationships.pivot.attributes.type == 1; }
  get isDisliked() { return this.relationships.likes[0].relationships.pivot.attributes.type == 0; }

  copyLikesDislikes(post) {
    this.attributes.likes_count = post.attributes.likes_count;
    this.attributes.dislikes_count = post.attributes.dislikes_count;
    Vue.set(this.relationships, 'likes', post.relationships.likes);
  }

  static parsePost(data) {
    if (!data instanceof Post)
      data = new self(data);
  }
}

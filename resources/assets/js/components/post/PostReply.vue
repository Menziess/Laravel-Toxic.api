<template>
	<div class="panel-separator">
		<Forms ref="form"></Forms>
	</div>
</template>

<script>
import Forms from './post_new/Forms.vue';
export default {
	name: 'postreply',
	props: ['post'],
	components: {
		Forms
	},
	data() {
		return {
			submitted: false,
		}
	},
	methods: {
		submit() {
			if (this.submitted) { return false; }
			this.submitted = true;
			this.$store.dispatch('create', {
				endpoint: 'api/post',
				post: this.getForm(),
			}).then(response => {
				this.submitted = false;
				this.$store.dispatch('toggleReplying', null);
				this.$router.push({
					name: 'post',
					params: { slug: this.post.attributes.slug, id: this.post.id }
				});
				window.scroll(0, 0);
			}).catch(error => {
				this.submitted = false;
				this.$router.push({ name: 'error'});
			})
		},
		getForm() {
			return {
				post_id: this.post.id,
				subject: this.post.attributes.subject,
				attachment: this.$refs.form.attachment,
				drawing: this.$refs.form.attachment === 'drawing' ? this.$refs.form.$refs.myDrawing.getDataUrl() : null,
				text: this.$refs.form.attachment === 'text' ? this.$refs.form.$refs.myTextbox.text : null,
				url: this.$refs.form.attachment === 'url' ? this.$refs.form.$refs.myLinkbox.url : null
			}
		},

	}
}
</script>
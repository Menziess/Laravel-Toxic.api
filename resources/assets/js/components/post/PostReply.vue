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
			}).catch(error => {
				this.submitted = false;
				this.$router.push({ name: 'error'});
			})
		},
		getForm() {
			return {
				post_id: this.post.id,
				subject: this.post.attributes.subject,
				drawing: this.$refs.form.getDrawing(),
				text: this.$refs.form.getText(),
				url: this.$refs.form.getUrl()
			}
		}
	}
}
</script>

<style scoped>
.panel-separator {
	z-index: 1;
	position: relative;
}
</style>

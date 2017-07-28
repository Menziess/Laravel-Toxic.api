<template>
	<div class="col-md-6">
    <div class="panel">				
			<Forms ref="form"></Forms>
		</div>
	</div>
</template>

<script>
import Forms from './post_new/Forms.vue';
export default {
	name: 'postmodal',
	components: {
		Forms
	},
	data() {
		return {
			submitted: false,
			subject: null
		}
	},
	created() {
		this.$store.dispatch('toggleReplying', -1);
	},
	destroyed() {
		this.$store.dispatch('toggleReplying', null);
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
				this.$router.push({ name: 'home' });
				window.scroll(0, 0);
			}).catch(error => {
				this.submitted = false;
				this.$router.push({ name: 'error'});
			})
		},
		getForm() {
			return {
				post_id: null,
				subject: this.getSubject(this.subject),
				drawing: this.$refs.form.getDrawing(),
				text: this.$refs.form.getText(),
				url: this.$refs.form.getUrl()
			}
		},
		getSubject(subject) {
			if (!subject) { subject = this.$route.params.slug; }
			return subject.replace(/[^a-zA-Z0-9]+/g, " ");
		}
	}
}
</script>

<style scoped>
input {
  text-transform: capitalize;
}
</style>
<template>
	<div class="col-md-6">
    <div class="panel panel-default">

				<!-- Subject -->				
				<div class="panel-heading">
					<div class="input-group">
						<span class="input-group-addon" id="subject-addon">/ t /</span>
						<input type="text" class="form-control" v-model="subject" maxlength="60"
							ref="subject"
							aria-describedby="subject-addon"
							:placeholder="defaultSubject()">
						<div class="input-group-btn" @click="$refs.subject.value = ''">
							<button class="btn btn-default"><i class="glyphicon glyphicon-remove"></i></button>
						</div>
					</div>
				</div>
				
				<!-- Inputs -->
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
				attachment: this.$refs.form.attachment,
				drawing: this.$refs.form.attachment === 'drawing' ? this.$refs.form.$refs.myDrawing.getDataUrl() : null,
				text: this.$refs.form.attachment === 'text' ? this.$refs.form.$refs.myTextbox.text : null,
				url: this.$refs.form.attachment === 'url' ? this.$refs.form.$refs.myLinkbox.url : null
			}
		},
		defaultSubject() {
			if (this.$route.params.slug) return this.$route.params.slug;
			switch (this.attachment) {
				case 'drawing':
					return "Drawings";
					break;
				case 'url':
					return "Links";
					break;
				default:
					return "General";
					break;
			}
		},
		getSubject(subject) {
			if (!subject) {
				subject = this.defaultSubject();
			}
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
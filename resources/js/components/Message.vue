<template>
	<div :class="'message ' + (sender != user ? 'user' : 'agent')">
		<div class="message_text">{{ message }}</div>
	</div>
</template>

<script>
	export default {
		name: 'Message',
		props: {
			sender: { type: Number, default: 0 },
			user: { type: String, default: '' },
			message: { type: String, default: '' },
			createdat: { type: String, default: '' }
		},
		filters: {
			showChatTime: (createdat) => {
				let date = new Date(createdat);
				date = ("0" + date.getDate()).slice(-2) + '/' + ("0" + date.getMonth()).slice(-2) + '/' + date.getFullYear() + ' ' +
					("0" + date.getHours()).slice(-2) + ':' + ("0" + date.getMinutes()).slice(-2);
				return date;
			}
		},
		data() {
			return {
			}
		},
		mounted() {
		},
		methods: {
		}
	}
</script>

<style scoped>
	.message {}
	.message.user { text-align: right; }
	.message.agent { text-align: left; }
	.message.user .message_text { background: #0099FF; color: white; padding: 10px 20px; display: inline-block; margin-bottom: 20px; }
	.message.agent .message_text { background: #EEEDF1; padding: 10px 20px; display: inline-block; margin-bottom: 20px; }
</style>

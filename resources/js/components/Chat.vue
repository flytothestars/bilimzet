<template>
	<div class="chat-window width1088 flex between align-top stretch">
		<div class="chat-info flex between">
			<div class="top">
				<img src="/images/elements/support.svg" alt="">
				<p>Служба поддержки</p>
			</div>
			<div class="bottom">
				<img :src="agent.photo" alt="">
				<p class="role">{{ agent.role }}</p>
				<p class="name">{{ agent.name }}</p>
			</div>
		</div>
		<div class="chat-body flex between">
			<div v-if="!isAdmin" class="top"><a class="close" @click="close"><img src="/images/elements/close.svg" alt=""></a></div>
			<div id="messages" class="messages">
				<div v-if="messages.length">
					<message v-for="message in messages" :key="message.id" :sender="message.sender.id" :user="user"
								:message="message.message" :createdat="message.created_at"></message>
				</div>
			</div>
			<div class="bottom">
				<input type="text" placeholder="Введите сообщение" v-model="textMessage" @keyup.enter="sendMessage" autofocus>
				<a class="attach" @click="attach"><img src="/images/elements/file.svg" alt=""></a>
				<button type="button" :disabled="!textMessage" @click="sendMessage">
					<img src="/images/elements/send.svg" alt="">
				</button>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Chat',
	props: {
		chatroom: { type: String, default: '' },
		user: { type: String, default: '' }
	},
	data() {
		return {
			csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
			isAdmin: document.getElementById('app').classList.contains('chat'),
			messages: [],
			textMessage: '',
			isTyping: false,
			agent: {
				role: 'Администратор',
				name: 'Марта Ринатова',
				photo: '/images/users/marta.png'
			}
		}
	},
	mounted() {
		window.Echo.channel('chat.' + this.chatroom)
			.listen('ChatMessage', ({message}) => {
				this.messages.push(message);
			});
		window.axios.defaults.headers.common = {
			'X-CSRF-TOKEN': this.csrf,
			'X-Requested-With': 'XMLHttpRequest'
		};
		this.fetchChat();
	},
	updated() {
		this.adjustChatContainer();
	},
	methods: {
		close() {
			document.getElementById('app').style.display = 'none';
		},
		attach() {

		},
		sendMessage() {
			this.textMessage = this.textMessage.trim();
			if (this.textMessage === '') {
				return;
			}
			let that = this;
			axios.post('/chat/' + this.chatroom, {
				user: that.user,
				body: that.textMessage
			}).then( response => {
				that.textMessage = '';
				that.messages.push( response.data );
				that.adjustChatContainer();
			}).catch( error => {
				console.log(error);
			});
		},
		fetchChat() {
			let that = this;
			axios.get('/chat/fetch/' + this.chatroom, {
				user: that.user
			}).then( response => {
				that.messages = response.data;
				that.adjustChatContainer();
			}).catch( error => {
				console.log(error);
			})
		},
		updateChat(res) {
			this.messages.push(res.message);
		},
		adjustChatContainer() {
			let chatContainer = document.getElementById('messages');
			if (chatContainer) {
				chatContainer.scrollTop = chatContainer.scrollHeight;
			}
		},
		userIsTyping(chatRoomId) {
			window.Echo.private(`typing-room-${chatRoomId}`)
				.whisper('typing', {
					name: window.Laravel.user.name
				});
		}
	}
}
</script>

<style scoped>
	.close, .attach {
		cursor: pointer;
	}
</style>

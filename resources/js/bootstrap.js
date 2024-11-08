window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

try {
	window.Popper = require('popper.js').default;
	window.$ = window.jQuery = require('jquery');

	require('bootstrap');
} catch (e) {}

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';
window.io = require('socket.io-client');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

// echo
//     .private(`chat.${comments.channel}`)
//     .listen('ChatMessage', (e) => {
//         comments.list.find('ul > li.empty').remove();
//         comments.list.find('ul').append(e.view);
//         comments.count.text(parseInt(comments.count.text()) + 1);
//         comments.list.scrollTop(9999999999);
//         comments.sound.play();
//     });

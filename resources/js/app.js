import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'http') === 'https',
    enabledTransports: ['ws', 'wss'],
});

window.addEventListener('DOMContentLoaded', () => {
    const statusEl = document.getElementById('status');
    const button = document.getElementById('update');

    if (!statusEl || !button) return;

    window.Echo.channel('status')
        .listen('StatusUpdated', (e) => {
            statusEl.innerText = e.message;
        });

    button.addEventListener('click', async () => {
        await fetch('/update-status', { method: 'POST' });
    });
});

import {base64ToUint8Array} from "@src/base-64-to-unit-8-array";

window.addEventListener('DOMContentLoaded', () => registerServiceWorkers())

const registerServiceWorkers = async () => {
    const permission = await Notification.requestPermission();

    if (permission !== 'granted') {
        throw new Error('Web push service worker permission not granted!');
    }

    const publicKey = document.querySelector('meta[name=vapid-public-key]')?.getAttribute('content') ?? '';

    const serviceWorker = await navigator?.serviceWorker.register('/js/web-push-service-worker.js');
    const subscription = await serviceWorker.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: base64ToUint8Array(publicKey)
    })

    const token = document.querySelector('meta[name=csrf-token]')?.getAttribute('content') ?? '';

    const response = await fetch('/web-push/subscribe', {
        method: 'post',
        body: JSON.stringify(subscription),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-Token': token
        }
    })

    const data = await response.json();

    if (!data?.success) {
        throw new Error('Web push subscription failed!')
    }
}

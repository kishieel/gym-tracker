(function (self: ServiceWorkerGlobalScope) {
    self.addEventListener('push', async (event: PushEvent) => {
        if (Notification.permission !== 'granted') {
            return
        }

        const data = await event.data?.json()
        console.log(data)

        data && event.waitUntil(
            self.registration.showNotification(data?.title, {...data})
        )
    })

    self.addEventListener('notificationclick', (event: NotificationEvent) => {
        const url = event.notification.data?.url ?? '';
        event.notification.close();

        event.waitUntil(
            self.clients.matchAll({type: 'window'}).then((windowClients) => {
                for (let i = 0; i < windowClients.length; i++) {
                    if (windowClients[i].url === url && 'focus' in windowClients[i]) {
                        return windowClients[i].focus();
                    }
                }
                if (self.clients.openWindow) {
                    return self.clients.openWindow(url);
                }
            })
        )
    })
})(<ServiceWorkerGlobalScope>(self as any));

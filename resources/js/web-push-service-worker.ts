(function (self: ServiceWorkerGlobalScope) {
    self.addEventListener('push', async (event: PushEvent) => {
        if (Notification.permission !== 'granted') {
            return
        }

        const data = await event.data?.json()

        data && event.waitUntil(
            self.registration.showNotification(data?.title, {...data})
        )
    })
})(<ServiceWorkerGlobalScope>(self as any));

const CACHE_NAME = 'meygo-pwa-v1';
const urlsToCache = [
  './index.html',
  './suministros.html',
  './servicios.html',
  './css/style.css',
  './assets/images/icon.png',
  './assets/images/logo.png'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        if (response) {
          return response;
        }
        return fetch(event.request);
      })
  );
});

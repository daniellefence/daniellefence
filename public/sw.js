// Service Worker for Performance Optimization
const CACHE_NAME = 'danielle-fence-v1';
const STATIC_CACHE_URLS = [
  '/',
  '/css/app.css',
  '/js/app.js',
  '/images/logo.webp'
];

// Install event - cache critical resources
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(STATIC_CACHE_URLS);
      })
      .then(() => {
        return self.skipWaiting();
      })
  );
});

// Activate event - clean up old caches
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames
          .filter(cacheName => cacheName !== CACHE_NAME)
          .map(cacheName => caches.delete(cacheName))
      );
    }).then(() => {
      return self.clients.claim();
    })
  );
});

// Fetch event - implement caching strategy
self.addEventListener('fetch', event => {
  const { request } = event;

  // Skip non-GET requests and chrome-extension requests
  if (request.method !== 'GET' || request.url.includes('chrome-extension://')) {
    return;
  }

  // Handle different types of resources
  if (request.destination === 'image') {
    // Cache-first strategy for images
    event.respondWith(
      caches.match(request)
        .then(response => {
          if (response) {
            return response;
          }
          return fetch(request).then(response => {
            if (response.status === 200) {
              const responseClone = response.clone();
              caches.open(CACHE_NAME).then(cache => {
                cache.put(request, responseClone);
              });
            }
            return response;
          });
        })
    );
  } else if (request.destination === 'style' || request.destination === 'script') {
    // Stale-while-revalidate for CSS/JS
    event.respondWith(
      caches.match(request)
        .then(response => {
          const fetchPromise = fetch(request).then(fetchResponse => {
            if (fetchResponse.status === 200) {
              const responseClone = fetchResponse.clone();
              caches.open(CACHE_NAME).then(cache => {
                cache.put(request, responseClone);
              });
            }
            return fetchResponse;
          });

          return response || fetchPromise;
        })
    );
  } else {
    // Network-first strategy for HTML pages
    event.respondWith(
      fetch(request)
        .then(response => {
          if (response.status === 200) {
            const responseClone = response.clone();
            caches.open(CACHE_NAME).then(cache => {
              cache.put(request, responseClone);
            });
          }
          return response;
        })
        .catch(() => {
          return caches.match(request);
        })
    );
  }
});

// Background sync for offline form submissions
self.addEventListener('sync', event => {
  if (event.tag === 'quote-request') {
    event.waitUntil(
      // Handle offline form submissions when back online
      handleOfflineQuoteRequests()
    );
  }
});

async function handleOfflineQuoteRequests() {
  // Implementation for handling offline form data
  const cache = await caches.open(CACHE_NAME);
  // Process any cached form submissions
}
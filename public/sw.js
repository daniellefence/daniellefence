// Service Worker for Performance Optimization
const CACHE_NAME = 'danielle-fence-v2';
const STATIC_CACHE_URLS = [
  '/'
  // Don't pre-cache Vite assets as they have hashed names
  // They will be cached on first request
];

// Install event - cache critical resources
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        // Only cache URLs that actually exist
        return Promise.allSettled(
          STATIC_CACHE_URLS.map(url =>
            fetch(url)
              .then(response => {
                if (response.ok) {
                  return cache.put(url, response);
                }
              })
              .catch(error => {
                // Failed to cache resource
              })
          )
        );
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

  // Skip non-GET requests, chrome-extension requests, and hot-reload requests
  if (request.method !== 'GET' ||
      request.url.includes('chrome-extension://') ||
      request.url.includes('/@vite') ||
      request.url.includes('hot-update')) {
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
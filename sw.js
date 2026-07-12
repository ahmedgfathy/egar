// Browser-page helper only. Older builds mistakenly registered this file as a
// Service Worker, so every DOM access must remain safe outside a page context.
const divInstall = typeof document !== 'undefined' ? document.getElementById('installContainer') : null;

/* Put code here */
if (typeof window !== 'undefined') window.addEventListener('beforeinstallprompt', (event) => {
  console.log('👍', 'beforeinstallprompt', event);
  // Stash the event so it can be triggered later.
  window.deferredPrompt = event;
  // Remove the 'hidden' class from the install button container
  if (divInstall) divInstall.classList.toggle('hidden', false);
});


/* Only register a service worker if it's supported */
// Registration disabled: the legacy worker intercepted CRM login POSTs.

/**
 * Warn the page must be served over HTTPS
 * The `beforeinstallprompt` event won't fire if the page is served over HTTP.
 * Installability requires a service worker with a fetch event handler, and
 * if the page isn't served over HTTPS, the service worker won't load.
 */
if (typeof window !== 'undefined' && window.location.protocol === 'http:') {
  const requireHTTPS = document.getElementById('requireHTTPS');
  if (requireHTTPS) {
    const link = requireHTTPS.querySelector('a');
    if (link) link.href = window.location.href.replace('http://', 'https://');
    requireHTTPS.classList.remove('hidden');
  }
}

/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

document.querySelector('a.file').addEventListener('click', (e) => {
  gtag('event', 'download', {
    'user': e.currentTarget.dataset.user,
    'operation': e.currentTarget.dataset.operation
  });
})

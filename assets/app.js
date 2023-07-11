import {gsap} from "gsap";
import { ScrollToPlugin } from "gsap/dist/ScrollToPlugin"
gsap.registerPlugin(ScrollToPlugin)

/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

if (document.body.classList.contains('page-operation')) {
  let file = document.querySelector('a.file')
      if (file) {
        file.addEventListener('click', (e) => {
          console.log('gtag', e.currentTarget.dataset.user,e.currentTarget.dataset.operation)
          gtag('event', 'operation_dl', {
            'debug_mode':true,
            'user': e.currentTarget.dataset.user,
            'operation': e.currentTarget.dataset.operation
          });
        })
      }
}

document.querySelectorAll('.menuCat').forEach((item)=> {
  item.addEventListener("click", (e)=> {
    gsap.to(window, {duration: 0.5, scrollTo: {y: '.categorie#' + item.dataset.cat, offsetY: 100}, ease:"easeOutQuad"})
  })
})

if(document.querySelector('.page-index')) {
  window.addEventListener('load', ()=> {
    console.log('load')
    gsap.to(window, {duration: 1, scrollTo: {y: '-=78'}, ease:"easeOutQuad"})
  })
}




/*window.addEventListener('scroll', function() {
  const myDiv = document.querySelector('.bloc');
  let rect = myDiv.getBoundingClientRect();
  console.log(rect.top)

  if (rect.top <= 75) {
    myDiv.classList.add('fixed');
  } else {
    myDiv.classList.remove('fixed');
  }
});*/



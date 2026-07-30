
document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.querySelector('.mupo-menu-toggle');
  const nav = document.querySelector('.mupo-nav');

  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      const isOpen = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }

  const current = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.mupo-nav a').forEach(function (link) {
    const href = link.getAttribute('href');
    if (href === current || (current === '' && href === 'index.html')) {
      link.classList.add('active');
    }
  });
});

document.addEventListener('DOMContentLoaded',function(){
 var current=(window.location.pathname.split('/').pop()||'index.html').toLowerCase();
 document.querySelectorAll('.mupo-nav a').forEach(function(a){
   var href=(a.getAttribute('href')||'').toLowerCase();
   if(href===current || (current===''&&href==='index.html')){
      a.classList.add('active-page');
      a.setAttribute('aria-current','page');
   }
 });
});

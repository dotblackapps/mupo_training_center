document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.querySelector('.mupo-menu-toggle');
  const nav = document.querySelector('.mupo-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      const isOpen = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }

  document.querySelectorAll('[data-filter]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.querySelectorAll('[data-filter]').forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
    });
  });

  const toast = document.getElementById('toast');
  document.querySelectorAll('form[data-demo-form="true"]').forEach(function (form) {
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      if (toast) {
        toast.classList.add('show');
        setTimeout(function () { toast.classList.remove('show'); }, 3000);
      }
      form.reset();
    });
  });
});

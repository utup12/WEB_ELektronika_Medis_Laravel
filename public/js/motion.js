(() => {
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const targets = document.querySelectorAll('main section, .feature-grid > article, .content-card');
  targets.forEach((node, index) => {
    if (!node.classList.contains('hero')) {
      node.classList.add('reveal-on-scroll');
      if (index % 2) node.classList.add('reveal-from-right');
    }
  });
  if (!reduceMotion && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
      if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); }
    }), { threshold: .14 });
    document.querySelectorAll('.reveal-on-scroll').forEach((node) => observer.observe(node));
  } else document.querySelectorAll('.reveal-on-scroll').forEach((node) => node.classList.add('is-visible'));

  const grid = document.querySelector('.feature-grid');
  if (!grid) return;
  grid.classList.add('professional-slider');
  const controls = document.createElement('div');
  controls.className = 'slider-controls';
  controls.innerHTML = '<button type="button" aria-label="Geser kartu sebelumnya">←</button><button type="button" aria-label="Geser kartu berikutnya">→</button>';
  controls.querySelectorAll('button')[0].addEventListener('click', () => grid.scrollBy({left:-340,behavior:reduceMotion?'auto':'smooth'}));
  controls.querySelectorAll('button')[1].addEventListener('click', () => grid.scrollBy({left:340,behavior:reduceMotion?'auto':'smooth'}));
  grid.insertAdjacentElement('afterend', controls);
})();

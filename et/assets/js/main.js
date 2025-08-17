
// Mobile nav toggle
const burger = document.querySelector('.burger');
const navlinks = document.querySelector('.navlinks');
if(burger){
  burger.addEventListener('click', ()=> navlinks.classList.toggle('open'));
}

// Highlight active link
const current = location.pathname.split('/').pop() || 'index.php';
document.querySelectorAll('.navlinks a').forEach(a=>{
  const href = a.getAttribute('href');
  if((current === '' && href.includes('index')) || href.endsWith(current)){
    a.classList.add('active');
  }
});

// Reveal on scroll
const observer = new IntersectionObserver((entries)=>{
  entries.forEach(e=>{
    if(e.isIntersecting){
      e.target.classList.add('show');
      observer.unobserve(e.target);
    }
  })
},{threshold:.18});
document.querySelectorAll('.reveal').forEach(el=>observer.observe(el));

// Copy email
const copyBtns = document.querySelectorAll('[data-copy]');
copyBtns.forEach(btn=>{
  btn.addEventListener('click', ()=>{
    const text = btn.getAttribute('data-copy');
    navigator.clipboard.writeText(text).then(()=>{
      const orig = btn.textContent;
      btn.textContent = 'Kopyalandı!';
      setTimeout(()=> btn.textContent = orig, 1200);
    });
  });
});

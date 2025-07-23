const aspas = document.querySelectorAll(".nav-list a"); // Remove aspas simples/dobras dos textos
const submenuTriggers = document.querySelectorAll(".has-submenu > a");
const menu = document.querySelector(".mobile-menu");
const nav = document.querySelector('.nav-list');
const items = nav.querySelectorAll('li');

menu.addEventListener('click', ()=>{
  menu.classList.toggle('active');
  nav.classList.toggle('active');

  items.forEach((el, i) => {
  el.style.animation = el.style.animation? '' : `navLinkFade 0s ease forwards ${0}s`;
    
    document.body.style.overflow = nav.classList.contains('ativo') ? 'hidden' : '';//mantem o boddy fixo.
    
  });
});

// Remove aspas dos textos
aspas.forEach(link => {
  link.childNodes.forEach(node => {
    if (node.nodeType === Node.TEXT_NODE) {
      node.textContent = node.textContent.replace(/['"]/g, "");
    }
  });
});

// Toggle submenu
submenuTriggers.forEach(link => {
  link.addEventListener("click", function (e) {
    e.preventDefault();
    const parentLi = this.parentElement;

    // Fecha outros submenus abertos
    document.querySelectorAll(".has-submenu.active").forEach(item => {
      if (item !== parentLi) {
        item.classList.remove("active");
      }
    });

    parentLi.classList.toggle("active");
  });
});

// Fechar submenu ao clicar fora
document.addEventListener("click", function (e) {
  const isClickInsideMenu = e.target.closest(".has-submenu");
  if (!isClickInsideMenu) {
    document.querySelectorAll(".has-submenu.active").forEach(item => {
      item.classList.remove("active");
    });
  }
});
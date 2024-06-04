document.addEventListener("DOMContentLoaded", () => {
  const menu = document.getElementById("menu");
  const closeAlerts = document.querySelectorAll('.close-alert');
  const navLink = document.getElementById("nav-link");
  menu.addEventListener("click", () => navLink.classList.toggle("h-0"));

  closeAlerts.forEach(e=>{
    e.addEventListener('click',()=>{
      e.outerHTML = '';
    })
  })
});
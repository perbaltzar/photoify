
//Toggle to show edit-menu
const menu = document.querySelector('.profile-edit-menu');
const edit = document.querySelector('.profile-edit');
edit.addEventListener('click', ()=>{
  menu.classList.toggle('active');
})

const openModal = document.querySelector('.parte-1 .papitas');
const modal= document.querySelector('.modal');
const closeModal= document.querySelector('.modal');

openModal.addEventListener('click', (e)=>{
    e.preventDefault();
    modal.classList.add('modal--show');

});

closeModal.addEventListener('click', (e)=>{
    e.preventDefault();
    modal.classList.remove('modal--show');

});


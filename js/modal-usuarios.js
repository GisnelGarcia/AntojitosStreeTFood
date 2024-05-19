const openModal = document.querySelector('.contenedor-item');
const modal= document.querySelector('.cambio');
const closeModal= document.querySelector('.cerrar');

openModal.addEventListener('click', (e)=>{
    e.preventDefault();
    modal.classList.add('cambio--show');

});

closeModal.addEventListener('click', (e)=>{
    e.preventDefault();
    modal.classList.remove('cambio--show');

}); 
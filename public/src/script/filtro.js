function filtrarPorCategoria(){
    const filtro = document.getElementById('filtro-categoria').value;
    const itens = document.querySelectorAll('.activity-item');

    itens.forEach(item =>{
        const categoria = item.getAttribute('data-categoria');
        if(!filtro || categoria === filtro){
            item.style.display = 'block';
        }else{
            item.style.display = 'none';
        }
    });
}
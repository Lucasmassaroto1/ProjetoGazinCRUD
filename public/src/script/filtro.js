function filtrarPorCategoria(){
    const filtro = document.getElementById('filtro-categoria').value;
    const itens = document.querySelectorAll('.activity-item');

    console.log("Filtro selecionado:", filtro); // DEBUG

    itens.forEach(item =>{
        const categoria = item.getAttribute('data-categoria');
        console.log("Categoria do item:", categoria); // DEBUG
        if(!filtro || categoria === filtro){
            item.style.display = 'block';
        }else{
            item.style.display = 'none';
        }
    });
}
/* function filtrarPorCategoria(){
    const filtro = document.getElementById('filtro-categoria').value;

    const container = document.getElementById('listar-comandos-detalhes');
    const itens = container.querySelectorAll('.activity-item');

    itens.forEach(item =>{
        const categoria = item.getAttribute('data-categoria');
        if(!filtro || categoria === filtro){
            item.style.display = 'block';
        }else{
            item.style.display = 'none';
        }
    });
} */
function filtrarPorCategoria(){
    const filtro = document.getElementById('filtro-categoria').value;
    //Filtro com botões
    const detalhesContainer = document.getElementById('listar-comandos-detalhes');
    if(detalhesContainer){
        const detalhesItens = detalhesContainer.querySelectorAll('[data-categoria]');
        detalhesItens.forEach(item =>{
            const categoria = item.getAttribute('data-categoria');
            item.style.display = (!filtro || categoria === filtro) ? 'block' : 'none';
        });
    }
    //Filtro simples
    const simplesContainer = document.getElementById('lista-comandos');
    if(simplesContainer){
        const simplesItens = simplesContainer.querySelectorAll('[data-categoria]');
        simplesItens.forEach(item =>{
            const categoria = item.getAttribute('data-categoria');
            item.style.display = (!filtro || categoria === filtro) ? 'block' : 'none';
        });
    }
}

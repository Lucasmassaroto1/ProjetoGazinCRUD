let BASEPAGINA_URL = './';
let LISTAR_COMANDOS_ARQUIVO = ['listarUsuario.php']; // padrão (dashboard)

const pathnamePagina = window.location.pathname;

if(pathnamePagina.includes('/public/')){ // PRINCIPAL
    BASEPAGINA_URL = '../admin/';
    LISTAR_COMANDOS_ARQUIVO = ['listarPublico.php'];

}else if(pathnamePagina.includes('admin/views/painel/comandos.php')){ // COMANDOS
    BASEPAGINA_URL = '../../';
    LISTAR_COMANDOS_ARQUIVO = ['listarTodos.php', 'listarDetalhes.php', 'listarMusicas.php'];

}else if(pathnamePagina.includes('admin/views/painel/')){ // DASHBOARD
    BASEPAGINA_URL = '../../';
    LISTAR_COMANDOS_ARQUIVO = ['listarUsuario.php'];
}

let categoriaAtual = '';

function carregarPagina(pagina = 1, categoria = null){
    if(categoria !== null){
        categoriaAtual = categoria;
    }
    
    LISTAR_COMANDOS_ARQUIVO.forEach(arquivo =>{
        if(arquivo === 'listarMusicas.php') return;
        let url = BASEPAGINA_URL + 'components/comandos/' + arquivo + '?pagina=' + pagina;
        if(categoriaAtual !== ''){
            url += '&categoria=' + encodeURIComponent(categoriaAtual);
        }

        fetch(url)
            .then(response => response.text())
            .then(html =>{
                if(arquivo === 'listarDetalhes.php'){
                    document.getElementById('listar-comandos-detalhes').innerHTML = html;
                }else{
                    document.getElementById('lista-comandos').innerHTML = html;
                }
            })
            .catch(error =>{
                console.error('Erro ao carregar os comandos de', arquivo, error);
            });
    });
}

function carregarMusicasPagina(pagina = 1) {
    let url = BASEPAGINA_URL + 'components/comandos/listarMusicas.php?pagina=' + pagina;

    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById('listar-musica').innerHTML = html;
        })
        .catch(error => {
            console.error('Erro ao carregar músicas', error);
        });
}

function filtrarPorCategoria(){
    const categoriaSelecionada = document.getElementById('filtro-categoria').value;
    carregarPagina(1, categoriaSelecionada); // reinicia para página 1
}

document.addEventListener('DOMContentLoaded', function (){
    carregarPagina();
    carregarMusicasPagina();
});
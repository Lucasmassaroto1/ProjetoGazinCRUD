let BASEPAGINA_URL = './';
let LISTAR_COMANDOS_ARQUIVO = ['listar_comandos_usuario.php']; // padrão (dashboard)

const pathnamePagina = window.location.pathname;

if(pathnamePagina.includes('/public/')){ // INDEX
    BASEPAGINA_URL = '../admin/';
    LISTAR_COMANDOS_ARQUIVO = ['listar_comandos_publico.php'];

}else if(pathnamePagina.includes('/admin/pages/comandos.php')){ // COMANDOS
    BASEPAGINA_URL = '../';
    LISTAR_COMANDOS_ARQUIVO = ['listar_comandos.php', 'listar_comandos_detalhes.php'];

}else if(pathnamePagina.includes('/admin/pages/')){ // DASHBOARD
    BASEPAGINA_URL = '../';
    LISTAR_COMANDOS_ARQUIVO = ['listar_comandos_usuario.php'];
}

function carregarPagina(pagina = 1){
    LISTAR_COMANDOS_ARQUIVO.forEach(arquivo =>{
        fetch(BASEPAGINA_URL + 'component/' + arquivo + '?pagina=' + pagina)
            .then(response => response.text())
            .then(html =>{
                if(arquivo === 'listar_comandos_detalhes.php'){
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

// Carrega a primeira página ao abrir
document.addEventListener('DOMContentLoaded', function (){
    carregarPagina();
});
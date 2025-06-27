/* let BASEPAGINA_URL = './';

const pathnamePagina = window.location.pathname;

if(pathnamePagina.includes('/public/')){ // INDEX
    BASEPAGINA_URL = '../admin/';
}

if(pathnamePagina.includes('/admin/pages/')){ // DASHBOARD
    BASEPAGINA_URL = '../';
}

function carregarPagina(pagina = 1){
    fetch(BASEPAGINA_URL+ 'component/listar_comandos_usuario.php?pagina=' + pagina)
        .then(response => response.text())
        .then(html =>{
            document.getElementById('lista-comandos').innerHTML = html;
        })
        .catch(error =>{
            console.error('Erro ao carregar os comandos:', error);
        });
        
}

// Carrega a primeira página assim que a página abrir
document.addEventListener('DOMContentLoaded', function (){
    carregarPagina();
}); */
let BASEPAGINA_URL = './';
let LISTAR_COMANDOS_ARQUIVO = 'listar_comandos_usuario.php'; // padrão (dashboard)

const pathnamePagina = window.location.pathname;

if (pathnamePagina.includes('/public/')) { // INDEX
    BASEPAGINA_URL = '../admin/';
    LISTAR_COMANDOS_ARQUIVO = 'listar_comandos_publico.php';
}

if (pathnamePagina.includes('/admin/pages/')) { // DASHBOARD
    BASEPAGINA_URL = '../';
    LISTAR_COMANDOS_ARQUIVO = 'listar_comandos_usuario.php';
}

function carregarPagina(pagina = 1) {
    fetch(BASEPAGINA_URL + 'component/' + LISTAR_COMANDOS_ARQUIVO + '?pagina=' + pagina)
        .then(response => response.text())
        .then(html => {
            document.getElementById('lista-comandos').innerHTML = html;
        })
        .catch(error => {
            console.error('Erro ao carregar os comandos:', error);
        });
}

// Carrega a primeira página ao abrir
document.addEventListener('DOMContentLoaded', function () {
    carregarPagina();
});
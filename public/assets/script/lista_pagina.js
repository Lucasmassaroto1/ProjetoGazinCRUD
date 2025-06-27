let BASEPAGINA_URL = './';

const pathnamePagina = window.location.pathname;

if(pathnamePagina.includes('/public/')){ // INDEX
    BASEPAGINA_URL = '../admin/';
}

if(pathnamePagina.includes('/admin/pages/')){ // DASHBOARD
    BASEPAGINA_URL = '../';
}


function carregarPagina(pagina = 1) {
    fetch(BASEPAGINA_URL+ 'component/listar_comandos.php?pagina=' + pagina)
        .then(response => response.text())
        .then(html => {
            document.getElementById('lista-comandos').innerHTML = html;
        })
        .catch(error => {
            console.error('Erro ao carregar os comandos:', error);
        });
        
}

// Carrega a primeira página assim que a página abrir
document.addEventListener('DOMContentLoaded', function () {
    carregarPagina();
});
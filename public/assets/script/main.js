// ================= FILTRO =================
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

// ================= TEMPO =================
let BASE_URL = './';

const pathname = window.location.pathname;

if(pathname.includes('/public/')){ // INDEX
    BASE_URL = '../admin/';
}

if(pathname.includes('/admin/') && !pathname.includes('/admin/pages/')){ // DASHBOARD
    BASE_URL = './';
}

if (pathname.includes('/admin/pages/')){ // OUTRAS PÁGINAS
    BASE_URL = '../';
}

let statusBot = "online";
let intervaloRelogio;
let segundosUptime = 0;
const statusSpan = document.querySelector(".status");
const botaoligdes = document.getElementById("lig-des");

function atualizaRelogio(){
    segundosUptime++;

    const horas = Math.floor(segundosUptime / 3600);
    const minutos = Math.floor((segundosUptime % 3600) / 60);
    const segundos = segundosUptime % 60;

    const horaFormatada = `${horas.toString().padStart(2, '0')}h ${minutos.toString().padStart(2, '0')}m ${segundos.toString().padStart(2, '0')}s`;

    document.getElementById('uptime').textContent = horaFormatada;
}

function buscarStatus(){
    fetch(BASE_URL + 'component/getStatus.php')
    .then(res => res.json())
    .then(data =>{
        statusBot = data.status;
        atualizaStatus();

        if(statusBot === "online"){
            const horaSalva = new Date(data.hora);
            const agora = new Date();

            const diffEmSegundos = Math.floor((agora - horaSalva) / 1000);
            segundosUptime = diffEmSegundos > 0 ? diffEmSegundos : 0;

            atualizaRelogio();
            intervaloRelogio = setInterval(atualizaRelogio, 1000);
            botaoligdes.textContent = "Desligar";
        }else{
            clearInterval(intervaloRelogio);
            segundosUptime = 0;
            document.getElementById('uptime').textContent = '00h 00m 00s';
            botaoligdes.textContent = "Ligar";
        }
    });
}

function ligdes(){
    const acao = statusBot === "online" ? "desligar" : "ligar";

    fetch(BASE_URL + 'component/statusBot.php',{
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'status=' + acao
    })
    .then(response => response.json())
    .then(data =>{
        buscarStatus();
    })
    .catch(error =>{
        alert('Erro na requisição: ' + error);
    });
}

function atualizaStatus(){
    statusSpan.textContent = statusBot === "online" ? "Online" : "Offline";
    statusSpan.classList.remove("online", "offline");
    statusSpan.classList.add(statusBot);
}

buscarStatus();

// ================= LISTA_PAGINA =================
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

let categoriaAtual = '';

function carregarPagina(pagina = 1, categoria = null){
    if(categoria !== null){
        categoriaAtual = categoria;
    }

    LISTAR_COMANDOS_ARQUIVO.forEach(arquivo =>{
        let url = BASEPAGINA_URL + 'component/' + arquivo + '?pagina=' + pagina;
        if(categoriaAtual !== ''){
            url += '&categoria=' + encodeURIComponent(categoriaAtual);
        }

        fetch(url)
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
function filtrarPorCategoria(){
    const categoriaSelecionada = document.getElementById('filtro-categoria').value;
    carregarPagina(1, categoriaSelecionada); // reinicia para página 1
}

document.addEventListener('DOMContentLoaded', function (){
    carregarPagina();
});
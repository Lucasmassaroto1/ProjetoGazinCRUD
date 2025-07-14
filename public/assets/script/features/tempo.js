let BASE_URL = './';

const pathname = window.location.pathname;

if(pathname.includes('/public/')){ // INDEX
    BASE_URL = '../admin/';
}else if(pathname.includes('/views/painel')){ // TODAS PÁGINAS
    BASE_URL = '../../../admin/';
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
    fetch(BASE_URL + '/components/sistema/getStatus.php')
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

    fetch(BASE_URL + '/components/sistema/statusBot.php',{
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
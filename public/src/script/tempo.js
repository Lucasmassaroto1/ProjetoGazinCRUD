/* let statusBot = "online";
let intervaloRelogio;
const statusSpan = document.querySelector(".status");
const botaoligdes = document.getElementById("lig-des");

function atualizaRelogio(){
    var agora = new Date(); 
    var hora = agora.getHours();
    var minutos = agora.getMinutes();
    var segundos = agora.getSeconds();
    hora = hora < 10 ? '0' + hora : hora;
    minutos = minutos < 10 ? '0' + minutos : minutos;
    segundos = segundos < 10 ? '0' + segundos : segundos;
    var horaAtual = `${hora}h ${minutos}m ${segundos}s`;
    document.getElementById('uptime').textContent = `${horaAtual}`;
}

function ligdes(){
    if(statusBot === "online"){
        statusBot = "offline";
        botaoligdes.textContent = "Desligado";
        clearInterval(intervaloRelogio);
        document.getElementById('uptime').textContent = '00h 00m 00s';
    } else{
        statusBot = "online";
        botaoligdes.textContent = "Ligado";
        atualizaRelogio();
        intervaloRelogio = setInterval(atualizaRelogio, 1000);
    }
    atualizaStatus();
}

function atualizaStatus(){
    statusSpan.textContent = statusBot === "online" ? "Online" : "Offline";
    statusSpan.classList.remove("online", "offline");
    statusSpan.classList.add(statusBot);
}

atualizaStatus();
intervaloRelogio = setInterval(atualizaRelogio, 1000); */


let statusBot = "online";
let intervaloRelogio;
const statusSpan = document.querySelector(".status");
const botaoligdes = document.getElementById("lig-des");

function atualizaRelogio(){
    var agora = new Date(); 
    var hora = agora.getHours();
    var minutos = agora.getMinutes();
    var segundos = agora.getSeconds();
    hora = hora < 10 ? '0' + hora : hora;
    minutos = minutos < 10 ? '0' + minutos : minutos;
    segundos = segundos < 10 ? '0' + segundos : segundos;
    var horaAtual = `${hora}h ${minutos}m ${segundos}s`;
    document.getElementById('uptime').textContent = `${horaAtual}`;
}

function buscarStatus(){
    fetch('../admin/component/getStatus.php')
    .then(res => res.json())
    .then(data => {
        statusBot = data.status;
        atualizaStatus();

        if(statusBot === "online"){
            atualizaRelogio();
            intervaloRelogio = setInterval(atualizaRelogio, 1000);
            botaoligdes.textContent = "Desligar";
        }else{
            clearInterval(intervaloRelogio);
            document.getElementById('uptime').textContent = '00h 00m 00s';
            botaoligdes.textContent = "Ligar";
        }
    });
}

function ligdes(){
    const acao = statusBot === "online" ? "desligar" : "ligar";

    fetch('../admin/component/statusBot.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'status=' + acao
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensagem || data.erro);
        buscarStatus();
    })
    .catch(error => {
        alert('Erro na requisição: ' + error);
    });
}

function atualizaStatus(){
    statusSpan.textContent = statusBot === "online" ? "Online" : "Offline";
    statusSpan.classList.remove("online", "offline");
    statusSpan.classList.add(statusBot);
}

buscarStatus();
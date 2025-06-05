/* ============== BLOCO DO MENU LATERAL ==============*/
const botao = document.querySelector('.toggle');
const menuLateral = document.querySelector('.menu-lateral');
const conteudo = document.querySelector('.conteudo');
const background = document.querySelector('.background');

function fecharMenu(){
    botao.classList.remove('ativo')
    menuLateral.classList.remove('ativo')
    conteudo.classList.remove('ativo')
    background.classList.remove('ativo')
}
if(botao && menuLateral && conteudo && background){
    botao.addEventListener('click', () => {
        botao.classList.toggle('ativo');
        menuLateral.classList.toggle('ativo');
        conteudo.classList.toggle('ativo');
        background.classList.toggle('ativo');
    });
    background.addEventListener('click', fecharMenu);
}

/* 
    ==============Bloco que atualiza o status do bot no card==============
*/
const statusBot = "online";
const statusSpan = document.querySelector(".card-body .status");

statusSpan.textContent = statusBot === "online" ? "Online" : "Offline";
statusSpan.classList.remove("online", "offline");
statusSpan.classList.add(statusBot);

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
setInterval(atualizaRelogio, 1000);
atualizaRelogio();
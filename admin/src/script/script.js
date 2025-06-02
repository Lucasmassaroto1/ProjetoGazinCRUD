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

/* 
    ==============Bloco que atualiza o prefixo do bot no card
    mantendo o prefixo original==============
*/
document.addEventListener("DOMContentLoaded", () =>{
    const input = document.querySelector(".input-prefix");
    const prefixOriginal = document.querySelector(".status-prefix.online");
    const prefixCustomizado = document.querySelector(".status-prefix.offline");

    input.addEventListener("keydown", (event) =>{
        if (event.key === "Enter" && input.value.trim() !== ""){
            const novoPrefixo = input.value.trim();
            prefixCustomizado.textContent = novoPrefixo;
            prefixOriginal.classList.remove("online");
            prefixOriginal.classList.add("offline");
            prefixCustomizado.classList.remove("offline");
            prefixCustomizado.classList.add("online");
            input.value = "";
        }
    });
});
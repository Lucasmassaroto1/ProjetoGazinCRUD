/* ============== BLOCO DO MENU LATERAL ==============*/
const botao = document.querySelector('.toggle');
const menuLateral = document.querySelector('.menu-lateral');
const conteudo = document.querySelector('.conteudo');
const background = document.querySelector('.background');

// ========== MENU LATERAL ==========
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

// ========== IDICADOR DE PÁGINA ATIVA ==========
const links = document.querySelectorAll('.menu-lateral ul li a');
const currentPath = window.location.pathname;

links.forEach(link =>{
    if(link.pathname === currentPath){
        link.classList.add('link-ativo');
    }
});

let volumeAtual = 50;

fetch('../component/get_volume.php')
    .then(res => res.json())
    .then(data => {
        if(typeof data.volume === 'number'){
            volumeAtual = data.volume;
            document.getElementById('volume-valor').textContent = volumeAtual + '%';
        }
    })
    .catch(err => console.error('Erro ao buscar volume:', err));

function alterarVolume(value){
    volumeAtual = Math.max(0, Math.min(100, volumeAtual + value));
    document.getElementById('volume-valor').textContent = volumeAtual + '%';

    // Manda para o php
    fetch('../component/valida_volume.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'volume=' + encodeURIComponent(volumeAtual)
    })
    .then(res => res.json())
    .then(data => {
        if(data.status !== 'sucesso'){
            console.error('Erro ao salvar volume');
        }
    })
    .catch(err => console.error('Erro na requisição:', err));
}

// =========== AO CLICAR EM VOLUME MOSTRA A OPÇÃO PARA AUTERAR VOLUME ===========
let volumeVisible = false;

function mostravolume(){
    const volumeControls = document.getElementById("volume-controls")
    const volumeIcon = document.querySelector(".volume-icon");

    if(!volumeVisible){
        // Mostrar controles
        volumeControls.style.display = "block"
        setTimeout(() =>{
        volumeControls.classList.add("show")
        volumeIcon.classList.add("active");
        }, 10)
        volumeVisible = true
    }else{
        // Esconder controles
        volumeControls.classList.remove("show")
        volumeIcon.classList.remove("active");
        setTimeout(() =>{
        volumeControls.style.display = "none"
        }, 300)
        volumeVisible = false
    }
}
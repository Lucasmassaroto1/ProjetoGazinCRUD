let volumeAtual = 50;
function alterarVolume(value){
    volumeAtual = Math.max(0, Math.min(100, volumeAtual + value));
    document.getElementById('volume-valor').textContent = volumeAtual + '%';

    // Manda para o php
    fetch('../valida_volume.php', {
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
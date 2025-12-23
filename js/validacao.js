document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const nome = form.nome.value.trim();
        const email = form.email.value.trim();
        const mensagem = form.mensagem.value.trim();
        let erro = '';
        // Validação dos campos
        if (nome.length < 3) {
            erro = 'Nome deve ter pelo menos 3 caracteres.';
        } else if (!email.match(/^[^@\s]+@[^@\s]+\.[^@\s]+$/)) {
            erro = 'Email inválido.';
        } else if (mensagem.length < 5) {
            erro = 'Mensagem muito curta.';
        }
        if (erro) {
            alert(erro);
            e.preventDefault();
        }
    });
});
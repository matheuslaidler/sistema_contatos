<?php
// Configurações de segurança da sessão (ANTES do session_start)
ini_set('session.cookie_httponly', 1);    // JS não acessa o cookie
ini_set('session.use_strict_mode', 1);    // Rejeita IDs de sessão inválidos
// ini_set('session.cookie_secure', 1);   // Descomentar em produção com HTTPS

session_start();
require_once 'conexao.php';
require_once 'funcoes.php';

// Verifica se usuário está logado
function estaLogado() {
    return isset($_SESSION['usuario_id']);
}

// Bloqueia acesso a páginas protegidas
function exigirLogin() {
    if (!estaLogado()) {
        mensagemSessao('erro', 'Você precisa estar logado para acessar esta página.');
        redirecionar('login.php');
    }
}

// Retorna dados do usuário logado
function usuarioAtual() {
    return [
        'id' => $_SESSION['usuario_id'] ?? null,
        'nome' => $_SESSION['usuario_nome'] ?? null,
        'email' => $_SESSION['usuario_email'] ?? null
    ];
}
?>

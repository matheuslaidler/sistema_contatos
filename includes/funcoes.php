<?php
// Limpa string contra XSS - converte caracteres especiais em entidades HTML
function sanitizar($string) {
    return trim(htmlspecialchars($string, ENT_QUOTES, 'UTF-8'));
}

// Redireciona e para a execução (importante o exit!)
function redirecionar($url) {
    header("Location: $url");
    exit;
}

// Sistema de mensagens flash - persiste entre requisições via sessão
function mensagemSessao($tipo, $texto) {
    $_SESSION['mensagem'] = ['tipo' => $tipo, 'texto' => $texto];
}

function exibirMensagem() {
    if (isset($_SESSION['mensagem'])) {
        $msg = $_SESSION['mensagem'];
        $classe = $msg['tipo'] == 'sucesso' ? 'msg-sucesso' : 'msg-erro';
        echo "<div class='mensagem $classe'>{$msg['texto']}</div>";
        unset($_SESSION['mensagem']);  // Remove após exibir (só mostra uma vez)
    }
}

// Proteção CSRF - gera input hidden com token único
function csrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
}

// Valida se o token enviado bate com o da sessão
function validarCsrf() {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Requisição inválida - token CSRF não confere');
    }
}
?>

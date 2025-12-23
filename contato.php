<?php
require_once 'includes/auth.php';

if (!estaLogado()) {
    redirecionar('login.php');
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    validarCsrf();
    $nome = sanitizar($_POST['nome']);
    $email = sanitizar($_POST['email']);
    $mensagem = sanitizar($_POST['mensagem']);
    if (strlen($nome) < 3) {
        $erro = 'Nome deve ter pelo menos 3 caracteres';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Email inválido';
    } elseif (strlen($mensagem) < 5) {
        $erro = 'Mensagem muito curta';
    } else {
        $stmt = $pdo->prepare("INSERT INTO mensagens (usuario_id, nome, email, mensagem, data_envio) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([usuarioAtual()['id'], $nome, $email, $mensagem]);
        mensagemSessao('sucesso', 'Mensagem enviada com sucesso!');
        redirecionar('mensagens.php');
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Contato</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Nova Mensagem</h1>
        <div class="card">
            <?php if ($erro): ?>
                <div class="mensagem msg-erro"><?php echo $erro; ?></div>
            <?php endif; ?>
            <form method="POST">
                <?php echo csrfToken(); ?>
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Mensagem</label>
                    <textarea name="mensagem" required></textarea>
                </div>
                <button type="submit" class="full">Enviar</button>
            </form>
            <div class="links">
                <a href="mensagens.php">Ver mensagens</a>
            </div>
        </div>
    </div>
	<script src="js/validacao.js"></script>
</body>
</html>

<?php
require_once 'includes/auth.php';

if (estaLogado()) {
    redirecionar('index.php');
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    validarCsrf();
    $email = sanitizar($_POST['email']);
    $senha = $_POST['senha'];
    $stmt = $pdo->prepare("SELECT id, nome, email, senha FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        session_regenerate_id(true);
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];
        mensagemSessao('sucesso', 'Login realizado com sucesso!');
        redirecionar('index.php');
    } else {
        $erro = 'Email ou senha incorretos';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Entrar</h1>
        <div class="card">
            <?php exibirMensagem(); ?>
            <?php if ($erro): ?>
                <div class="mensagem msg-erro"><?php echo $erro; ?></div>
            <?php endif; ?>
            <form method="POST">
                <?php echo csrfToken(); ?>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" name="senha" required>
                </div>
                <button type="submit" class="full">Entrar</button>
            </form>
            <div class="links">
                <p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
            </div>
        </div>
    </div>
</body>
</html>

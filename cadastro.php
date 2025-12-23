<?php
require_once 'includes/auth.php';

if (estaLogado()) {
    redirecionar('index.php');
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    validarCsrf();
    $nome = sanitizar($_POST['nome']);
    $email = sanitizar($_POST['email']);
    $senha = $_POST['senha'];
    $confirma = $_POST['confirma'];
    if (strlen($nome) < 3) {
        $erro = 'Nome deve ter pelo menos 3 caracteres';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Email inválido';
    } elseif (strlen($senha) < 6) {
        $erro = 'Senha deve ter pelo menos 6 caracteres';
    } elseif ($senha !== $confirma) {
        $erro = 'As senhas não conferem';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $erro = 'Este email já está cadastrado';
        } else {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $email, $hash]);
            mensagemSessao('sucesso', 'Conta criada com sucesso! Faça login.');
            redirecionar('login.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Criar Conta</h1>
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
                    <label>Senha</label>
                    <input type="password" name="senha" required>
                </div>
                <div class="form-group">
                    <label>Confirmar Senha</label>
                    <input type="password" name="confirma" required>
                </div>
                <button type="submit" class="full">Cadastrar</button>
            </form>
            <div class="links">
                <p>Já tem conta? <a href="login.php">Faça login</a></p>
            </div>
        </div>
    </div>
</body>
</html>

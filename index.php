<?php require_once 'includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Contatos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="nav">
        <strong>Sistema de Contatos</strong>
        <div>
            <?php if (estaLogado()): ?>
                <span>Olá, <?php echo htmlspecialchars(usuarioAtual()['nome']); ?></span>
                <a href="contato.php">Enviar Mensagem</a>
                <a href="mensagens.php">Minhas Mensagens</a>
                <a href="logout.php">Sair</a>
            <?php else: ?>
                <a href="login.php">Entrar</a>
                <a href="cadastro.php">Cadastrar</a>
            <?php endif; ?>
        </div>
    </nav>
    <div class="container">
        <h1>Bem-vindo!</h1>
        <div class="card">
            <?php if (estaLogado()): ?>
                <p>Você está logado como <strong><?php echo htmlspecialchars(usuarioAtual()['email']); ?></strong>.</p>
                <br>
                <a href="contato.php" class="btn full">Enviar Nova Mensagem</a>
            <?php else: ?>
                <p>Para enviar mensagens, você precisa estar logado.</p>
                <br>
                <div style="display: flex; gap: 10px;">
                    <a href="login.php" class="btn" style="flex:1;">Entrar</a>
                    <a href="cadastro.php" class="btn" style="flex:1;">Criar Conta</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

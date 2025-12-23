<?php
require_once 'includes/auth.php';

if (!estaLogado()) {
    redirecionar('login.php');
}

$stmt = $pdo->prepare("SELECT * FROM mensagens WHERE usuario_id = ? ORDER BY data_envio DESC");
$stmt->execute([usuarioAtual()['id']]);
$mensagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Mensagens</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Minhas Mensagens</h1>
        <div class="card">
            <?php if (empty($mensagens)): ?>
                <div class="mensagem">Nenhuma mensagem encontrada.</div>
            <?php else: ?>
                <ul class="lista-mensagens">
                    <?php foreach ($mensagens as $msg): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($msg['nome']); ?></strong> (<?php echo htmlspecialchars($msg['email']); ?>)<br>
                            <span class="data">Enviado em <?php echo date('d/m/Y H:i', strtotime($msg['data_envio'])); ?></span>
                            <p><?php echo nl2br(htmlspecialchars($msg['mensagem'])); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <div class="links">
                <a href="contato.php">Nova mensagem</a>
                <a href="index.php">Voltar</a>
            </div>
        </div>
    </div>
</body>
</html>

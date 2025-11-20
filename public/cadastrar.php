<?php
session_start();  // Certifique-se de que está no topo

// Inicializa o array de usuários na sessão, se ainda não existir
if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmaSenha = $_POST['confirmaSenha'] ?? '';

    // Validações
    $erros = [];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "E-mail inválido.";
    }
    if (strlen($senha) < 6) {
        $erros[] = "A senha deve ter pelo menos 6 caracteres.";
    }
    if ($senha !== $confirmaSenha) {
        $erros[] = "A senha e a confirmação não coincidem.";
    }

    // Verificar se o e-mail já existe
    foreach ($_SESSION['usuarios'] as $usuario) {
        if ($usuario['email'] === $email) {
            $erros[] = "E-mail já cadastrado.";
            break;
        }
    }

    if (empty($erros)) {
        // Gerar ID único e hash da senha
        $id = uniqid();
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $novoUsuario = [
            'id' => $id,
            'email' => $email,
            'senha' => $senhaHash
        ];
        $_SESSION['usuarios'][] = $novoUsuario;

        // Redirecionar para página de cadastro com flag de sucesso
        header("Location: cadastro.php?sucesso=1");
        exit;
    } else {
        // Exibe mensagem de erro simples e link para voltar
        echo "Erros: " . implode(", ", $erros) . " <a href='cadastro.php'>Voltar</a>";
    }
}
?>
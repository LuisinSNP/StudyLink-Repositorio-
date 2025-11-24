<?php
session_start();  


if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmaSenha = $_POST['confirmaSenha'] ?? '';


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

    
    foreach ($_SESSION['usuarios'] as $usuario) {
        if ($usuario['email'] === $email) {
            $erros[] = "E-mail já cadastrado.";
            break;
        }
    }

    if (empty($erros)) {
        
        $id = uniqid();
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $novoUsuario = [
            'id' => $id,
            'email' => $email,
            'senha' => $senhaHash
        ];
        $_SESSION['usuarios'][] = $novoUsuario;

       
        header("Location: cadastro.php?sucesso=1");
        exit;
    } else {
        
        echo "Erros: " . implode(", ", $erros) . " <a href='cadastro.php'>Voltar</a>";
    }
}
?>
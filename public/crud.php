<?php
session_start();

if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}


if (isset($_POST['acao']) && $_POST['acao'] === 'atualizar_cargo') {
    $idEditar = $_POST['id'] ?? '';
    $cargo = $_POST['cargo'] ?? 'Usuário';

    foreach ($_SESSION['usuarios'] as &$u) {
        if ($u['id'] === $idEditar) {
            $u['cargo'] = $cargo;
            break;
        }
    }
    unset($u);
    header("Location: crud.php");
    exit;
}


if (isset($_GET['excluir'])) {
    $idExcluir = $_GET['excluir'];
    $_SESSION['usuarios'] = array_filter($_SESSION['usuarios'], function($u) use ($idExcluir) {
        return $u['id'] !== $idExcluir;
    });
    header("Location: crud.php");
    exit;
}


if (isset($_GET['reset'])) {
    session_destroy();
    header("Location: crud.php");
    exit;
}

$mensagem = isset($_GET['msg']) ? $_GET['msg'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<title>Administração: Usuários Logados com Cargo</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
<link href="css/style.css" rel="stylesheet" />
</head>
<body>

<header>
    <div class="logo">
        <img src="img/logo.PNG" width="32" height="32" alt="logo">
        Administração Study Link
    </div>
   
</header>

<main>
    <h1>Usuários Cadastrados</h1>
    <p class="subtitle">Atribua cargos aos usuários cadastrados pelo sistema</p>

    <?php if ($mensagem): ?>
        <div class="alert" role="alert"><?php echo htmlspecialchars($mensagem); ?></div>
    <?php endif; ?>

    <table aria-describedby="tabela-desc">
        <caption id="tabela-desc" class="sr-only">Lista de usuários cadastrados</caption>
        <thead>
            <tr>
                <th>ID</th>
                <th>E-mail</th>
                <th>Cargo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($_SESSION['usuarios'])): ?>
            <tr><td colspan="4" style="color:#999; font-style: italic;">Nenhum usuário cadastrado.</td></tr>
        <?php else: ?>
            <?php foreach ($_SESSION['usuarios'] as $u): ?>
                <tr>
                    <td><?php echo htmlspecialchars($u['id']); ?></td>
                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                    <td>
                        <form method="post" style="margin:0;">
                            <input type="hidden" name="acao" value="atualizar_cargo">
                            <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                            <select name="cargo" onchange="this.form.submit()" aria-label="Selecionar cargo para <?php echo htmlspecialchars($u['email']); ?>">
                                <option value="Usuário" <?php echo (!isset($u['cargo']) || $u['cargo'] === 'Usuário') ? 'selected' : ''; ?>>Usuário</option>
                                <option value="Moderador" <?php echo (isset($u['cargo']) && $u['cargo'] === 'Moderador') ? 'selected' : ''; ?>>Moderador</option>
                                <option value="Administrador" <?php echo (isset($u['cargo']) && $u['cargo'] === 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <a 
                          href="?excluir=<?php echo $u['id']; ?>" 
                          onclick="return confirm('Apagar este usuário?');" 
                          class="btn-excluir" 
                          aria-label="Apagar usuário <?php echo htmlspecialchars($u['email']); ?>"
                        >
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M3 6h18v2H3V6zm3 3h12v12H6V9zm5 2v6h2v-6h-2z"/></svg>
                            Apagar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="links-bottom">
        <a href="?reset=1" onclick="return confirm('Deseja limpar todos os usuários e reiniciar?');" title="Limpar todos usuários">Limpar Sessão</a>
    </div>
</main>

<footer>
    &copy; <?php echo date("Y"); ?> Administração StudyLink - Sistema de Usuários
</footer>

</body>
</html>
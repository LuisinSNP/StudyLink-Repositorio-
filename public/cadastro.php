<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Study Link - Cadastre-se</title>
    <link rel="stylesheet" href="css/cadastro.css" />
</head>
<body>
    <div class="header">Tela Cadastro</div>

    <div class="container">
        <div class="logo-section">
            <div class="logo">
                <img src="img/logo.PNG" width="290" height="200" alt="Study Link Logo" />
            </div>
            <div class="brand-name">Study<br>Link</div>
        </div>

        <div class="form-section">
            <div class="form-header">
                <h2>Cadastre-se</h2>
                
            </div>

            <form id="cadastroForm" method="POST" action="cadastrar.php">
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="E-mail" required />
                </div>

                <div class="form-group">
                    <input type="password" id="senha" name="senha" placeholder="Senha" required />
                </div>

                <div class="form-group">
                    <input type="password" id="confirmaSenha" name="confirmaSenha" placeholder="Confirme a senha" required />
                </div>

                <button type="submit" class="submit-btn" id="submitBtn">Cadastrar</button>
            </form>

            <div class="message" id="message"></div>

            <?php
            
            if (isset($_GET['sucesso']) && $_GET['sucesso'] == '1') {
                echo '<div style="margin-top: 20px; color: green; font-weight: bold; text-align: center;">
                        Cadastro concluído
                      </div>';
            }
            ?>
        </div>
    </div>

</body>
</html>
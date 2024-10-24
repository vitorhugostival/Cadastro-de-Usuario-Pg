<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
    <link rel="stylesheet" href="style.css" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>

<div class="header">
    <h1>Cadastro de Usuários</h1>
</div>

<div class="container">
    <div class="form">
        <div class="buttons" id="default-buttons">
            <button class="new btn btn-primary" onclick="novo()">Novo</button>
            <button class="search btn btn-primary" onclick="window.location.href='pesquisar.php'">Buscar</button>
            <button class="edit btn btn-primary" onclick="window.location.href='atualizaocaodeusuario.php'">Alterar</button>
            <button class="delete btn btn-danger" onclick="excluir()" href='delet.php'>Excluir</button>


        </div>
    <br>
    
        <div class="buttons" id="new-button" style="display: none;">
            <button class="back btn btn-secondary" onclick="voltar()">Voltar</button>
        </div>

        <form action="cadastro.php" method="POST" class="center-form">
            <div class="Conteudo">
                <input type="text" id="id_usuario" name="id_usuario" class="form-control" placeholder="* ID do Usuário" required>
                <br>
                <select id="nivel_usuario" name="nivel_usuario" class="form-control" required>
                    <option value="" disabled selected>* Nível de Usuário</option>
                    <option value="Padrao">Padrão</option>
                    <option value="Adm">Administrador</option>
                </select>
                <br>
                <input type="text" id="nome_usuario" name="nome_usuario" class="form-control" placeholder="* Nome" required>
                <br>
                <input type="text" id="sobrenome" name="sobrenome" class="form-control" placeholder="* Sobrenome" required>
                <br>
                <input type="text" id="funcao" name="funcao" class="form-control" placeholder="* Função" required>
                <br>
                <input type="text" id="logi" name="logi" class="form-control" placeholder="* Login" required>
                <br>
                <input type="password" id="senha" name="senha" class="form-control" placeholder="* Senha" required>
                <br>
                <button type="submit" class="btn btn-primary" id="cadastroButton">Cadastro</button>
            </div>
        </form>
    </div>
</div>

<footer>
    <div class="BotoesFooter">
        <div class="buttons-search">
            <a href="../../Home Page/HTML/home.html">
                <button class="search btn btn-primary">Sair</button>
            </a>
        </div>
    </div>
</footer>

<div class="logo">
    <img src="../Fotos/Emporio maxx s-fundo.png" alt="Empório Maxx Logo">
</div>

<h2>Tabela de Cadastro</h2><br>

<?php 
    include("conexao.php");

    // Consulta SQL ajustada para o PostgreSQL
    $sql = "SELECT id_usuario, nivel_usuario, nome_usuario, sobrenome, funcao, logi, senha FROM usuario";
    $resultado = pg_query($conexao, $sql);

    // Verifica se a consulta foi bem-sucedida
    if (!$resultado) {
        die("Erro na consulta: " . pg_last_error());
    }

    // Verifica se a consulta retorna resultados
    if (pg_num_rows($resultado) > 0) {
        echo "<table class='table table-striped'>
                <thead>
                    <tr>
                        <th>ID do Usuário</th>
                        <th>Nível</th>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Função</th>
                        <th>Login</th>
                        <th>Senha</th> <!-- Adicionando coluna para senha -->
                    </tr>
                </thead>
                <tbody>";
        
        // Loop pelos resultados e exibição na tabela
        while ($row = pg_fetch_assoc($resultado)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['id_usuario']) . "</td>
                    <td>" . htmlspecialchars($row['nivel_usuario']) . "</td>
                    <td>" . htmlspecialchars($row['nome_usuario']) . "</td>
                    <td>" . htmlspecialchars($row['sobrenome']) . "</td>
                    <td>" . htmlspecialchars($row['funcao']) . "</td>
                    <td>" . htmlspecialchars($row['logi']) . "</td>
                    <td>****</td> <!-- Ocultando a senha -->
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p>Zero Resultados</p>";
    }

    // Fechar a conexão
    pg_close($conexao);
?>

<script>
    function novo() {
        document.getElementById('default-buttons').style.display = 'none';
        document.getElementById('new-button').style.display = 'flex'; 
        habilitarCampos(); 
    }

    function voltar() {
        document.getElementById('new-button').style.display = 'none';
        document.getElementById('default-buttons').style.display = 'flex'; 
        desabilitarCampos(); 
    }

    function habilitarCampos() {
        document.getElementById('nivel_usuario').disabled = false;
        document.getElementById('nome_usuario').disabled = false;
        document.getElementById('sobrenome').disabled = false;
        document.getElementById('funcao').disabled = false;
        document.getElementById('logi').disabled = false;
        document.getElementById('senha').disabled = false;
        document.getElementById('cadastroButton').disabled = false;  // Habilita o botão de cadastro
    }

    function desabilitarCampos() {
        document.getElementById('nivel_usuario').disabled = true;
        document.getElementById('nome_usuario').disabled = true;
        document.getElementById('sobrenome').disabled = true;
        document.getElementById('funcao').disabled = true;
        document.getElementById('logi').disabled = true;
        document.getElementById('senha').disabled = true;
        document.getElementById('cadastroButton').disabled = true;  // Desabilita o botão de cadastro
    }

    function excluir() {
        let id = prompt("Digite o ID do usuário que deseja excluir:");
        if (id) {
            let confirmacao = confirm("Deseja realmente excluir o usuário com ID " + id + "?");
            if (confirmacao) {
                window.location.href = 'delet.php?deletar=' + id;
            }
        }
    }
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>

<?php
    include('conexao.php'); // Inclui o arquivo de conexão com o banco de dados PostgreSQL
    
    // Captura de dados do formulário com prefixo NOVO
    $NOVOid_usuario = $_POST['NOVOid_usuario']; // ID do Usuário
    $NOVOnivel_usuario = $_POST['NOVOnivel_usuario']; // Nível
    $NOVOnome_usuario = $_POST['NOVOnome_usuario']; // Nome
    $NOVOsobrenome = $_POST['NOVOsobrenome']; // Sobrenome
    $NOVOfuncao = $_POST['NOVOfuncao']; // Função
    $NOVOlogi = $_POST['NOVOlogi']; // Login
    $NOVOsenha = $_POST['NOVOsenha']; // Senha

    // Prepara a consulta SQL para atualizar o usuário
    $sql = "UPDATE usuario SET nivel_usuario = $1, nome_usuario = $2, sobrenome = $3, funcao = $4, logi = $5, senha = $6 WHERE id_usuario = $7";
    
    // Executa a consulta utilizando os parâmetros
    $resultado = pg_query_params($conexao, $sql, array(
        $NOVOnivel_usuario,
        $NOVOnome_usuario,
        $NOVOsobrenome,
        $NOVOfuncao,
        $NOVOlogi,
        $NOVOsenha,
        $NOVOid_usuario
    ));

    // Verifica se a execução da query foi bem-sucedida
    if ($resultado) {
        echo "Dados atualizados com sucesso.<br><br>";
    } else {
        echo "Erro na atualização dos dados: " . pg_last_error($conexao);
    }

    // Fecha a conexão com o banco de dados
    pg_close($conexao);

?>
</body>
</html>

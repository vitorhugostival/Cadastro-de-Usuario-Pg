<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Estoque</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>

<?php
    include('conexao.php'); // Inclui a conexão com o banco de dados

    $deletar = $_POST['deletar'] ?? ''; // Obtém o ID do usuário a ser excluído

    // Verifica se o ID não está vazio
    if (!empty($deletar)) {
        // Primeiro, verificar se o ID existe
        $sql_verifica = "SELECT * FROM usuario WHERE id_usuario = $1"; // Consulta para verificar se o ID existe
        $resultado_verifica = pg_query_params($conexao, $sql_verifica, array($deletar));

        if (pg_num_rows($resultado_verifica) > 0) {
            // Se o ID existe, realiza a exclusão
            $sql = "DELETE FROM usuario WHERE id_usuario = $1"; // Comando para deletar o usuário
            $resultado = pg_query_params($conexao, $sql, array($deletar));

            if ($resultado) {
                echo "<h1>Usuário excluído com sucesso</h1>";
            } else {
                echo "<h1>Erro ao excluir o usuário</h1>" . pg_last_error($conexao);
            }
        } else {
            // Se o ID não existe, exibe uma mensagem de erro
            echo "<h1>Erro: Usuário não encontrado</h1>";
        }
    } else {
        // Se o ID está vazio, exibe uma mensagem de erro
        echo "<h1>Erro: ID não fornecido</h1>";
    }

    // Fecha a conexão com o banco de dados
    pg_close($conexao);
?>
</body>
</html>


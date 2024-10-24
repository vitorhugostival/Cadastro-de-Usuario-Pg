<?php
include("conexao.php"); // Conexão com o banco de dados

// Coleta de dados do formulário
$id_usuario = $_POST['id_usuario']; // Variável para ID do usuário
$nivel_usuario = $_POST['nivel_usuario']; // Atualizado para "nivel_usuario"
$nome_usuario = $_POST['nome_usuario']; // Atualizado para "nome_usuario"
$sobrenome = $_POST['sobrenome']; // Permanece como "sobrenome"
$funcao = $_POST['funcao']; // Permanece como "funcao"
$logi = $_POST['logi']; // Permanece como "logi"
$senha = $_POST['senha']; // Captura a senha diretamente

// Verifica se o ID já existe
$check_id_sql = "SELECT id_usuario FROM usuario WHERE id_usuario = $1";
$resultado = pg_query_params($conexao, $check_id_sql, array($id_usuario));

if (!$resultado) {
    echo "Erro ao verificar o ID: " . pg_last_error($conexao);
    exit;
}

if (pg_num_rows($resultado) > 0) {
    // Se o ID já existir, retorne erro
    echo "Erro: Este ID já está cadastrado.";
} else {
    // Verifica se o login (logi) já existe
    $check_logi_sql = "SELECT logi FROM usuario WHERE logi = $1";
    $resultado = pg_query_params($conexao, $check_logi_sql, array($logi)); // Usa pg_query_params

    if (!$resultado) {
        echo "Erro ao verificar o login: " . pg_last_error($conexao);
        exit;
    }

    if (pg_num_rows($resultado) > 0) {
        // Se o login já existir, retorne erro
        echo "Erro: Este login já está cadastrado.";
    } else {
        // Caso o login e ID sejam novos, prossiga com o cadastro

        // Preparar a SQL para inserir o usuário no banco de dados
        $sql = "INSERT INTO usuario (id_usuario, nivel_usuario, nome_usuario, sobrenome, funcao, logi, senha) VALUES ($1, $2, $3, $4, $5, $6, $7)";
        $stmt = pg_prepare($conexao, "insert_usuario", $sql);
        
        // Executar a inserção e verifica se foi bem-sucedida
        $resultado = pg_execute($conexao, "insert_usuario", array($id_usuario, $nivel_usuario, $nome_usuario, $sobrenome, $funcao, $logi, $senha));

        if ($resultado) {
            echo "Usuário cadastrado com sucesso.";
        } else {
            echo "Erro ao cadastrar: " . pg_last_error($conexao);
        }
    }
}

// Fecha a conexão
pg_close($conexao);
?>

<?php
session_start();
include('conexao.php'); // conexão com o banco

// Verifica se todos os campos foram enviados
if (
    empty($_POST['nome_completo']) ||
    empty($_POST['data_nascimento']) ||
    empty($_POST['rua']) ||
    empty($_POST['bairro']) ||
    empty($_POST['numero']) ||
    empty($_POST['cep']) ||
    empty($_POST['tipo_responsavel']) ||
    empty($_POST['curso'])
) {
    $_SESSION['mensagem'] = "Preencha todos os campos obrigatórios!";
    header('Location: formc.php');
    exit();
}

// Recebe os dados e protege contra SQL injection
$nome_completo    = mysqli_real_escape_string($conexao, trim($_POST['nome_completo']));
$data_nascimento  = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
$nome_responsavel = mysqli_real_escape_string($conexao, trim($_POST['nome_responsavel']));
$rua              = mysqli_real_escape_string($conexao, trim($_POST['rua']));
$bairro           = mysqli_real_escape_string($conexao, trim($_POST['bairro']));
$numero           = mysqli_real_escape_string($conexao, trim($_POST['numero']));
$cep              = mysqli_real_escape_string($conexao, trim($_POST['cep']));
$tipo_responsavel = mysqli_real_escape_string($conexao, trim($_POST['tipo_responsavel']));
$curso            = mysqli_real_escape_string($conexao, trim($_POST['curso']));

// Insere no banco
$sql = "INSERT INTO cadastro 
        (nome_completo, data_nascimento, nome_responsavel, rua, bairro, numero, cep, tipo_responsavel, curso)
        VALUES
        ('$nome_completo', '$data_nascimento', '$nome_responsavel', '$rua', '$bairro', '$numero', '$cep', '$tipo_responsavel', '$curso')";

if (mysqli_query($conexao, $sql)) {
    $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
    header('Location: painel.php'); // VOLTA PARA O PAINEL
    exit();
} else {
    $_SESSION['mensagem'] = "Erro ao cadastrar: " . mysqli_error($conexao);
    header('Location: formc.php');
    exit();
}
?>
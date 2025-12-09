<?php
session_start();
require_once 'conexao.php';

// Verifica se todos os campos foram enviados
if (!isset($_POST['id'])) {
    $_SESSION['msg'] = "Erro: dados incompletos!";
    header("Location: lista.php");
    exit;
}

$id = intval($_POST['id']);

// Campos
$nome = $_POST['nome_completo'];
$data_nascimento = $_POST['data_nascimento'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cep = $_POST['cep'];
$nome_responsavel = $_POST['nome_responsavel'];
$tipo_responsavel = $_POST['tipo_responsavel'];
$curso = $_POST['curso'];

// Query
$sql = "UPDATE cadastro 
        SET nome_completo=?, data_nascimento=?, rua=?, numero=?, bairro=?, cep=?, 
            nome_responsavel=?, tipo_responsavel=?, curso=? 
        WHERE id=?";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param(
    $stmt,
    "sssssssssi",
    $nome, $data_nascimento, $rua, $numero, $bairro, $cep,
    $nome_responsavel, $tipo_responsavel, $curso, $id
);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['msg'] = "Aluno atualizado com sucesso!";
} else {
    $_SESSION['msg'] = "Erro ao atualizar aluno!";
}

mysqli_stmt_close($stmt);
mysqli_close($conexao);

// 🔥 Redireciona para exibir.php
header("Location: lista.php");
exit;
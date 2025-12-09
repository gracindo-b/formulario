<?php
include('conexao.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM cadastro WHERE id = $id";
    if (mysqli_query($conexao, $sql)) {
        header("Location: lista.php?msg=excluido");
        exit();
    } else {
        echo "Erro ao excluir: " . mysqli_error($conexao);
    }
} else {
    echo "ID inválido.";
}
?>

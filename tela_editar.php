<?php
session_start();
require_once 'conexao.php';

// Verifica se recebeu um ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['msg'] = "ID inválido!";
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

// Busca o aluno no banco
$sql = "SELECT * FROM cadastro
 WHERE id = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$aluno = mysqli_fetch_assoc($result);

if (!$aluno) {
    $_SESSION['msg'] = "Aluno não encontrado!";
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Editar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <section class="h-100 mt-5">
        <div class="container h-100">
            <div class="row justify-content-sm-center">
                <div class="col-xl-6 col-lg-7 col-md-8 col-sm-10">
                    
                    <div class="card shadow-lg">
                        <div class="card-body p-5">
                            <h1 class="fs-4 card-title fw-bold mb-4 text-center">Editar Aluno</h1>

                            <form action="editar.php" method="POST" class="needs-validation" autocomplete="off">

                                <input type="hidden" name="id" value="<?= $aluno['id'] ?>">

                                <div class="mb-3">
                                    <label class="mb-2 text-muted">Nome Completo</label>
                                    <input type="text" class="form-control" name="nome_completo" 
                                           value="<?= $aluno['nome_completo'] ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted">Data de Nascimento</label>
                                    <input type="date" class="form-control" name="data_nascimento"
                                           value="<?= $aluno['data_nascimento'] ?>" required>
                                </div>

                                <h5 class="mt-4 mb-2">Endereço</h5>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted">Rua</label>
                                    <input type="text" class="form-control" name="rua" value="<?= $aluno['rua'] ?>" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="mb-2 text-muted">Número</label>
                                        <input type="text" class="form-control" name="numero" value="<?= $aluno['numero'] ?>" required>
                                    </div>

                                    <div class="col-md-8 mb-3">
                                        <label class="mb-2 text-muted">Bairro</label>
                                        <input type="text" class="form-control" name="bairro" value="<?= $aluno['bairro'] ?>" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted">CEP</label>
                                    <input type="text" class="form-control" name="cep" value="<?= $aluno['cep'] ?>" required>
                                </div>

                                <h5 class="mt-4 mb-2">Responsável</h5>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted">Nome do Responsável</label>
                                    <input type="text" class="form-control" name="nome_responsavel"
                                           value="<?= $aluno['nome_responsavel'] ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted">Tipo de Responsável</label>
                                    <input type="text" class="form-control" name="tipo_responsavel"
                                           value="<?= $aluno['tipo_responsavel'] ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted">Curso</label>
                                    <input type="text" class="form-control" name="curso" value="<?= $aluno['curso'] ?>" required>
                                </div>

                                <div class="d-flex mt-4">
                                    <a href="lista.php" class="btn btn-secondary me-3">Cancelar</a>
                                    <button type="submit" class="btn btn-primary ms-auto">Salvar</button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</body>
</html>
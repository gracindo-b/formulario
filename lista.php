<?php
session_start();
include('conexao.php'); // Conexão com o banco

// Verifica se há pesquisa
$busca = "";
if (isset($_GET['buscar']) && $_GET['buscar'] != "") {
    $busca = mysqli_real_escape_string($conexao, $_GET['buscar']);
    $sql = "SELECT * FROM cadastro 
            WHERE nome_completo LIKE '%$busca%' 
            ORDER BY nome_completo ASC";
} else {
    $sql = "SELECT * FROM cadastro ORDER BY nome_completo ASC";
}

$result = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link active" href="lista.php">Lista</a></li>
        <li class="nav-item"><a class="nav-link" href="painel.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="formc.php">Cadastro</a></li>
      </ul>

      <a class="btn btn-outline-secondary" href="logout.php">Sair</a>
    </div>

  </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Lista de Alunos Cadastrados</h2>

    <!-- CAMPO DE PESQUISA -->
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="buscar" 
                   class="form-control" 
                   placeholder="Pesquisar aluno por nome..."
                   value="<?= $busca; ?>">

            <button class="btn btn-primary">Pesquisar</button>

            <?php if ($busca != ""): ?>
                <a href="lista.php" class="btn btn-secondary">Limpar</a>
            <?php endif; ?>
        </div>
    </form>

    <?php if(mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nome Completo</th>
                        <th>Data de Nascimento</th>
                        <th>Nome do Responsável</th>
                        <th>Tipo do Responsável</th>
                        <th>Rua</th>
                        <th>Bairro</th>
                        <th>Número</th>
                        <th>CEP</th>
                        <th>Curso</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($aluno = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($aluno['nome_completo']); ?></td>
                            <td><?= htmlspecialchars($aluno['data_nascimento']); ?></td>
                            <td><?= htmlspecialchars($aluno['nome_responsavel']); ?></td>
                            <td><?= htmlspecialchars($aluno['tipo_responsavel']); ?></td>
                            <td><?= htmlspecialchars($aluno['rua']); ?></td>
                            <td><?= htmlspecialchars($aluno['bairro']); ?></td>
                            <td><?= htmlspecialchars($aluno['numero']); ?></td>
                            <td><?= htmlspecialchars($aluno['cep']); ?></td>
                            <td><?= htmlspecialchars($aluno['curso']); ?></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="tela_editar.php?id=<?= $aluno['id']; ?>" class="btn btn-outline-primary btn-sm">Editar</a>
                                    <a href="excluir.php?id=<?= $aluno['id']; ?>" 
                                       class="btn btn-outline-danger btn-sm"
                                       onclick="return confirm('Tem certeza que deseja excluir este aluno?');">Excluir</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    <?php else: ?>
        <p class="text-center">Nenhum aluno encontrado.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
session_start();
include('conexao.php');

/* ========= CONTAGEM DOS ALUNOS ========= */
$sql_total = "SELECT COUNT(*) AS total FROM cadastro";
$res_total = mysqli_query($conexao, $sql_total);
$row_total = mysqli_fetch_assoc($res_total);
$total_geral = $row_total['total'];

$sql_enfermagem = "SELECT COUNT(*) AS total FROM cadastro WHERE curso='Enfermagem'";
$res_enfermagem = mysqli_query($conexao, $sql_enfermagem);
$total_enfermagem = mysqli_fetch_assoc($res_enfermagem)['total'];

$sql_informatica = "SELECT COUNT(*) AS total FROM cadastro WHERE curso='Informatica'";
$res_informatica = mysqli_query($conexao, $sql_informatica);
$total_informatica = mysqli_fetch_assoc($res_informatica)['total'];

$sql_ds = "SELECT COUNT(*) AS total FROM cadastro WHERE curso='Desenvolvimento de Sistema'";
$res_ds = mysqli_query($conexao, $sql_ds);
$total_ds = mysqli_fetch_assoc($res_ds)['total'];

$sql_adm = "SELECT COUNT(*) AS total FROM cadastro WHERE curso='Administração'";
$res_adm = mysqli_query($conexao, $sql_adm);
$total_adm = mysqli_fetch_assoc($res_adm)['total'];

/* ========= BUSCAR DADOS PARA OS GRÁFICOS ========= */

// 1 — Bairro (top 5)
$sql_bairro = "SELECT bairro, COUNT(*) AS total 
               FROM cadastro 
               GROUP BY bairro
               ORDER BY total DESC
               LIMIT 5";
$res_bairro = mysqli_query($conexao, $sql_bairro);
$labels_bairro = [];
$valores_bairro = [];
while ($row = mysqli_fetch_assoc($res_bairro)) {
    $labels_bairro[] = $row['bairro'];
    $valores_bairro[] = $row['total'];
}

// 2 — Responsável
$sql_resp = "SELECT tipo_responsavel, COUNT(*) AS total FROM cadastro GROUP BY tipo_responsavel";
$res_resp = mysqli_query($conexao, $sql_resp);
$labels_resp = [];
$valores_resp = [];
while ($row = mysqli_fetch_assoc($res_resp)) {
    $labels_resp[] = $row['tipo_responsavel'];
    $valores_resp[] = $row['total'];
}

// 3 — Curso
$sql_curso = "SELECT curso, COUNT(*) AS total FROM cadastro GROUP BY curso";
$res_curso = mysqli_query($conexao, $sql_curso);
$labels_curso = [];
$valores_curso = [];
while ($row = mysqli_fetch_assoc($res_curso)) {
    $labels_curso[] = $row['curso'];
    $valores_curso[] = $row['total'];
}

// 4 — Idades (faixas personalizadas)
$sql_idade = "SELECT data_nascimento FROM cadastro";
$res_idade = mysqli_query($conexao, $sql_idade);
$idades = [];
while ($row = mysqli_fetch_assoc($res_idade)) {
    $nascimento = new DateTime($row['data_nascimento']);
    $hoje = new DateTime();
    $idade = $hoje->diff($nascimento)->y;
    $idades[] = $idade;
}

$faixas = ['12-13'=>0, '14-16'=>0, '17-19'=>0];
foreach ($idades as $idade) {
    if ($idade >= 12 && $idade <= 13) $faixas['12-13']++;
    elseif ($idade >= 14 && $idade <= 16) $faixas['14-16']++;
    elseif ($idade >= 17 && $idade <= 19) $faixas['17-19']++;
}

$labels_idade = array_keys($faixas);
$valores_idade = array_values($faixas);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- NAVBAR CORRIGIDA -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="formc.php">Cadastro</a></li>
        <li class="nav-item"><a class="nav-link" href="lista.php">Aluno</a></li>
      </ul>

      <a href="logout.php" class="btn btn-outline-secondary">Sair</a>

    </div>

  </div>
</nav>

<!-- CARDS DE RESUMO -->
<div class="container mt-4">
  <div class="row text-center g-3">
    <div class="col-md-2">
      <div class="card border-light shadow-lg">
        <div class="card-body">
          <h6>Total de Alunos</h6>
          <p class="fs-4"><?php echo $total_geral; ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-2">
      <div class="card border-success shadow-lg">
        <div class="card-body text-success">
          <h6>Enfermagem</h6>
          <p class="fs-4"><?php echo $total_enfermagem; ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-2">
      <div class="card border-purple shadow-lg">
        <div class="card-body text-purple">
          <h6>Informática</h6>
          <p class="fs-4"><?php echo $total_informatica; ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card border-danger shadow-lg">
        <div class="card-body text-danger">
          <h6>Desenvolvimento de Sistema</h6>
          <p class="fs-4"><?php echo $total_ds; ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card border-primary shadow-lg">
        <div class="card-body text-primary">
          <h6>Administração</h6>
          <p class="fs-4"><?php echo $total_adm; ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- GRÁFICOS ORGANIZADOS -->
<div class="container mt-5">
  <div class="row g-4">

    <div class="col-md-6">
      <div class="card shadow-lg border-0 p-4">
        <h4 class="text-center mb-3">Distribuição por Curso</h4>
        <canvas id="graficoCurso"></canvas>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-lg border-0 p-4">
        <h4 class="text-center mb-3">Distribuição de Idades</h4>
        <canvas id="graficoIdade"></canvas>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-lg border-0 p-4">
        <h4 class="text-center mb-3">Quantidade de Responsáveis</h4>
        <canvas id="graficoResponsavel"></canvas>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-lg border-0 p-4">
        <h4 class="text-center mb-3">Bairros com mais Alunos</h4>
        <canvas id="graficoBairro"></canvas>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labelsCurso = <?php echo json_encode($labels_curso); ?>;
const valoresCurso = <?php echo json_encode($valores_curso); ?>;

const labelsResp = <?php echo json_encode($labels_resp); ?>;
const valoresResp = <?php echo json_encode($valores_resp); ?>;

let labelsBairro = <?php echo json_encode($labels_bairro); ?>;
let valoresBairro = <?php echo json_encode($valores_bairro); ?>;

// GRÁFICO PIZZA — CURSOS
new Chart(document.getElementById('graficoCurso'), {
    type: 'pie',
    data: {
        labels: labelsCurso,
        datasets: [{
            data: valoresCurso,
            backgroundColor: ['#22c55e','#7c3aed','#ef4444','#3b82f6']
        }]
    },
    options: { plugins: { legend: { position: 'bottom' } } }
});

// GRÁFICO ROSQUINHA — IDADES
const labelsIdade = <?php echo json_encode($labels_idade); ?>;
const valoresIdade = <?php echo json_encode($valores_idade); ?>;

new Chart(document.getElementById('graficoIdade'), {
    type: 'doughnut',
    data: {
        labels: labelsIdade,
        datasets: [{
            data: valoresIdade,
            backgroundColor: ['#f87171', '#60a5fa', '#34d399']
        }]
    },
    options: { plugins: { legend: { position: 'bottom' } } }
});

// GRÁFICO BARRA — RESPONSÁVEIS
new Chart(document.getElementById('graficoResponsavel'), {
    type: 'bar',
    data: { labels: labelsResp, datasets: [{ label: "Responsáveis", data: valoresResp, backgroundColor: ['#93C5FD', '#F9A8D4', '#FACC15'] }] },
    options: { plugins: { legend: { display: false } } }
});

// GRÁFICO BARRA HORIZONTAL — BAIRROS
new Chart(document.getElementById('graficoBairro'), {
    type: 'bar',
    data: { labels: labelsBairro, datasets: [{ label: "Bairros", data: valoresBairro, backgroundColor: '#C49E85' }] },
    options: { indexAxis: 'y', plugins: { legend: { display: false } } }
});
</script>

<style>
.text-purple { color: #7c3aed; }
.border-purple { border-color: #7c3aed; }
</style>

<!-- JS DO BOOTSTRAP (necessário para navbar mobile funcionar) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

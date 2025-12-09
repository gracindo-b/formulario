<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Formulário</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<!-- ================= NAVBAR ================== -->

<nav class="navbar navbar-expand-lg bg-body-tertiary navbar-light bg-light">
  <div class="container-fluid">

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="formc.php">Cadastro</a></li>
        <li class="nav-item"><a class="nav-link" href="painel.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="lista.php">Aluno</a></li>
      </ul>

      <a href="logout.php" class="btn btn-outline-secondary">Sair</a>

    </div>
  </div>
</nav>

<!-- ================ FORMULÁRIO ================= -->

<section class="h-100">
	<div class="container h-100">
		<div class="row justify-content-sm-center h-100">
			<div class="col-xxl-8 col-xl-10 col-lg-10 col-md-12">
				
				<div class="text-center my-5">
					<img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="logo" width="100">
				</div>

				<div class="card shadow-lg mt-5">
					<div class="card-body p-5">

						<form action="salvar.php" method="POST" class="needs-validation" autocomplete="off">

							<h1 class="fs-4 card-title fw-bold mb-4 text-center">Formulário</h1>

							<div class="row g-3">

								<!-- COLUNA ESQUERDA -->
								<div class="col-md-6">

									<label class="form-label">Nome Completo</label>
									<input type="text" class="form-control" name="nome_completo" required>

									<label class="form-label mt-3">Data de Nascimento</label>
									<input type="date" class="form-control" name="data_nascimento" required>

									<label class="form-label mt-3">Nome do Responsável</label>
									<input type="text" class="form-control" name="nome_responsavel">

									<label class="form-label mt-4">Essa pessoa é?</label><br>

									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="tipo_responsavel" value="Pai" required>
										<label class="form-check-label">Pai</label>
									</div>

									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="tipo_responsavel" value="Mãe">
										<label class="form-check-label">Mãe</label>
									</div>

									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="tipo_responsavel" value="Outro">
										<label class="form-check-label">Outro</label>
									</div>

									<label class="form-label mt-4">Curso</label>
									<select class="form-select" name="curso" required>
										<option value="">Selecione o curso desejado</option>
										<option value="Enfermagem">Enfermagem</option>
										<option value="Informatica">Informática</option>
										<option value="Desenvolvimento de Sistema">Desenvolvimento de Sistema</option>
										<option value="Administração">Administração</option>
									</select>

								</div>

								<!-- COLUNA DIREITA -->
								<div class="col-md-6">

									<label class="form-label">Endereço - Rua</label>
									<input type="text" class="form-control" name="rua" required>

									<label class="form-label mt-3">Bairro</label>
									<input type="text" class="form-control" name="bairro" required>

									<label class="form-label mt-3">Número</label>
									<input type="text" class="form-control" name="numero" required>

									<label class="form-label mt-3">CEP</label>
									<input type="text" class="form-control" name="cep" required>

								</div>

								<div class="d-grid gap-2 mt-4">
									<button class="btn btn-primary" type="submit">Enviar</button>
								</div>

							</div>

						</form>

					</div>
				</div>

			</div>
		</div>
	</div>
</section>

<!-- BOOTSTRAP JS NECESSÁRIO PARA NAVBAR FUNCIONAR -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

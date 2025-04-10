<?php 
	require('../modal/acessos.php'); 

	if( ! $user->getUsuario() == 'true' || ! $user->getUsuario() == 't' )
	{
		header('Location: /avaliacao');
	}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<?php include('../inc/head.php'); ?>
	<link rel="stylesheet" type="text/css" href="/css/novo_usuario.css">

	<script type="text/javascript" src="/js/admin.js"></script>
</head>
<body>
<div class="header">
	<div class="logo_embrapa"></div>

	<div class="menu_superior_login">
        <div class="drop">
         	<span><?php print $user->getNome(); ?></span>
			<ul>  
              <li><a href="/usuario/alterar">Editar Usuário</a></li>
              <li><a href="javascript:void(0)" class="logout">Sair</a></li>
          	</ul>
        </div>  
	</div>
</div>
<div class="body">
	<?php include '../inc/menu.php' ?>

	<h2 class="titulo subtitulo">Cadastro de Novo Usuário</h2>

	<form class="novo_usuario">
		<table border="0">
			<tr>
				<td width="135">
					<label class="lab_primeiro">Nome</label>
				</td>
				<td>
					<input type="text" name="nome" required maxlength="70">
				</td>
			</tr>
			<tr>
				<td>
					<label class="lab_primeiro">Email</label>
				</td>
				<td>
					<input type="text" name="email" class="input_email" required maxlength="70">
				</td>
			</tr>
			<tr>
				<td rowspan="4" valign="top">
					<label class="lab_primeiro">Privilégios</label>
				</td>
				<td class="sub_td">
					<table border="0" class="table_interna">
						<tr>
							<td>
								<input type="checkbox" id="novo_amostra" name="amostra" value="1"> 
									<label for="novo_amostra" class="check">
										<img src="/images/ico_amostras_on.png" class="img_amostra">
										Cadastrar Resultados de Amostras
						</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="novo_laboratorio" name="laboratorio" value="1"> 
									<label for="novo_laboratorio" class="check">
										<img src="/images/ico_laboratorio_on.png">
										Alterar Cadastro do Laboratório
									</label>
							</td>
						</tr>
							
						<tr>	
							<td>
								<input type="checkbox" id="novo_usuario" name="usuario" value="1">
									<label for="novo_usuario" class="check">
										<img src="/images/ico_usuario_on.png" class="img_usuario">
										Administrar Usuários
									</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="novo_selo" name="selo" value="1"> 
									<label for="novo_selo" class="check">
										<img src="/images/ico_selos_on.png">
										Solicitar Selos
									</label>
							</td>
						</tr>

					</table>
				</td>
			</tr>
			<tr>
				<td colspan="7" align="right" style="border:none;">
					<a href="/usuario" class="cancelar">CANCELAR</a>
					<button type="button" class="salvar">SALVAR</button>
				</td>
			</tr>
		</table>
	</form>
</div>
<?php include '../inc/rodape.php'; ?>
</body>
</html>
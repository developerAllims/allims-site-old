<?php
	session_start();

	session_destroy();

?>

<!DOCTYPE html>

<html lang="pt">

<head>

	<meta charset="utf-8">

	<title>Sistema Administrativo Embrapa</title>



	<link rel="icon" type="image/png" href="/ico.png" />



	<link rel="stylesheet" type="text/css" href="../css/fonts.css" >

	<link rel="stylesheet" type="text/css" href="../css/style.css">

	<link rel="stylesheet" type="text/css" href="../css/login.css">



	<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>

	<script type="text/javascript" src="../js/login.js"></script>

</head>

<body>



<div class="fundo_cima"></div>

<div class="fundo_baixo"></div>



<div class="bloco_login">

	<form class="login">

		<h3>Sistema Administrativo</h3>

		<input type="email" name="email" placeholder="Usuário (email)" autocomplete="off" maxlength="90" value="<?php print isset($_COOKIE['email']) ? $_COOKIE['email'] : '' ?>">

		<input type="password" name="senha" placeholder="Senha" autocomplete="off" maxlength="20" value="<?php print isset($_COOKIE['email']) ? $_COOKIE['pass'] : '' ?>">

		<input type="hidden" name="acao" value="logar">

		<button type="button">Entrar</button>

		<label for="lembrar"><input type="checkbox" name="lembrar" id="lembrar" <?php print ( isset($_COOKIE['email']) && isset($_COOKIE['pass'])) ? 'checked="checked"':""; ?>>Lembrar Senha</label>

		<a href="javascript:void(0)" class="esqueceu">Esqueceu a senha?</a>

	</form>

</div>

<?php include '../inc/rodape.php'; ?>

</body>

</html>
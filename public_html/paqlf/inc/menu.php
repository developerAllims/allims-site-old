<ul class="menu">

	<li <?php print $_SERVER['REQUEST_URI'] == '/avaliacao' ? 'class="selected"' : '' ?>>

		<a href="/avaliacao" class="resultado">AVALIAÇÕES ANUAIS</a>

	</li>



	<li <?php print $_SERVER['REQUEST_URI'] == '/amostras'  ? 'class="selected"' : '' ?>>

		<a href="/amostras" class="amostras">AMOSTRAS</a>

	</li>

	<?php $server = explode('/',$_SERVER['REQUEST_URI'] ); ?>



	<?php if( ($user->getResultado() == 't' || $user->getResultado() == 'true') && ( $user->getLaboratorioAtivo() == 't' || $user->getLaboratorioAtivo() == 'true' ) ) { ?>

	<li <?php print $server[1] == 'resultado' ? 'class="selected"' : '' ?>>

		<a href="/resultado" class="novo_resultado">RESULTADOS</a>

	</li>

	<?php } 



		if( $user->getAlteracaoLaboratorio() == 't' || $user->getAlteracaoLaboratorio() == 'true' ) {

	?>

	<li <?php print $_SERVER['REQUEST_URI'] == '/laboratorio' ? 'class="selected"' : '' ?>>

		<a href="/laboratorio" class="laboratorio">LABORATÓRIO</a>

	</li>

	<?php } 



		if( $user->getUsuario() == 't' || $user->getUsuario() == 'true' ) {

	?>

	<li <?php print $server[1] == 'usuario' || $_SERVER['REQUEST_URI'] == '/usuario/novo' || $_SERVER['REQUEST_URI'] == '/usuario/alterar' ? 'class="selected"' : '' ?>>

		<a href="/usuario" class="usuario">USUÁRIOS</a>

	</li>

	<?php } 


//print 'oi1';
		if( ($user->getSelo() == 't' || $user->getSelo() == 'true') && ( $user->getLaboratorioAtivo() == 't' || $user->getLaboratorioAtivo() == 'true' ) ) {
//print 'oi';
	?>

	<li <?php print $_SERVER['REQUEST_URI'] == '/selo' || $server[1] == 'selo' ? 'class="selected"' : '' ?>>

		<a href="/selo" class="selos">SOLICITAÇÃO DE SELOS</a>

	</li>

	<?php } ?>

</ul>
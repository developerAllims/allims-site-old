<ul class="menu">

	<?php $server = explode('/',$_SERVER['REQUEST_URI'] ); ?>



	<li <?php print $server[1] =='instituicao' ? 'class="selected"' : '' ?>>

		<a href="/instituicao" class="menu_instituicao">INSTITUIÇÃO</a>

	</li>



	<li <?php print $server[1] =='laboratorio' ? 'class="selected"' : '' ?>>

		<a href="/laboratorio" class="laboratorio">LABORATÓRIOS</a>

	</li>



	<li <?php print $server[1] == 'avaliacao' ? 'class="selected"' : '' ?>>

		<a href="/avaliacao" class="resultado">AVALIAÇÕES</a>

	</li>



	<li <?php print $server[1] == 'contrato' ? 'class="selected"' : '' ?>>

		<a href="/contrato" class="contrato">CONTRATOS</a>

	</li>



	<li <?php print $server[1] == 'areferencias' ? 'class="selected"' : '' ?>>

		<a href="/areferencias" class="menu_controles">A. REFERÊNCIAS </a>

	</li>

	

	<li <?php print $server[1] == 'programa' ? 'class="selected"' : '' ?>>

		<a href="/programa" class="menu_programa">PROGRAMA</a>

	</li>



	<li <?php print $server[1] == 'selo' ? 'class="selected"' : '' ?>>

		<a href="/selo" class="selos">SELOS</a>

	</li>



	<li <?php print $server[1] == 'usuario' ? 'class="selected"' : '' ?>>

		<a href="/usuario" class="usuario">USUÁRIOS</a>

	</li>

</ul>




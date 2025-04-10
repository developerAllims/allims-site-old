<?php  
	$uri = explode('/',$_SERVER['REQUEST_URI']);
	
	$menu_amostras = 'bt_down';
	$menu_usuario = 'bt_down';
	$menu_cadastro = 'bt_down';

	if ( $uri[1] == 'amostras' )
	{
		$menu_amostras = 'bt_up';
	}else if( $uri[1] == 'usuario' )
	{
		$menu_usuario = 'bt_up';
	}else if( $uri[1] == 'cadastro' )
	{
		$menu_cadastro = 'bt_up';
	}
?>

<div class="menu_nivel01">
    <ul>
        <li class="<?php print $menu_amostras; ?>"><a href="/amostras" >Amostras</a></li>
        <li class="<?php print $menu_cadastro; ?>"><a href="/cadastro">Cadastro de Amostras</a></li>
        <li class="<?php print $menu_usuario; ?>"><a href="/usuario">Usuário</a></li>
        <!--<li class="bt_down configuracoes"><a href="#">Configurações</a></li>
        <li class="bt_down suporte"><a href="#">Suporte</a></li>-->
    </ul>
</div>
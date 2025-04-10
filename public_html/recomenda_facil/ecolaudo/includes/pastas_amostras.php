<?php 
	session_start();
	require_once '../controller/login_usuario.php';
	require_once '../controller/login_sessao.php';
	require_once '../controller/login_autenticador.php';
	 
	$aut = Autenticador::instanciar();
	 
	$usuario = null;
	if ($aut->esta_logado()) {
		$usuario = $aut->pegar_usuario();
	}
	else {
		$aut->expulsar();
	}

	include_once("../model/conexao_bd.php");  
	$conexao = conexao();
	$query = "SELECT pk_web_users_folders, fk_web_users, folder_name, replace( sf_fc_remove_acentuation(LOWER(folder_name)), ' ' , '') as clear_folder_name  FROM sf_web_users_folders WHERE fk_web_users = " . $usuario->getId() . " ORDER BY folder_name";
	$server = $_GET['folders'];
?>





<div class="box_pastas">
<ul>
    <li><div id="botao" class="bt_down novo fonte_padrao">Novo</div></li>
    <li class="conteudo_novo">
        <input type="text" name="novo" class="fonte_input fonte_padrao" maxlength="30">
        <div id="botao" class="bt_down ok fonte_padrao">OK</div>
        <div id="botao" class="bt_down cancelar fonte_padrao">Cancelar</div>
    </li>
    <li class="lista-mover">
        <div id="botao" class="bt_down mover fonte_padrao">Mover</div>
        <ul class="lista_pasta">
            <li><div id="botao" class="bt_down fonte_padrao" data-id="null" >Caixa de entrada</div></li>
            <?php 
				$result_interno=pg_query( $conexao , $query );
				while($rows = pg_fetch_array($result_interno)) 
				{
					print '<li><div id="botao" class="bt_down fonte_padrao" data-id="'. $rows['pk_web_users_folders']. '">' .  $rows['folder_name'] . '</div></li>';
				}
			?>
        </ul>
    </li>
    <li><div id="botao" class="bt_down fonte_padrao excluir">Excluir</div></li>
</ul>
<div class="listagem-pastas">
    <ul>
        <li><div id="botao" class="bt_down fonte_padrao <?php echo $server == 'undefined' || $server == '' || $server == 'caixadeentrada' ? 'enabled' : ''  ; ?>" data-id="-1" data-title="caixadeentrada">Caixa de entrada</div></li>
      	<?php 
			$result=pg_query( $conexao , $query );
			while($row = pg_fetch_array($result)) 
			{
				print '<li>';
				print '<div id="botao" class="bt_down fonte_padrao ' . ( $server == $row['clear_folder_name'] ? 'enabled' : '') . '"';
				print ' data-id="'. $row['pk_web_users_folders']. '" data-title="'. $row['clear_folder_name'] . '">';
				print $row['folder_name'] . '</div></li>';
			}
		?>
    </ul>
</div>
</div>
<form method="post" id="item_form" action="">           
<!-- Filtros (início) -->

    <div class="box_filtros">

        
        <div id="col01">
       		<div class="titulo fonte_padrao">Data / Período</div> 
            <input type="text" id="data_desde" placeholder="Desde..." class="form_box_data data_completa" maxlength="10" name="data_desde">
            <input type="text" id="data_ate" placeholder="Até..." class="form_box_data margin_left20 data_completa" maxlength="10" name="data_ate">
        </div>
        
        <div id="col02">
            <input type="text" id="interessado" name="web_interessado" class="form_box_texto" placeholder="Interessado..." />
            <input type="text" id="amostras" name="web_amostras" class="form_box_texto" placeholder="Tipo de Amostra..." />
        </div>

        <div id="col03">
            <input type="text" id="fazenda" name="web_fazenda" class="form_box_texto" placeholder="Propriedade..." />
            <!--<input type="text" id="fazenda" name="web_lote" class="form_box_texto" placeholder="Lote..." />-->
        </div>

        <div id="col04">
              <input type='image' id='aplica-filtro' src='/ecolaudo/imagens/bt_atualizar_up.png'  value='atualizar' />
        </div>
	
        
     </div>     
           
<!-- Filtros (fim) -->      
    <span id="loading"></span>&nbsp;
  
</form>    

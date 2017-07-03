<?php
  $valorTotal = $this->receita_model->getValorReceitaMensal();
?>
<?php $this->load->view('template/topo'); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Lista de Inadimplentes</h1>

    <div class="row placeholders">
    <!-- NÃO MEXER DAQUI PARA CIMA -->

    <button class="btn btn-success" onclick="add_receita()"><i class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Adicionar"></i> Calcular</button>
    <table id="table_id" class="table table-striped table-bordered">
      <thead>
        <tr>
					<th>Morador</th>
					<th>Apto</th>
					<th>Valor</th>
					<th>Dt Vencimento</th>
          <th>Grupo</th>
          <th>Situação</th>
        </tr>
      </thead>
      <tbody>
				<?php 
        $tInadimpencia = 0;
        foreach($receitas as $receita){
        $tInadimpencia = $tInadimpencia + $receita->rec_valor;
        ?>
				     <tr>
				        <td><?php echo $receita->first_name;?></td>
				        <td><?php echo $receita->apt_descricao;?></td>
								<td><?php echo $receita->rec_valor;?></td>
								<td><?php echo $receita->rec_data_vencimento;?></td>
                <td><?php echo $receita->tgo_descricao;?></td>
                <td><?php echo $receita->rec_status;?></td>
								
				      </tr>
				     <?php }?>
      </tbody>
    </table>
    <label>Valor Total:</label> <?php echo 'R$ '.$valorTotal->valor; ?><br>
    <label>Valor Inadimplencia:</label><?php echo 'R$ '.$tInadimpencia;?>
  </div>
 
  <div id="my-chart" style="width: 100%; height: 500px;"></div>
  
 
 <!-- Biblioteca jQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!-- Biblioteca de gráficos do Google Chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Script para renderizar o gráfico -->
    <script type="text/javascript" src="<?php echo base_url('assests/jquery/script.js')?>"></script>
 
  </body>
</html>
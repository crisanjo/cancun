<?php
  $valorTotal = $this->receita_model->getValorReceitaMensal();
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Receitas</title>
    <link href="<?php echo base_url('assests/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assests/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <script src="<?php echo base_url('assests/jquery/jquery-3.2.1.min.js')?>"></script>
    <script src="<?php echo base_url('assests/bootstrap/js/bootstrap.min.js')?>"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
  </head>
  <body>
 
  <div class="container">
    <h1>Lista de Inadimplentes</h1>
</center>
    <button class="btn btn-success" onclick="add_receita()"><i class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Adicionar"></i> Calcular</button>
    <br />
    <br />
    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>
					<th>MORADOR</th>
					<th>APTO</th>
					<th>VALOR</th>
					<th>DATA VENCIMENTO</th>
          <th>GRUPO</th>
          <th>SITUAÇÃO</th>
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
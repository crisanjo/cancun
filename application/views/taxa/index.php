<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Taxas</title>
    <link href="<?php echo base_url('assests/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assests/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
 
 
  <div class="container">
    <h1>Lista de Taxas</h1>
</center>
    <br />
    <button class="btn btn-success" onclick="add_taxa()"><i class="glyphicon glyphicon-plus"></i> Add Taxa</button>
    <br />
    <br />
    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>
					<th>ID</th>
					<th>DESCRIÇÃO</th>
					<th>VALOR</th>
					<th>QTD DE PARCELAS</th>
          <th>STATUS</th>
          <th>ANTECIPADO</th>
          <th style="width:125px;">Ações</p></th>
        </tr>
      </thead>
      <tbody>
				<?php foreach($taxas as $taxa){?>
				     <tr>
				        <td><?php echo $taxa->txc_id;?></td>
				        <td><?php echo $taxa->txc_descricao;?></td>
								<td><?php echo $taxa->txc_valor;?></td>
								<td><?php echo $taxa->txc_qtd;?></td>
                <td><?php echo $taxa->txc_status;?></td>
                <td><?php echo $taxa->txc_antecipado;?></td>
								<td>
									<button class="btn btn-warning" onclick="edit_taxa(<?php echo $taxa->txc_id;?>)"><i class="glyphicon glyphicon-pencil"></i></button>
									<button class="btn btn-danger" onclick="delete_taxa(<?php echo $taxa->txc_id;?>)"><i class="glyphicon glyphicon-remove"></i></button>
								</td>
				      </tr>
				     <?php }?>
      </tbody>
    </table>
 
  </div>
 
  <script src="<?php echo base_url('assests/jquery/jquery-3.2.1.min.js')?>"></script>
  <script src="<?php echo base_url('assests/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assests/datatables/js/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo base_url('assests/datatables/js/dataTables.bootstrap.js')?>"></script>
 
 
  <script type="text/javascript">
  $(document).ready( function () {
      $('#table_id').DataTable();
  } );
    var save_method; //for save method string
    var table;
 
    function add_taxa(){
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }
 
    function edit_taxa(id){
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
 
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('taxa/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data){
            $('[name="txc_id"]').val(data.txc_id);
            $('[name="txc_descricao"]').val(data.txc_descricao);
            $('[name="txc_valor"]').val(data.txc_valor);
            $('[name="txc_qtd"]').val(data.txc_qtd);
            $('[name="txc_status"]').val(data.txc_status);
            $('[name="txc_antecipado"]').val(data.txc_antecipado);
 
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edita Taxa'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
    });
    }
 
    function save(){
      var url;
      if(save_method == 'add'){
          url = "<?php echo site_url('taxa/cadastrar')?>";
      }else{
        url = "<?php echo site_url('taxa/taxa_update')?>";
      }
       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
               //if success close modal and reload ajax table
               $('#modal_form').modal('hide');
              location.reload();// for reload a page
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }
 
    function delete_taxa(id)
    {
      if(confirm('Tem certeza?'))
      {
        // ajax delete data from database
          $.ajax({
            url : "<?php echo site_url('taxa/taxa_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data){
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Erro ao excluir o taxa');
            }
        });
 
      }
    }
 
  </script>
 
  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Taxa</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="txc_id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Descrição</label>
              <div class="col-md-9">
                <input name="txc_descricao" placeholder="Descrição da Taxa" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Valor</label>
              <div class="col-md-9">
                <input name="txc_valor" placeholder="Valor da Taxa" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Qtd de Parcelas</label>
              <div class="col-md-9">
                <input name="txc_qtd" placeholder="-1 é fixo" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Antecipado</label>
              <div class="col-md-9">
                  <select name="txc_antecipado" class="form-control">
                      <option value="0">Não</option>
                      <option value="1">Sim</option>
                  </select>
                  <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Status</label>
              <div class="col-md-9">
                  <select name="txc_status" class="form-control">
                      <option value="1">Ativo</option>
                      <option value="0">Inativo</option>
                  </select>
                  <span class="help-block"></span>
              </div>
            </div>
            
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Salvar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
 
  </body>
</html>
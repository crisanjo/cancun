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
    <script type="text/javascript">
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    </script>
  </head>
  <body>
 
  <div class="container">
    <h1>Lista com Receitas</h1>
</center>
    <button class="btn btn-success" onclick="add_receita()"><i class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Adicionar"></i> Add Receita</button>
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
          <th style="width:125px;">Ações</p></th>
        </tr>
      </thead>
      <tbody>
				<?php foreach($receitas as $receita){?>
				     <tr>
				        <td><?php echo $receita->first_name;?></td>
				        <td><?php echo $receita->apt_descricao;?></td>
								<td><?php echo $receita->rec_valor;?></td>
								<td><?php echo $receita->rec_data_vencimento;?></td>
                <td><?php echo $receita->tgo_descricao;?></td>
                <td><?php echo $receita->rec_status;?></td>
								<td>
									<button class="btn btn-success" onclick="edit_receita(<?php echo $receita->rec_id;?>)" data-toggle="tooltip" title="Editar"><i class="glyphicon glyphicon-usd"></i></button>
									<button class="btn btn-danger" onclick="delete_receita(<?php echo $receita->rec_id;?>)" data-toggle="tooltip" title="Deletar" ><i class="glyphicon glyphicon-remove"></i></button>
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

      $.ajax({
        type: "get",
        url: "taxagrupo/lista_taxagrupo_json",
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        success: function (obj) {
          if (obj != null) {
            var selectbox = $('#tgo_id');
            selectbox.find('option').remove();
            $.each(obj, function (i, d) {
                $('<option>').val(d.tgo_id).text(d.tgo_descricao).appendTo(selectbox);
            });
          }
        }  
      });


  } );
    var save_method; //for save method string
    var table;
 
 
    function add_receita(){
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }
 
    function edit_receita(id){
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
 
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('receita/ajax_pagamento/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data){
          location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
    });
    }
 
    function save(){
      var url;
      if(save_method == 'add'){
          url = "<?php echo site_url('receita/cadastrar')?>";
      }else{
        url = "<?php echo site_url('receita/receita_update')?>";
      }
       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data){
              if(data.status) {
                $('#modal_form').modal('hide');
                location.reload();// for reload a page
              }else{
                  for (var i = 0; i < data.inputerror.length; i++) {
                      $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                      $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                  }
              }
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error adding / update data');
            }
        });
    }
 
    function delete_receita(id)
    {
      if(confirm('Tem certeza?'))
      {
        // ajax delete data from database
          $.ajax({
            url : "<?php echo site_url('receita/receita_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data){
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Erro ao excluir o apto');
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
        <h3 class="modal-title">Receita</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="rec_id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Data de Vencimento</label>
              <div class="col-md-9">
                <input name="rec_data_vencimento" placeholder="Data de Vencimento" class="form-control" type="date">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Grupo</label>
              <div class="col-md-9">
                  <select name="tgo_id" class="form-control" id="tgo_id">
                      <option value="">--Selecione--</option>
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
<?php $this->load->view('template/topo'); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Lista com Receitas</h1>

    <div class="row placeholders">
    <!-- NÃO MEXER DAQUI PARA CIMA -->


    <button class="btn btn-success" onclick="add_receita()"><i class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Adicionar"></i> Add Receita</button>
    <table id="table_id" class="table table-striped table-bordered">
      <thead>
        <tr>
					<th>Morador</th>
					<th>Apto</th>
					<th>Valor</th>
					<th>Dt Vencimento</th>
          <th>Grupo</th>
          <th>Situação</th>
          <th>Ações</th>
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
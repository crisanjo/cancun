<?php $this->load->view('template/topo'); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Lista de aptos</h1>

    <div class="row placeholders">
    <!-- NÃO MEXER DAQUI PARA CIMA -->


    
    <button class="btn btn-success" onclick="add_apto()" data-toggle="tooltip" title="Adicionar"><i class="glyphicon glyphicon-plus"></i> Add Apto</button>
    <br />
    <br />
    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>
					<th>Id</th>
					<th>Apto</th>
					<th>Morador</th>
					<th>Locado</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
				<?php foreach($aptos as $apto){?>
				     <tr>
				        <td><?php echo $apto->apt_id;?></td>
				        <td><?php echo $apto->apt_descricao;?></td>
								<td><?php echo $apto->first_name;?></td>
								<td><?php echo $apto->apt_sit;?></td>
								<td>
									<button class="btn btn-warning" onclick="edit_apto(<?php echo $apto->apt_id;?>)" data-toggle="tooltip" title="Editar"><i class="glyphicon glyphicon-pencil"></i></button>
									<button class="btn btn-danger" onclick="delete_apto(<?php echo $apto->apt_id;?>)" data-toggle="tooltip" title="Deletar"><i class="glyphicon glyphicon-remove"></i></button>
                  <button class="btn btn-success" onclick="add_receita(<?php echo $apto->apt_id;?>)" data-toggle="tooltip" title="Adicionar Receita Extrar ao Apto"><i class="glyphicon glyphicon-usd"></i></button>
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
        url: "user/lista_user_json",
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        success: function (obj) {
          if (obj != null) {
            var selectbox = $('#usu_id');
            selectbox.find('option').remove();
            $.each(obj, function (i, d) {
                $('<option>').val(d.id).text(d.first_name).appendTo(selectbox);
            });
          }
        }  
      });


  } );
    var save_method; //for save method string
    var table;
 
 
    function add_apto(){
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }

     function add_receita(id){
      save_method = 'add_receita';
      $('#form_extra')[0].reset(); // reset form on modals
      $.ajax({
        url : "<?php echo site_url('apto/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data){
            $('[name="apt_id"]').val(data.apt_id);
            $('[name="apt_descricao"]').val(data.apt_descricao); 
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
      });  
      $.ajax({
        type: "get",
        url: "taxa/lista_taxa_json",
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        success: function (obj) {
          if (obj != null) {
            var selectbox = $('#txc_id');
            selectbox.find('option').remove();
            $.each(obj, function (i, d) {
                $('<option>').val(d.txc_id).text(d.txc_descricao+ ' - '+ d.txc_valor).appendTo(selectbox);
            });
          }
          $('#modal_form_extra').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Receita Extra Apto'); // Set title to Bootstrap modal title
        }  
      });
      
    }
 
    function edit_apto(id){
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
 
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('apto/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data){
            $('[name="apt_id"]').val(data.apt_id);
            $('[name="apt_descricao"]').val(data.apt_descricao);
            $('[name="apt_locado"]').val(data.apt_locado);
            $('[name="usu_id"]').val(data.usu_id);
 
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edita Apto'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
      });
    }
 
    function save(){
      var url;
      if(save_method == 'add'){
        url = "<?php echo site_url('apto/cadastrar')?>";
      }else{
        url = "<?php echo site_url('apto/apto_update')?>";
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
 
    function delete_apto(id){
      if(confirm('Tem certeza?')){
        // ajax delete data from database
          $.ajax({
            url : "<?php echo site_url('apto/apto_delete')?>/"+id,
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
    function save_extra(){
      var url;
      if(save_method == 'add_receita'){
        url = "<?php echo site_url('apto/gerar_receita_extra')?>";
      }
       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form_extra').serialize(),
            dataType: "JSON",
            success: function(data){
              if(data.status) {
                $('#modal_form_extra').modal('hide');
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
 
 
  </script>
 
  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Apto</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="apt_id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Apto</label>
              <div class="col-md-9">
                <input name="apt_descricao" placeholder="Descrição do Apto" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Morador</label>
              <div class="col-md-9">
                  <select name="usu_id" class="form-control" id="usu_id">
                      <option value="">--Selecione--</option>
                  </select>
                  <span class="help-block"></span>
              </div>
            </div> 
            <div class="form-group">
              <label class="control-label col-md-3">Locado</label>
              <div class="col-md-9">
                  <select name="apt_locado" class="form-control">
                      <option value="">--Selecione--</option>
                      <option value="0">Não</option>
                      <option value="1">Sim</option>
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

  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form_extra" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Adicionar Receita Extra</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form_extra" class="form-horizontal">
          <input type="hidden" value="" name="apt_id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Apto</label>
              <div class="col-md-9">
                <input name="apt_descricao" placeholder="Descrição do Apto" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Data de Vencimento</label>
              <div class="col-md-9">
                <input name="rec_data_vencimento" placeholder="Data de Vencimento" class="form-control" type="date" required="true">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Taxa</label>
              <div class="col-md-9">
                  <select name="txc_id" class="form-control" id="txc_id">
                      <option value="">--Selecione--</option>
                  </select>
                  <span class="help-block"></span>
              </div>
            </div> 
            
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save_extra()" class="btn btn-primary">Salvar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
 </body>
 </html>
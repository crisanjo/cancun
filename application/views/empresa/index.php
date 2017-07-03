<?php $this->load->view('template/topo'); ?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Lista de Empresas</h1>

    <div class="row placeholders">
    <!-- NÃO MEXER DAQUI PARA CIMA -->



    <button class="btn btn-success" onclick="add_empresa()" data-toggle="tooltip" title="Adicionar"><i class="glyphicon glyphicon-plus" ></i> Add Empresa</button>
    <table id="table_id" class="table table-striped table-bordered">
      <thead>
        <tr>
					<th>Id</th>
					<th>Razão Social</th>
          <th>Nome Fantasia</th>
          <th>CNPJ</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
				<?php foreach($empresas as $empresa){?>
				     <tr>
				        <td><?php echo $empresa->emp_id;?></td>
				        <td><?php echo $empresa->emp_rz_social;?></td>
                <td><?php echo $empresa->emp_nm_fantasia;?></td>
                <td><?php echo $empresa->emp_cnpj;?></td>
								<td>
									<button class="btn btn-warning" onclick="edit_empresa(<?php echo $empresa->emp_id;?>)" data-toggle="tooltip" title="Editar"><i class="glyphicon glyphicon-pencil"></i></button>
									<button class="btn btn-danger" onclick="delete_empresa(<?php echo $empresa->emp_id;?>)" data-toggle="tooltip" title="Deletar"><i class="glyphicon glyphicon-remove" ></i></button>
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
  <script src="<?php echo base_url('assests/jquery/jquery.maskedinput.js')?>"></script>
 
  <script type="text/javascript">
  $(document).ready( function () {
      $('#table_id').DataTable();
      $("#emp_cnpj").mask("99.999.999/9999-99");
  } );
    var save_method; //for save method string
    var table;
 
    function add_empresa(){
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }
 
    function edit_empresa(id){
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
 
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('empresa/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data){
            $('[name="emp_id"]').val(data.emp_id);
            $('[name="emp_rz_social"]').val(data.emp_rz_social);
            $('[name="emp_nm_fantasia"]').val(data.emp_nm_fantasia);
            $('[name="emp_cnpj"]').val(data.emp_cnpj);
 
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edita Empresa'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Erro obter dados');
        }
    });
    }
 
    function save(){
      var url;
      if(save_method == 'add'){
        url = "<?php echo site_url('empresa/cadastrar')?>";
      }else{
        url = "<?php echo site_url('empresa/empresa_update')?>";
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
 
    function delete_empresa(id){
      if(confirm('Tem certeza?')){
        // ajax delete data from database
          $.ajax({
            url : "<?php echo site_url('empresa/empresa_delete')?>/"+id,
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
        <h3 class="modal-title">Empresa</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="emp_id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Razão Social</label>
              <div class="col-md-9">
                <input name="emp_rz_social" placeholder="Razão Social" class="form-control" type="text" required="true">
                <span class="help-block"></span>
              </div>
            </div> 
            <div class="form-group">
              <label class="control-label col-md-3">Nome Fantasia</label>
              <div class="col-md-9">
                <input name="emp_nm_fantasia" placeholder="Nome Fantasia" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div> 
            <div class="form-group">
              <label class="control-label col-md-3">CNPJ</label>
              <div class="col-md-9">
                <input name="emp_cnpj" placeholder="CNPJ" id="emp_cnpj" class="form-control" type="text" max="14" min="14" required="true">
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
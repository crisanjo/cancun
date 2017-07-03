<?php $this->load->view('template/topo'); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Lista de Taxas</h1>

    <div class="row placeholders">
    <!-- NÃO MEXER DAQUI PARA CIMA -->


    
    <button class="btn btn-success" onclick="add_taxa()" data-toggle="tooltip" title="Adicionar"><i class="glyphicon glyphicon-plus"></i> Add Taxa</button>
    <table id="table_id" class="table table-striped table-bordered">
      <thead>
        <tr>
					<th>Id</th>
					<th>Descrição</th>
					<th>Valor</th>
					<th>Qtd de Parcelas</th>
          <th>Status</th>
          <th>Antecipado</th>
          <th>Ações</th>
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
									<button class="btn btn-warning" onclick="edit_taxa(<?php echo $taxa->txc_id;?>)" data-toggle="tooltip" title="Editar"><i class="glyphicon glyphicon-pencil"></i></button>
									<button class="btn btn-danger" onclick="delete_taxa(<?php echo $taxa->txc_id;?>)" data-toggle="tooltip" title="Deletar"><i class="glyphicon glyphicon-remove"></i></button>
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
  <script src="<?php echo base_url('assests/jquery/jquery.maskMoney.min.js')?>" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready( function () {
        $('#table_id').DataTable();
       
        $("#txc_valor").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:'.', affixesStay: false});
    });

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
              console.log(jqXHR);
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
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Valor</label>
              <div class="col-md-9">
                <input name="txc_valor" placeholder="Valor da Taxa" id="txc_valor" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Qtd de Parcelas</label>
              <div class="col-md-9">
                <input name="txc_qtd" placeholder="-1 é fixo" class="form-control" type="text">
                <span class="help-block"></span>
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
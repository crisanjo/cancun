<?php $this->load->view('template/topo'); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Lista de Despesas</h1>

    <div class="row placeholders">
    <!-- NÃO MEXER DAQUI PARA CIMA -->

    <button class="btn btn-success" onclick="add_conta()" data-toggle="tooltip" title="Adicionar"><i class="glyphicon glyphicon-plus"></i> Add Despesa</button>
    <button class="btn btn-success" onclick="gerar_conta()" data-toggle="tooltip" title="Gerar Despesas"><i class="glyphicon glyphicon-plus"></i>Gerar Despesa</button>
    
    <table id="table_id" class="table table-striped table-bordered">
      <thead>
        <tr>
					<th>Empresa</th>
					<th>Categoria</th>
					<th>Valor</th>
          <th>Dt Vencimento</th>
          <th>Tipo</th>
          <th>Situação</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
				<?php foreach($contas as $conta){?>
				     <tr>
				        <td><?php echo $conta->emp_rz_social;?></td>
				        <td><?php echo $conta->tpc_descricao;?></td>
								<td><?php echo $conta->con_valor;?></td>
								<td><?php echo $conta->con_data;?></td>
                <td><?php echo $conta->con_fixo;?></td>
                <td><?php echo $conta->con_status;?></td>
								<td>
									<button class="btn btn-warning" onclick="edit_conta(<?php echo $conta->con_id;?>)" data-toggle="tooltip" title="Editar"><i class="glyphicon glyphicon-pencil"></i></button>
									<button class="btn btn-danger" onclick="delete_conta(<?php echo $conta->con_id;?>)" data-toggle="tooltip" title="Deletar"><i class="glyphicon glyphicon-remove"></i></button>
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
      $("#con_valor").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:'.', affixesStay: false});

      $.ajax({
        type: "get",
        url: "empresa/lista_empresa_json",
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        success: function (obj) {
          if (obj != null) {
            var selectbox = $('#emp_id');
            selectbox.find('option').remove();
            $.each(obj, function (i, d) {
                $('<option>').val(d.emp_id).text(d.emp_rz_social).appendTo(selectbox);
            });
          }
        }  
      });

      $.ajax({
        type: "get",
        url: "tipoconta/lista_tipoconta_json",
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        success: function (obj) {
          if (obj != null) {
            var selectbox = $('#tpc_id');
            selectbox.find('option').remove();
            $.each(obj, function (i, d) {
                $('<option>').val(d.tpc_id).text(d.tpc_descricao).appendTo(selectbox);
            });
          }
        }  
      });

  } );
    var save_method; //for save method string
    var table;
 
 
    function add_conta(){
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }

     function gerar_contas_fixas(id){
      save_method = 'gerar_contas';
      $('#form_extra')[0].reset(); // reset form on modals
      $.ajax({
        url : "<?php echo site_url('conta/ajax_edit/')?>/" + id,
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
 
    function edit_conta(id){
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
 
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('conta/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data){
            $('[name="con_id"]').val(data.con_id);
            $('[name="emp_id"]').val(data.emp_id);
            $('[name="tpc_id"]').val(data.tpc_id);
            $('[name="con_valor"]').val(data.con_valor);
            $('[name="con_data"]').val(data.con_data);
            $('[name="con_status"]').val(data.con_status);
            $('[name="con_obs"]').val(data.con_obs);
            $('[name="con_fixo"]').val(data.con_fixo);
 
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edita Conta'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
      });
    }
 
    function save(){
      var url;
      if(save_method == 'add'){
        url = "<?php echo site_url('conta/cadastrar')?>";
      }else{
        url = "<?php echo site_url('conta/conta_update')?>";
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
 
    function delete_conta(id){
      if(confirm('Tem certeza?')){
        // ajax delete data from database
          $.ajax({
            url : "<?php echo site_url('conta/conta_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data){
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Erro ao excluir a conta');
            }
        });
 
      }
    }
    function gerar_conta(){
      if(confirm('Tem certeza? O sistema ira copia todas as contas do mês corrente para o próximo mês.')){
        // ajax delete data from database
          $.ajax({
            url : "<?php echo site_url('conta/gerar_contas_fixas')?>/",
            type: "POST",
            dataType: "JSON",
            success: function(data){
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
                alert('Erro ao gerar as contas');
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
        <h3 class="modal-title">Despesa</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="con_id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Empresa</label>
              <div class="col-md-9">
                  <select name="emp_id" class="form-control" id="emp_id">
                      <option value="">--Selecione--</option>
                  </select>
                  <span class="help-block"></span>
              </div>
            </div> 
            <div class="form-group">
              <label class="control-label col-md-3">Categoria</label>
              <div class="col-md-9">
                  <select name="tpc_id" class="form-control" id="tpc_id">
                      <option value="">--Selecione--</option>
                  </select>
                  <span class="help-block"></span>
              </div>
            </div> 
            <div class="form-group">
              <label class="control-label col-md-3">Valor</label>
              <div class="col-md-9">
                <input name="con_valor" id="con_valor" placeholder="Valor da conta" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Dt de Vencimento</label>
              <div class="col-md-9">
                <input name="con_data" placeholder="Data de Vencimento" class="form-control" type="date">
                <span class="help-block"></span>
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-md-3">Situação</label>
              <div class="col-md-9">
                  <select name="con_status" class="form-control">
                      <option value="">--Selecione--</option>
                      <option value="0">NÃO PAGO</option>
                      <option value="1">PAGO</option>
                  </select>
                  <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Tipo</label>
              <div class="col-md-9">
                  <select name="con_fixo" class="form-control">
                      <option value="">--Selecione--</option>
                      <option value="1">FIXO</option>
                      <option value="0">LIVRE</option>
                  </select>
                  <span class="help-block"></span>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Obs</label>
              <div class="col-md-9">
                <textarea name="con_obs" rows="10" cols="50" id="con_obs" class="form-control"></textarea>
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
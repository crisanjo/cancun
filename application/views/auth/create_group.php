<?php $this->load->view('template/topo'); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header"><?php echo lang('create_group_heading');?></h1>

    <div class="row placeholders">
    <!-- NÃO MEXER DAQUI PARA CIMA -->

    <p><?php echo lang('create_group_subheading');?></p>

    <?php if($message) :?>
        <div class="alert alert-info" id="infoMessage"><?php echo $message;?></div>
    <?php endif;?>

	<?php 
	echo form_open("auth/create_group", array("class" => "form-signin"));

	echo form_label("Nome","group_name", array("class" => "sr-only"));
    echo form_input(array(
    	"name" => "group_name",
    	"id" => "group_name",
    	"type" => "text",
    	"class" => "form-control",
    	"placeholder" => "Nome",
    	"autofocus" => "true",
    	"required" => "true"
    ));
    echo "<br />";

    echo form_label("Descrição","description", array("class" => "sr-only"));
    echo form_input(array(
    	"name" => "description",
    	"id" => "description",
    	"type" => "text",
    	"class" => "form-control",
    	"placeholder" => "Descrição",
    	"required" => "true"
    ));
    echo "<br />";

    echo form_submit(array(
        "class" => "btn btn-lg btn-primary btn-block",
        "name" => "submit",
        "value" => "Criar Grupo",
        "type" => "submit"
    ));
	
	echo form_close();
	?>

<!-- NÃO MEXER DAQUI PARA BAIXO -->
                    </div>
                </div>
            </div>
        </div>

<?php $this->load->view('template/rodape'); ?>
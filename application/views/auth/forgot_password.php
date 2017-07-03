<?php $this->load->view('template/header');?>

<div class="container">
    <br /><br /><br />
    <div class="row">
        <div class="col-md-6 col-sm-6"><img src="<?= base_url(); ?>assests/bootstrap/img/logo.png" class="img-responsive" alt="Imagem responsiva"></div>
        <div class="col-md-6 col-sm-6">
            
        	<h1><?php echo lang('forgot_password_heading');?></h1>
			<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>

			<div id="infoMessage"><?php echo $message;?></div>

			<?php echo form_open("auth/forgot_password");?>

			      <p>
			      	<label for="identity">
			      		<?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?>
			      	</label> <br />
			      		<?php 
			      			echo form_input(array(
				                "name" => "identity",
				                "id" => "identity",
				                "type" => "text",
				                "class" => "form-control",
				                "placeholder" => "E-mail",
				                "autofocus" => "true",
				                "required" => "true"
				            ));
			      		?>
			      </p>

			      <p><?php
			      	echo form_submit(array(
                		"class" => "btn btn-lg btn-primary btn-block",
                		"name"  => "submit",
                		"value" => "Enviar",
                		"type"  => "submit"
            		));
			      	?>
			      </p>

			<?php echo form_close();?>


		</div>
    </div>

</div> <!-- /container -->

<?php $this->load->view('template/footer');?>
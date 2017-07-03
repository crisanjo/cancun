<?php $this->load->view('template/header');?>

<div class="container">
    <br /><br /><br />
    <div class="row">
        <div class="col-md-6 col-sm-6"><img src="<?= base_url(); ?>assests/bootstrap/img/logo.png" class="img-responsive" alt="Imagem responsiva"></div>
        <div class="col-md-6 col-sm-6">
            <h2 class="form-signin-heading">Acesso ao sistema</h2>
            <div id="infoMessage"><?php echo $message; ?></div>
            <?php
            echo form_open("auth/login", array("class" => "form-signin"));

            echo form_label("E-mail","identity", array("class" => "sr-only"));
            echo form_input(array(
                "name" => "identity",
                "id" => "identity",
                "type" => "text",
                "class" => "form-control",
                "placeholder" => "E-mail",
                "autofocus" => "true",
                "required" => "true"
            ));
            echo "<br />";

            echo form_label("Senha", "password", array("class" => "sr-only"));
            echo form_password(array(
                "name" => "password",
                "id" => "password",
                "class" => "form-control",
                "placeholder" => "Senha",
                "required" => "true"
            ));
            echo "<br />";

            echo form_label("Lembre-me", "remember");
            echo form_checkbox("remember", "1", FALSE, array("id"=>"remember"));

            echo form_submit(array(
                "class" => "btn btn-lg btn-primary btn-block",
                "name" => "submit",
                "value" => "Login",
                "type" => "submit"
            ));

            echo form_close();
            ?>
            <p><a href="forgot_password"><?php echo lang('login_forgot_password'); ?></a></p> 
        </div>
    </div>

</div> <!-- /container -->

<?php $this->load->view('template/footer');?>
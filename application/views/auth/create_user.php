<?php $this->load->view('template/topo'); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header"><?php echo lang('create_user_heading');?></h1>

    <div class="row placeholders">
    <!-- NÃO MEXER DAQUI PARA CIMA -->

      <p><?php echo lang('create_user_subheading');?></p>
      
      <?php if($message) :?>
        <div class="alert alert-info" id="infoMessage"><?php echo $message;?></div>
      <?php endif;?>

      <?php 
      echo form_open("auth/create_user", array("class" => "form-signin"));
      
      echo form_label("Primeiro nome","first_name", array("class" => "sr-only"));
      echo form_input(array(
        "name" => "first_name",
        "id" => "first_name",
        "type" => "text",
        "class" => "form-control",
        "placeholder" => "Primeiro nome",
        "autofocus" => "true",
        "required" => "true"
      ));
      echo "<br />";

      echo form_label("Sobrenome","last_name", array("class" => "sr-only"));
      echo form_input(array(
        "name" => "last_name",
        "id" => "last_name",
        "type" => "text",
        "class" => "form-control",
        "placeholder" => "Sobrenome",
        "required" => "true"
      ));
      echo "<br />";
      
      if($identity_column!=='email') {
          echo '<p>';
          echo lang('create_user_identity_label', 'identity');
          echo '<br />';
          echo form_error('identity');
          echo form_input($identity);
          echo '</p>';
      }

      echo form_label("E-mail","email", array("class" => "sr-only"));
      echo form_input(array(
        "name" => "email",
        "id" => "email",
        "type" => "text",
        "class" => "form-control",
        "placeholder" => "E-mail",
        "required" => "true"
      ));
      echo "<br />";

      echo form_label("Telefone","phone", array("class" => "sr-only"));
      echo form_input(array(
        "name" => "phone",
        "id" => "phone",
        "type" => "text",
        "class" => "form-control",
        "placeholder" => "Telefone",
        "required" => "true"
      ));
      echo "<br />";

      echo form_label("Senha","password", array("class" => "sr-only"));
      echo form_input(array(
        "name" => "password",
        "id" => "password",
        "type" => "password",
        "class" => "form-control",
        "placeholder" => "Senha",
        "required" => "true"
      ));
      echo "<br />";

      echo form_label("Confirmar Senha","password_confirm", array("class" => "sr-only"));
      echo form_input(array(
        "name" => "password_confirm",
        "id" => "password_confirm",
        "type" => "password",
        "class" => "form-control",
        "placeholder" => "Confirmar Senha",
        "required" => "true"
      ));
      echo "<br />";
      
      echo form_submit(array(
        "class" => "btn btn-lg btn-primary btn-block",
        "name" => "submit",
        "value" => "Criar Usuário",
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
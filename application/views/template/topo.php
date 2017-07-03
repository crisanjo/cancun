<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="<?= base_url(); ?>assests/bootstrap/img/favicon.ico">

        <title>Painel de Controle</title>

        <!-- Bootstrap core CSS -->
        <link href="<?= base_url(); ?>assests/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url('assests/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="<?= base_url(); ?>assests/bootstrap/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?= base_url(); ?>assests/bootstrap/css/dashboard.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="<?= base_url(); ?>assests/bootstrap/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="<?= base_url(); ?>assests/bootstrap/js/ie-emulation-modes-warning.js"></script>
        <script src="<?php echo base_url('assests/jquery/jquery-3.2.1.min.js')?>"></script>
        <script src="<?php echo base_url('assests/bootstrap/js/bootstrap.min.js')?>"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Condomínio Edifício Cancún</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="Auth/logout">Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <?php $this->load->view('template/menu_esq'); ?>
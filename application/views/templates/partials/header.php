<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title> <?php echo $title ? $title : 'Evaluation'; ?> | Faculty Evaluation System</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--<link rel="apple-touch-icon" href="apple-touch-icon.png">-->

        <!-- Custom styles for this template -->
        <link href="<?php echo base_url();?>assets/css/app.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/css/styles.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <base href="<?=base_url();?>">

        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/script.js"></script>
    </head>

    <?php
      $bodyClass = 'body';
      if (!$this->uri->segment(1)) {
        $bodyClass .= ' page-home ';
      }
      else {
        $count = 0;
        $prefix = ' page-';
        while( true ) {
          if ( $this->uri->segment(++$count) ) {
            $bodyClass .= $prefix . $this->uri->segment($count);
            $prefix .= $this->uri->segment($count) . '-';
          }
          else {
            break;
          }
        }
      }
    ?>

    <body class="<?php echo $bodyClass;?>">
      <!--[if lt IE 8]>
          <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
      <![endif]-->
      <a class="skip-main" href="#main" style="display:none">Skip to main content</a>
      <div id="main">
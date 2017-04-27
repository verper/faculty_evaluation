<?php
    global $logged_in;
    if ( null == $this->session->userdata('logged_in') ) {
      redirect(base_url());
    }
    else {
      $logged_in = $this->session->userdata('logged_in');
    }
?>

<?php $this->load->view('templates/partials/header.php'); ?>

  <link href="/assets/css/dashboard.css" rel="stylesheet">
  <link href="/assets/css/profile.css" rel="stylesheet">

  <?php $this->load->view('templates/navbar.php'); ?>

<div class="container-fluid main-container">
    <div class="row profile">
    <div class="col-md-3">
      <div class="profile-sidebar box-shadow">
        <?php $this->load->view('templates/sidebar.php'); ?>
      </div>
    </div>
    <div class="col-md-9">
      <div class="profile-content box-shadow">
        <div id="site-message">
          <?php if ( !empty($this->session->flashdata()) ): ?>
          <?php
            $alert_class = 'alert-info';
            $alert_msg = '';
            $header = '';
            if ( $this->session->flashdata('success') ) { 
              $alert_class = 'alert-success'; 
              $alert_msg = $this->session->flashdata('success');
              $header = '<h4><i class="glyphicon glyphicon-ok-circle"></i> Successful!</h4>';
            }
            elseif ( $this->session->flashdata('error') ) { 
              $alert_class = 'alert-danger'; 
              $alert_msg = $this->session->flashdata('error');
              $header = '<h4><i class="glyphicon glyphicon-remove-circle"></i> Error!</h4>'; 
            }
            elseif ( $this->session->flashdata('warning') ) { 
              $alert_class = 'alert-warning'; 
              $alert_msg = $this->session->flashdata('warning'); 
              $header = '<h4><i class="glyphicon glyphicon-warning-sign"></i> Warning!</h4>';
            }
            elseif ( $this->session->flashdata('info') ) { 
              $alert_class = 'alert-info'; 
              $alert_msg = $this->session->flashdata('info');
              $header = '<h4><i class="glyphicon glyphicon-exclamation-sign"></i> Attention!</h4>'; 
            }
            else { $class = 'alert-info'; }
          ?>
          <div class="page-message alert alert-dismissible <?php echo $alert_class;?>">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo $header;?>
            <p><?php echo $alert_msg;?></p>
          </div>
          <?php endif; ?>
        </div>

      <?php $this->load->view('templates/' . $content); ?>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('templates/partials/footer.php'); ?>
<br>
<br>
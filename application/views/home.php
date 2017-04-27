<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->load->view('templates/partials/header.php'); ?>
	<div class="brand-header">
    	<h1><strong>Fellowship Baptist Church</strong></h1>
	</div>

	<div class="content">
		<img src="/assets/images/cover.jpg" class="cover-image">
		<div class="container">
			<div class="jumbotron">
			  <div class="row">
					<div class="col-sm-6">
						<h2><strong> Faculty Evaluation System </strong></h2>
						<p> A thesis project for evaluating faculties. </p>
					</div>
					<div class="col-sm-4">
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
						<legend> <h4><i class="glyphicon glyphicon-user"></i> Login</h4> </legend>
						<form class="form form-login" method="post" action="/login">
							<div class="form-group">
								<input class="form-control" type="text" name="id" placeholder="ID Number (ex. 123-4567-890)" />
							</div>
							<div class="form-group">
								<input class="form-control" type="password" name="password" placeholder="************" />
							</div>
							<div class="form-footer">
								<input class="btn btn-primary btn-block" type="submit" />
								<input type="hidden" name="form_id" value="login_user" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div> <!-- /container -->
	</div>

<?php $this->load->view('templates/partials/footer.php'); ?>
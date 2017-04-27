<h1 class="page-header">Evaluation</h1>

<?php
	global $logged_in;

	if ( $logged_in->role == '5' ) {
		$this->load->view('templates/inner/forms_usage');
	}
	elseif ( $logged_in->role == '4' || $logged_in->role == '3' ) {
		$this->load->view('templates/inner/peer_schedule');
	}
?>
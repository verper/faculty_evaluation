<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	private $data = array();

	/**
	 * ADMIN CONTROLLER CLASS
	 * 
	 * Class constructor
	 * Loads models, libraries needed
	 * Checks if admin is logged in, and redirects to login page if not
	 */
	function __construct()
	{
		parent::__construct();

		// $this->load->model('colleges_model');
		// $this->load->model('programs_model');
		// $this->load->model('courses_model');
		$this->load->model('user_model', 'user');
	}

	/**
	 * ADMIN CONTROLLER CLASS
	 * 
	 * Dashboard view
	 */
	function index() {
		$this->data['title'] = 'Profile';
		$this->data['content'] = 'profile';
		$this->load->view('page-user', $this->data);
	}

	function update() {
		if ( $this->input->post('form_id') == 'update_profile' ) {

			if ( $_FILES['photo']['name'] != '' ) {
	            $config['upload_path']          = './media/';
	            $config['allowed_types']        = 'gif|jpg|png';
	            $config['max_size']             = 150;
	            $config['max_width']            = 1024;
	            $config['max_height']           = 768;
	            $config['encrypt_name'] 		= TRUE;

	            $this->load->library('upload', $config);
	            if ( ! $this->upload->do_upload('photo'))
	            {
	                    $error = array('error' => $this->upload->display_errors());
	                    $error = implode('<br/>', $error);
	                    $this->session->set_flashdata('error', $error);
	                    // $this->session->set_flashdata('error', print_r($error, true));
	                    redirect('profile');
	            }

	        	$photo = $this->upload->data();
	        	$photo = $photo['file_name'];
			}
			
        	$user = $this->session->userdata('logged_in');
        	$id = $user->id;
        	$role = $user->role;
        	$new_id = $this->input->post('userid');
        	$lastname = $this->input->post('lastname');
        	$firstname = $this->input->post('firstname');
        	$middlename = $this->input->post('middlename');
        	$save = $this->user->edit($id,$new_id,$lastname,$firstname,$middlename,$role,$photo);

        	if ( $save ) {
        		$this->session->set_flashdata('success', 'Your profile has been updated successfully!');
        		$new_user = $this->user->data($new_id);
        		if ( file_exists('media/'.$user->photo) ) {
        			if ( $user->photo != 'default.png' ){
        				unlink('media/' . $user->photo);
        			}
        		}
        		$this->session->set_userdata('logged_in', $new_user);
        	}
        	else {
        		$this->session->set_flashdata('error', 'Unable to update profile please try again.');
        	}
		}
		redirect('profile');
	}


	function change_password() {
		if ( $this->input->post('form_id') == 'change_password' ) {
			$current = $this->input->post('current');
			$new = $this->input->post('new');
			$confirm = $this->input->post('confirm');
			$user = $this->session->userdata('logged_in');

			if ( md5($current) != $user->password ) {
				$this->session->set_flashdata('error', 'You have entered incorrect password.');
				redirect('profile');
			}

			if ( $new != $confirm ) {
				$this->session->set_flashdata('error', 'New password and confirm password did not match.');
				redirect('profile');
			}

			$id = $user->id;
			$password = $new;
			$save = $this->user->change_password($id, $password);
			if ($save) {
				$this->session->set_flashdata('success','Password has been changed successfully.');
			}
			else {
				$this->session->set_flashdata('error', 'Unable to change password please try again.');
			}
		}
		redirect('profile');
	}
}
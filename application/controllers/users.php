<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

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

		// $this->load->model('colleges');
		// $this->load->model('programs');
		// $this->load->model('courses');
		$this->load->model('user_model', 'user');
	}

	/**
	 * ADMIN CONTROLLER CLASS
	 * 
	 * Dashboard view
	 */
	function index() {
		$this->data['title'] = 'Users';
		$this->data['content'] = 'users';
		$this->data['users'] = $this->user->get_list();
		$this->load->view('page-user', $this->data);
	}


	function add() {
		if ( $this->input->post('form_id')=='new_user' ) {
			$id = $this->input->post('userid');
			$lastname = strtoupper($this->input->post('lastname'));
			$firstname = strtoupper($this->input->post('firstname'));
			$middlename = strtoupper($this->input->post('middlename'));

			$logged_in = $this->session->userdata('logged_in');
			$role = $logged_in->role == '5' ? $this->input->post('role') : '1'; //automatically set user role to student if logged in user is not an admin

			$save = $this->user->add($id,$lastname,$firstname,$middlename,$role);
			
			if ($save == true) {
				$this->session->set_flashdata('success', 'User <strong><a href="/users/edit/' . $id . '">' . $lastname . '</a></strong> has been saved.');
				redirect('users/add');
			}
			else {
				$this->session->set_flashdata('error', 'User ID <strong>' . $id . '</strong> already exist!');
				redirect('users/add');
			}
			
			exit();
		}

		$this->data['title'] = 'New User';
		$this->data['content'] = 'users-add';
		$this->data['roles'] = $this->user->get_roles();
		$this->load->view('page-user', $this->data);
	}


	function edit($slug) {
		$userid = $slug;

		$check = $this->user->data($userid);
		if ( !$check ) {
			$this->session->set_flashdata('error', 'User ' . $userid . ' do not exist!');
			redirect('users');
		}

		if ( $this->input->post('form_id')=='edit_user' ) {
			$id = $this->input->post('user_id');
			$new_id = $this->input->post('userid');
			$lastname = strtoupper($this->input->post('lastname'));
			$firstname = strtoupper($this->input->post('firstname'));
			$middlename = strtoupper($this->input->post('middlename'));
			
			$logged_in = $this->session->userdata('logged_in');
			$role = $logged_in->role == '5' ? $this->input->post('role') : '1'; //automatically set user role to student if logged in user is not an admin

			$save = $this->user->edit($id,$new_id,$lastname,$firstname,$middlename,$role);
			if ($save == true) {
				$this->session->set_flashdata('success', 'User <strong>' . $id . '</strong> has been updated.');
				redirect('users/edit/' . $new_id);
			}
			else {
				$this->session->set_flashdata('error', 'Can\'t update <strong>' . $userid . '</strong>.');
				redirect('users/edit/' . $id);
			}
			exit();
		}

		$this->data['title'] = 'Edit User - ' . $userid;
		$this->data['content'] = 'users-add';
		$this->data['roles'] = $this->user->get_roles();
		$this->data['user'] = $this->user->data($userid);
		$this->load->view('page-user', $this->data);		
	}


	function delete($slug) {
		$userid = $slug;

		$check = $this->user->data($userid);
		if ( !$check ) {
			$this->session->set_flashdata('error', 'User ' . $userid . ' do not exist!');
			redirect('users');
		}
		
		$save = $this->user->delete($userid);
		if ($save == true) {
			$this->session->set_flashdata('success', 'User <strong>' . $userid . '</strong> has been removed.');
		}
		else {
			$this->session->set_flashdata('error', 'Can\'t remove <strong>' . $id . '</strong>.');
		}
		redirect('users');
	}


	function reset_password() {
		if ( $this->input->post('form_id') == 'reset_password' ) {
			$id = $this->input->post('user_id');

			$save = $this->user->reset_password($id);
			if ($save) {
				$this->session->set_flashdata('success', 'User <strong>' . $id . '</strong> password has been updated.');
			}
			else {
				$this->session->set_flashdata('error', 'Unable to reset <strong>' . $id . '</strong> password.');
			}

			redirect('users/edit/' . $id);
		}
		redirect('users');
	}
}
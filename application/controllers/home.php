<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	var $data = array();

	public function __contstruct() {
		parent::__construct();

		$this->load->model('user_model');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if ( $this->session->userdata('logged_in') ) {
			$search = $this->session->userdata('logged_in');
			if ( $search->role == '5' ) {
				redirect('evaluation');
			}
			else {
				redirect('evaluate');
			}
		}
		
		$this->data['title'] = 'FBC';
		$this->load->view('home', $this->data);
	}


	public function login() {
		if ( $this->input->post('form_id') == 'login_user' ) {
			$this->load->model('user_model');

			$id = $this->input->post('id');
			$password = $this->input->post('password');

			$search = $this->user_model->data($id);
			if ( $search ) {
				if ( $search->password == md5($password) ) {
					$this->session->set_userdata('logged_in', $search);
					if ( $search->role == '5' ) {
						redirect('evaluation');
					}
					else {
						redirect('evaluate');
					}
				}
				else {
					$this->session->set_flashdata('error', 'Incorrect password.');
					redirect(base_url());
				}
			}
			else {
				$this->session->set_flashdata('error', 'User cannot be found.');
				redirect(base_url());
			}
		}

		redirect(base_url());
	}


	public function logout() {
		$this->session->unset_userdata('logged_in');
		redirect(base_url());
	}
}

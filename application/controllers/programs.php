<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Programs extends CI_Controller {

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

		$this->load->model('colleges_model', 'colleges');
		$this->load->model('programs_model', 'programs');
		// $this->load->model('courses');
		$this->load->model('user_model', 'user');
	}

	/**
	 * ADMIN CONTROLLER CLASS
	 * 
	 * Dashboard view
	 */
	function index() {
		if ( $this->input->post('form_id')=='new_program' ) {
			$code = strtoupper($this->input->post('code'));
			$code = str_replace(' ','',$code);
			$title = strtoupper($this->input->post('program'));
			$supervisor = $this->input->post('supervisor');
			$college = $this->input->post('college');

			$save = $this->programs->add($code,$title,$supervisor,$college);
			
			if ($save == true) {
				$this->session->set_flashdata('success', 'Program <strong>' . $new_id . '</a></strong> has been saved.');
				redirect('programs');
			}
			else {
				$this->session->set_flashdata('error', 'Program code <strong>' . $code . '</strong> already exists.');
				redirect('programs');
			}
			
			exit();
		}
		elseif ( $this->input->post('form_id')=='edit_program' ) {
			$title = strtoupper($this->input->post('program'));
			$supervisor = $this->input->post('supervisor');
			$college = $this->input->post('college');
			$new_id = $this->input->post('code');
			$new_id = str_replace(' ','',$new_id);
			$id = $this->input->post('program_id');

			if ( null == $this->programs->data($id) ) {
				$this->session->set_flashdata('error', 'Program <strong>' . $id . '</strong> doesn\'t exits.');
				redirect('programs');
			}

			$save = $this->programs->edit($id,$new_id,$title,$supervisor,$college);
			
			if ($save == true) {
				$this->session->set_flashdata('success', 'Program <strong>' . $new_id . '</a></strong> has been saved.');
				redirect('programs');
			}
			else {
				$this->session->set_flashdata('error', 'Program code <strong>' . $new_id . '</strong> already exists.');
				redirect('programs');
			}
			
			exit();
		}
		
		$this->data['title'] = 'Programs';
		$this->data['content'] = 'programs';
		$this->data['colleges'] = $this->colleges->get_list();
		$this->data['programs'] = $this->programs->get_list();
		$this->data['supervisors'] = $this->user->get_list_by_role(3); // 3 = supervisors
		$this->load->view('page-user', $this->data);
	}


	function delete($slug) {
		$id = $slug;

		if ( null == $this->programs->data($id) ) {
			$this->session->set_flashdata('error', 'Program <strong>' . $id . '</strong> doesn\'t exits.');
			redirect('programs');
		}

		$save = $this->programs->delete($id);

		if ($save == true) {
			$this->session->set_flashdata('success', 'Program <strong>' . $id . '</strong> has been removed.');
		}
		else {
			$this->session->set_flashdata('error', 'Program <strong>' . $id . '</strong> doesn\'t exits.');
		}
		redirect('programs');
	}

}
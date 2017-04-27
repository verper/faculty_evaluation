<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Colleges extends CI_Controller {

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
		$this->load->model('user_model', 'user');
	}

	/**
	 * ADMIN CONTROLLER CLASS
	 * 
	 * Colleges view
	 */
	function index() {
		if ( $this->input->post('form_id')=='new_college' ) {
			$code = strtoupper($this->input->post('code'));
			$title = strtoupper($this->input->post('college'));
			$dean = $this->input->post('dean');

			$save = $this->colleges->add($code,$title,$dean);
			
			if ($save == true) {
				$this->session->set_flashdata('success', 'College <strong>' . $title . '</a></strong> has been saved.');
				redirect('colleges');
			}
			else {
				$this->session->set_flashdata('error', 'Code <strong>' . $code . '</strong> already exist.');
				redirect('colleges');
			}
			
			exit();
		}
		elseif ( $this->input->post('form_id')=='edit_college' ) {
			$new_id = strtoupper($this->input->post('code'));
			$title = strtoupper($this->input->post('college'));
			$dean = $this->input->post('dean');
			$id = $this->input->post('college_id');

			if ( null == $this->colleges->data($id) ) {
				$this->session->set_flashdata('error', 'College ' . $id . ' do not exist!');
			}

			$save = $this->colleges->edit($id,$new_id,$title,$dean);
			
			if ($save == true) {
				$this->session->set_flashdata('success', 'College <strong>' . $title . '</a></strong> has been saved.');
				redirect('colleges');
			}
			else {
				$this->session->set_flashdata('error', 'Code <strong>' . $code . '</strong> already exist.');
				redirect('colleges');
			}
			
			exit();
		}

		$this->data['title'] = 'Colleges';
		$this->data['content'] = 'colleges';
		$this->data['colleges'] = $this->colleges->get_list();
		$this->data['deans'] = $this->user->get_list_by_role(4); // 4 = dean
		$this->load->view('page-user', $this->data);
	}


	function delete($slug) {
		$id = $slug;

		if ( null == $this->colleges->data($id) ) {
			$this->session->set_flashdata('error', 'College ' . $id . ' do not exist!');
		}

		$save = $this->colleges->delete($id);
		if ($save == true) {
			$this->session->set_flashdata('success', 'College <strong>' . $id . '</strong> has been removed.');
		}
		else {
			$this->session->set_flashdata('error', 'College <strong>' . $id . '</strong>. doesn\'t exist.');
		}
		redirect('colleges');		
	}

}
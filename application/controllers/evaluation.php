<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evaluation extends CI_Controller {

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

		$this->load->model('colleges_model','colleges');
		$this->load->model('programs_model','programs');
		$this->load->model('courses_model','courses');
		$this->load->model('user_model','user');
		$this->load->model('forms_model','forms');
		$this->load->model('evaluation_model','evaluation');
	}

	/**
	 * ADMIN CONTROLLER CLASS
	 * 
	 * Dashboard view
	 */
	function index() {
		$this->data['title'] = 'Evaluation';
		$this->data['content'] = 'evaluation';
		$this->data['roles'] = $this->user->get_roles();
		$this->data['forms'] = $this->forms->get_list();
		$this->data['role_form'] = $this->forms->get_role_form();
		$this->data['faculties'] = $this->user->get_list_by_role(2); // 2 = faculty id
		$this->data['schedules'] = $this->evaluation->peer_list();
		$this->load->view('page-user', $this->data);
	}


	function form_usage() {
		if ( $this->input->post('form_id') == 'form_usage' ) {
			$form = $this->input->post('form');
			$save = $this->forms->form_usage_by_role($form);

			if ($save) {
				$this->session->set_flashdata('success','Form usage has been updated.');
			}
			else {
				$this->session->set_flashdata('error','An uknown error has occured. Please refresh page again.');
			}
		}

		redirect('evaluation');
	}


	function peer_schedule() { 
		if ( $this->input->post('form_id') == 'peer_schedule' ) {
			$schedule = date('Y-m-d', strtotime($this->input->post('schedule')));
			$evaluator = $this->input->post('evaluator');
			$subject = $this->input->post('subject');

			if ( $evaluator == $subject ) {
				$this->session->set_flashdata('error', 'Evaluator cannot be the same with the subject!');
				redirect('evaluation');
			}
			$check_role = $this->user->data($subject);
			if ( $check_role->role != '2' ) {
				redirect('evaluation');
			}

			$save = $this->evaluation->peer_schedule($schedule,$evaluator,$subject);

			if ( $save ) {
				$this->session->set_flashdata('success','Peer to peer schedule has been saved.');
			}
			else {
				$this->session->set_flashdata('error','Unable to save peer to peer schedule. Please try again.');
			}

			redirect('evaluation');
		}

		redirect('evaluation');
	}

	function update_schedule() {
		if ( $this->input->post('form_id') == 'update_schedule' ) {
			$schedule = date('Y-m-d', strtotime($this->input->post('schedule')));
			$evaluator = $this->input->post('evaluator');
			$subject = $this->input->post('subject');
			$status = $this->input->post('status');
			$id = $this->input->post('sched_id');

			if ( $evaluator == $subject ) {
				$this->session->set_flashdata('error', 'Evaluator cannot be the same with the subject!');
				redirect('evaluation');
			}
			$check_role = $this->user->data($subject);
			if ( $check_role->role != '2' ) {
				redirect('evaluation');
			}

			$save = $this->evaluation->update_schedule($id, $schedule, $evaluator, $subject, $status);

			if ( $save ) {
				$this->session->set_flashdata('success','Peer to peer schedule has been updated.');
			}
			else {
				$this->session->set_flashdata('error','Unable to update peer to peer schedule. Please try again.');
			}

			redirect('evaluation');
		}
		redirect('evaluation');
	}


	function reset_ratings() {
		if ( $this->input->post('form_id') == 'reset_ratings' ) {
			
		}
	}
}
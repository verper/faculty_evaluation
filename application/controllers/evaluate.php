<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evaluate extends CI_Controller {

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
		$this->load->model('courses_model', 'courses');
		$this->load->model('user_model', 'user');
		$this->load->model('forms_model', 'forms');
		$this->load->model('evaluation_model', 'evaluation');
	}

	/**
	 * ADMIN CONTROLLER CLASS
	 * 
	 * Dashboard view
	 */
	function index() {
		$faculties = $this->user->get_list_by_role(2); // all faculty list
		$logged_in = $this->session->userdata('logged_in');

		// Not student
		if ( $logged_in->role != '1' ) {
			$faculties = $this->evaluation->get_faculty_list($logged_in->id);
		}

		$this->data['title'] = 'Evaluate';
		$this->data['content'] = 'evaluate';
		$this->data['faculties'] = $faculties;
		$this->load->view('page-user', $this->data);
	}


	function evaluate($slug) {
		$logged_in = $this->session->userdata('logged_in');
		$evaluator = $logged_in->id;
		$form  = $this->forms->get_user_form($logged_in->role);
		
		$validate = $this->evaluation->validate_evaluation($logged_in->id, $slug);
		if ( !$validate ) { redirect('evaluate'); }
		
		$faculty = $this->user->data($slug);

		if ( $logged_in->role == '3' && $faculty->role == '3') {
			$form  = $this->forms->get_user_form(2); //change form to peer to peer if same program head
		}

		$this->data['title'] = $faculty->id;
		$this->data['content'] = 'evaluate-user';
		$this->data['faculty'] = $faculty;
		$this->data['form'] = $form;
		$this->data['period'] = $this->evaluation->get_sched();
		$this->load->view('page-user', $this->data);
	}


	function process_evaluation() {
		if ( $this->input->post('form_id') == 'process_evaluation' ) {
			$logged_in = $this->session->userdata('logged_in');
			$evaluator = $logged_in->id;
			$faculty = $this->input->post('faculty');
			$ratings = $this->input->post('ans');
			$comments = $this->input->post('comments');
			
			$validate = $this->evaluation->validate_evaluation($logged_in->id, $faculty);
			if ( !$validate ) { redirect('evaluate'); }

			$form  = $this->forms->get_user_form($logged_in->role);

			$faculty_data = $this->user->data($faculty);
			if ( $logged_in->role == '3' && $faculty_data->role == '3') {
				$form  = $this->forms->get_user_form(2); //change form to peer to peer if same program head
			}
			
			if ( $this->evaluation->number_of_questions($form->form->id) != count($ratings) ) {
				$this->session->set_flashdata('error', 'Make you sure have rate all the questions. Please try again.');
				redirect('evaluate');
			}

			$save = $this->evaluation->process_evaluation($evaluator, $faculty, $ratings, $form, $comments);
			if ( $save ) {
				$fac = $this->user->data($faculty);
				$fac_name = $fac->lastname . ', ' . $fac->firstname . ' ' . $fac->middlename;
				$this->session->set_flashdata('success','You have successfully evaluated <strong>' . $fac_name . '</strong>');
			}
			else {
				$this->session->set_flashdata('error', 'Unable to process evaluation please try again.');
			}
		}

		redirect('evaluate');
	}
}
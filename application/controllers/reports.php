<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {

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
		$this->load->model('forms_model', 'forms');
		$this->load->model('evaluation_model', 'evaluation');
	}

	/**
	 * ADMIN CONTROLLER CLASS
	 * 
	 * Dashboard view
	 */
	function index() {
		$logged_in = $this->session->userdata('logged_in');
		if ( $logged_in->role == '4' ) {
			redirect('reports/overall');
		}


		$this->data['title'] = 'Reports';
		$this->data['content'] = 'reports';
		$this->load->view('page-user', $this->data);
	}

	function overall() {
		$logged_in = $this->session->userdata('logged_in');
		$faculties = $this->user->get_list_by_college($logged_in->id);

		$this->data['title'] = 'Reports Overall';
		$this->data['content'] = 'reports_overall';
		$this->data['faculties'] = $faculties;
		$this->load->view('page-user', $this->data);
	}

	function pdf() {
		// var_dump($this->input->post()); exit();
		if ( $this->input->post('form_id') == 'pdf_report' ) {
			$form = $this->forms->get_user_form($this->input->post('form'));
			$logged_in = $this->session->userdata('logged_in');
			$this->data['form']  = $form;
			$this->data['logged_in'] = $logged_in;
		}
		else {
			redirect('reports');
		}

		$this->data['title'] = $logged_in->lastname . ' - ' . $form->form->title;

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$html=$this->load->view('pdf/faculty',$this->data,true);	 
		$pdf->WriteHTML($html);

		// write the HTML into the PDF
		$output = $logged_in->lastname . '_' . $form->form->title . '_' . date('Y_m_d_H_i_s') . '_.pdf';
		$pdf->Output("$output", 'I');
	}
}
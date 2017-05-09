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

		$this->load->model('colleges_model', 'colleges');
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
		if ( $logged_in->role == '4' || $logged_in->role == '5' ) {
			redirect('reports/overall');
		}


		$this->data['title'] = 'Reports';
		$this->data['content'] = 'reports';
		$this->load->view('page-user', $this->data);
	}

	function overall($slug='') {
		$logged_in = $this->session->userdata('logged_in');
		$faculties = $this->user->get_list_by_college($logged_in->id);
		$college = $this->db->select('title')->from('colleges')->where('dean', $logged_in->id)->get()->row();

		$this->data['title'] = 'Reports Overall';
		$this->data['content'] = 'reports_overall';
		$this->data['faculties'] = $faculties;
		$this->data['college_name'] = $college ? $college->title : '';
		
		if ( $slug == 'pdf' ) {
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			$html=$this->load->view('templates/reports_overall',$this->data,true);	 
			$pdf->WriteHTML($html);

			// write the HTML into the PDF
			$output = 'Overall_Reports_' . date('Y_m_d_H_i_s') . '_.pdf';
			$pdf->Output("$output", 'I');			
		}

		$this->load->view('page-user', $this->data);
	}

	function pdf($fac_id='', $form_id='') {
		$logged_in = $this->session->userdata('logged_in');
		$user = '';
		
		if ( !empty($fac_id) && !empty($form_id) && ($logged_in->role != '4' || $logged_in->role != '5')) {
			redirect('reports');
		}
		if ( !empty($fac_id) && !empty($form_id) && ($logged_in->role == '4' || $logged_in->role == '5') ) {
			$form = $this->forms->get_user_form($form_id);
			$this->data['form']  = $form;
			$user = $this->user->data($fac_id);
			$this->data['logged_in'] = $user;			
		}

		if ( $this->input->post('form_id') == 'pdf_report' ) {
			$form = $this->forms->get_user_form($this->input->post('form'));
			$user = $logged_in;
			$this->data['form']  = $form;
			$this->data['logged_in'] = $user;
		}
		else {
			if ( $logged_in->role != '4' || $logged_in->role != '5' ) { redirect('reports'); }
		}

		$this->data['title'] = $user->lastname . ' - ' . $form->form->title;

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$html=$this->load->view('pdf/faculty',$this->data,true);	 
		$pdf->WriteHTML($html);

		// write the HTML into the PDF
		$output = $user->lastname . '_' . $form->form->title . '_' . date('Y_m_d_H_i_s') . '_.pdf';
		$pdf->Output("$output", 'I');
	}


	function faculty() {
		$logged_in = $this->session->userdata('logged_in');
		$college = $this->db->select('title')->from('colleges')->where('dean', $logged_in->id)->get()->row();
		$faculties = $this->user->get_list_by_college($logged_in->id);

		$this->data['title'] = 'View per report';
		$this->data['content'] = 'reports_faculty';
		$this->data['faculties'] = $faculties;
		$this->data['college_name'] = $college ? $college->title : '';
		$this->load->view('page-user', $this->data);
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forms extends CI_Controller {

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
		// $this->load->model('user');
		$this->load->model('forms_model', 'forms');
	}

	/**
	 * ADMIN CONTROLLER CLASS
	 * 
	 * Dashboard view
	 */
	function index() {
		if ( $this->input->post('form_id') == 'new_form' ) {
			$title = $this->input->post('title');

			$save = $this->forms->add($title);

			if ( $save ) {
				$this->session->set_flashdata('success', 'Form <strong>' . $title . '</strong> has been created!');
			}
			else {
				$this->session->set_flashdata('error', 'Form <strong>' . $title . '</strong> already exist!');
			}

			redirect('forms');
		}

		$this->data['title'] = 'Forms';
		$this->data['content'] = 'forms';
		$this->data['forms'] = $this->forms->get_list();
		$this->load->view('page-user', $this->data);
	}


	function edit($id) {
		$form = $this->forms->data($id);

		$this->data['title'] = $form->title . ' | Forms ';
		$this->data['content'] = 'form-edit';
		$this->data['data'] = $form;
		$this->data['categories'] = $this->forms->get_categories($id);
		$this->load->view('page-user', $this->data);
	}

	function edit_form() {
		$form = $this->input->post('data_id');
		if ( $this->input->post('form_id') == 'edit_form' ) {
			$title = $this->input->post('title');
			$status = $this->input->post('status') == 'on' ? true : false;
			
			$save = $this->forms->edit($form,$status,$title);
			if ( $save ) {
				$this->session->set_flashdata('success','Form <strong>' . $title . '</strong> has been updated.');
			}
			else {
				$this->session->set_flashdata('error','Unable to update form.');
			}

			redirect('forms/' . $form);
		}

		if ($form) redirect('forms/' . $form);
		else redirect('forms');
	}


	function delete($id) {
		$data = $this->forms->data($id);
		if ( !$data ) {
			redirect('forms');
		}

		$query = $this->forms->delete($id);

		if ($query) {
			$this->session->set_flashdata('success','<strong>' . $data->title . '</strong> has been removed.');
		}
		else {
			$this->session->set_flashdata('error','Unable to remove ' . $data->title);
		}

		redirect('forms');
	}


	function add_category() {
		$form = $this->input->post('data_id');

		if ( $this->input->post('form_id') == 'new_category' ) {
			$category = trim($this->input->post('category'));

			if ( empty($category) ) {
				$this->session->set_flashdata('error','Category title must not be empty!');
				redirect('forms/' . $form);
			}
			
			$save = $this->forms->add_category($form, $category);
			if ( $save ) {
				$this->session->set_flashdata('success','New category has been added.');
			}
			else {
				$this->session->set_flashdata('error','Unable to save new category please try again.');
			}

			redirect('forms/' . $form);
		}

		if ( $form ) redirect('forms/' . $form);
		else redirect('forms');
	}

	function edit_category() {
		var_dump($this->input->post()); exit();
	}


	function delete_category() {
		$form = $this->input->post('data_id');

		if ( $this->input->post('form_id') == 'delete_category' ) {
			$category = $this->input->post('category_id');

			$save = $this->forms->delete_category($category);

			if ( $save ) {
				$this->session->set_flashdata('success','Category has been removed successfully.');
			}
			else {
				$this->session->set_flashdata('error','Unable to remove category.');
			}

			redirect('forms/' . $form);
		}

		if ( $form ) redirect('forms/' . $form);
		else redirect('forms');
	}


	function add_question($cat_id, $question) {

	}


	function update_questions() {
		// $url = $_SERVER["HTTP_REFERER"];
		
		if ( $this->input->post('form_id') == 'update_questions' ) {
			$title = trim($this->input->post('category'));
			$que = $this->input->post('que');
			$id = $this->input->post('cat_id');
			$form = $this->input->post('data_id');
			
			$save = $this->forms->update_questions($id, $title, $que);
			if ( $save ) {
				$this->session->set_flashdata('success','Categories and questions has been updated.');
			}
			else {
				$this->session->set_flashdata('error','An error has occured! Unable to update categories and question. Please try again.');
			}

			redirect('forms/' . $form);
		}

		// if ($url) redirect($url);
		// else 
			redirect('forms');
	}
}
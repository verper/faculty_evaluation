<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses extends CI_Controller {

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
		$this->load->model('programs_model', 'programs');
		$this->load->model('courses_model', 'courses');
		$this->load->model('user_model', 'user');
	}

	/**
	 * ADMIN CONTROLLER CLASS
	 * 
	 * Dashboard view
	 */
	function index() {
		if ( $this->input->post('form_id')=='new_course' ) {
			$code = strtoupper($this->input->post('code'));
			$title = strtoupper($this->input->post('title'));
			$faculty = $this->input->post('faculty');
			$program = $this->input->post('program');
			$save = $this->courses->add($code,$title, $faculty, $program);

			if ($save == true) {
				$this->session->set_flashdata('success', 'Course <strong>' . $code . '</strong> has been saved.');
			}
			else {
				$this->session->set_flashdata('error', 'Course code <strong>' . $code . '</strong> already exist.');
			}
			redirect('courses');
			exit();
		}
		elseif ( $this->input->post('form_id')=='edit_course' ) {
			$id = strtoupper($this->input->post('course_id'));
			$code = strtoupper($this->input->post('code'));
			$title = strtoupper($this->input->post('title'));
			$faculty = $this->input->post('faculty');
			$program = $this->input->post('program');
			$save = $this->courses->edit($id,$code,$title, $faculty, $program);

			if ($save == true) {
				$this->session->set_flashdata('success', 'Course <strong>' . $code . '</strong> has been saved.');
			}
			else {
				$this->session->set_flashdata('error', 'Course code <strong>' . $code . '</strong> already exist.');
			}
			redirect('courses');
			exit();
		}

		$this->data['title'] = 'Courses';
		$this->data['content'] = 'courses';
		$this->data['courses'] = $this->courses->get_list();
		$this->data['programs'] = $this->programs->get_list();
		$this->data['faculty'] = $this->user->get_list_by_role(2); // 2 = Faculty Role

		$this->load->view('page-user', $this->data);
	}

	function delete($slug) {
		$id = $slug;

		if ( !$this->courses->data($id) ) {
			$this->session->set_flashdata('error', 'Course code <strong>' . $id . '</strong> do not exist.');
		}
		else {
			$this->courses->delete_course($id);
			$this->session->set_flashdata('success', 'Course <strong>' . $id . '</strong> has been removed.');
		}

		redirect('courses');
	}


	function course_student_list($slug) {
		$code = $slug;
		
		// if ( $this->courses->code_exist($code) && $present == false  ) {
		// 	$this->session->set_flashdata('info', 'No students found for ' . $code);
		// }
		if ( !$this->courses->code_exist($code) ) {
			$this->session->set_flashdata('error', 'Course ' . $code . ' do not exist!');
			redirect('courses');
		}

		$present = $this->courses->get_course_students($code);
		
		$this->data['title'] = $code;
		$this->data['content'] = 'students';
		$this->data['course'] = $this->courses->data($code);
		$this->data['present'] = $present;
		$this->data['students'] = $this->user->get_list_by_role(1); // student role code
		$this->load->view('page-user', $this->data);
	}


	function add_student() {
		if ( $this->input->post('form_id') == 'add_student' ) {
			$course = $this->input->post('course_id');
			$student = $this->input->post('student_id');

			$save = $this->courses->add_student($course, $student);
			if ( $save ) {
				$user = $this->user->data($student);
				$this->session->set_flashdata('success', $user->lastname . ', ' . $user->firstname . ' ' . $user->middlename . ' has been added to the course.');
			}
			else {
				$this->session->set_flashdata('error','Unable to add student to the course.');
			}

			redirect('courses/' . $course);
		}
		redirect('courses');
	}

	function remove_student() {
		if ( $this->input->post('form_id') == 'remove_student' ) {
			$course = $this->input->post('course_id');
			$student = $this->input->post('student_id');
			$user = $this->user->data($student);
			$save = $this->courses->remove_student($course, $student);
			if ( $save ) {
				$this->session->set_flashdata('success', $user->lastname . ', ' . $user->firstname . ' ' . $user->middlename . ' has been removed from the course.');
			}
			else {
				$this->session->set_flashdata('error','Unable to remove student from the course.');
			}

			redirect('courses/' . $course);
		}
		redirect('courses');
	}
}
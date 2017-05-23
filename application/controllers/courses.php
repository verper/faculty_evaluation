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
			$code = str_replace(' ', '', $code);
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
			$code = str_replace(' ', '', $code);
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
		// $this->data['students'] = $this->user->get_list_by_role(1); // student role code
		$this->data['students'] = $this->courses->get_course_not_students($code); // student role code
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

	function bulk() {
		if ( $this->input->post('form_id') == 'bulk_users' ) {
			$course = $this->input->post('course_id');

            $config['upload_path']          = './media/files/';
            $config['allowed_types']        = 'csv';

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('bulk_add_file'))
            {
            	$msg = '';
                $error = array('error' => $this->upload->display_errors());
                foreach( $error as $e ) {
                	$msg .= $e;
                }
                $this->session->set_flashdata('error', $msg);

                redirect('courses/' . $course);
            }
            else
            {
            	$this->load->model('user_model','user');
            	$this->load->model('courses_model','courses');
            	$msg = '';

                $data = array('upload_data' => $this->upload->data());
                $full_path = $data["upload_data"]['full_path'];


		        $this->load->library('csvreader');
		        $result =   $this->csvreader->parse_file($full_path);//path to csv file
                foreach( $result as $count => $field ) {
                	$submitted_id = $field['id'];
                	$id = $field['id'] ? $field['id'] : uniqid();
                	$lastname = $field['lastname'] ? $field['lastname'] : '';
                	$firstname = $field['firstname'] ? $field['firstname'] : '';
                	$middlename = $field['middlename'] ? $field['middlename'] : '';
                	$role = '1';//student role code

                	$check_id = $this->user->check_userid($id);
                	if ( $check_id ) {
                		$student_on_course = $this->courses->course_student($course, $id);
                		if ( $student_on_course ) {
                			$msg .= '<br/><i class="glyphicon glyphicon-remove text-danger"></i> &nbsp;<strong>'.$id.' - '.$lastname.', '.$firstname.' '.$middlename.'</strong> is already on the course.';
                		}
                		else {
                			$save = $this->courses->add_student($course, $id);
                			$msg .= '<br/><i class="glyphicon glyphicon-ok text-success"></i> &nbsp;<strong>'.$id.' - '.$lastname.', '.$firstname.' '.$middlename.'</strong> has been added.';
                		}
                		$this->session->set_flashdata('info', $msg);
                		continue;
                	}

                	$id_exist = false;
                	while($check_id) {
                		$id_exist = true;
                		$id = uniqid();
                		$check_id = $this->user->check_userid($id);
                	}

                	if ( $id_exist ) {
                		$msg .= '<br/><i class="glyphicon glyphicon-ok text-success"></i> &nbsp;<strong>' . $submitted_id . '</strong> already exist <strong>'.$id.'</strong> has been used temporarily.';
                	}

                	$save = $this->user->add($id,$lastname,$firstname,$middlename,$role);

                	if ( $save ) {
                		$this->courses->add_student($course, $id);
                		$msg .= '<br/><i class="glyphicon glyphicon-ok text-success"></i> &nbsp;<strong>'.$id.' - '.$lastname.', '.$firstname.' '.$middlename.'</strong> has been added.';
                	}
                	else {
                		$msg .= '<br/><i class="glyphicon glyphicon-remove text-danger"></i> &nbsp;<strong>'.$id.' - '.$lastname.', '.$firstname.' '.$middlename.'</strong> has been failed.';
                	}

                	$this->session->set_flashdata('info', $msg);
                }

                unlink($full_path);
                redirect('courses/' . $course);
            }
		}

		redirect('courses/' . $course);
	}

	function bulk_course() {
		if ( $this->input->post('form_id') == 'bulk_course' ) {
			$course = $this->input->post('course_id');

            $config['upload_path']          = './media/files/';
            $config['allowed_types']        = 'csv';

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('bulk_add_file'))
            {
            	$msg = '';
                $error = array('error' => $this->upload->display_errors());
                foreach( $error as $e ) {
                	$msg .= $e;
                }
                $this->session->set_flashdata('error', $msg);

                redirect('courses');
            }
            else
            {
            	$this->load->model('user_model','user');
            	$this->load->model('courses_model','courses');
            	$msg = '';

                $data = array('upload_data' => $this->upload->data());
                $full_path = $data["upload_data"]['full_path'];


		        $this->load->library('csvreader');
		        $result =   $this->csvreader->parse_file($full_path);//path to csv file
		        
                foreach( $result as $count => $field ) {
                	if ( !isset($field["code"]) ) {
                		$this->session->set_flashdata('error', 'There was an error occured please try again.<br>Please try downloading and edit the sample csv file.');
                		unlink($full_path);
                		redirect('courses');
                	}

                	$id = strtoupper($field['code']);
                	$id = str_replace(' ', '', trim($id));
                	$title = strtoupper(trim($field['title']));
                	$f_ID = $field['faculty_ID'];
                	$lastname = $field['faculty_LASTNAME'];
                	$firstname = $field['faculty_FIRSTNAME'];
                	$middlename = $field['faculty_MIDDLENAME'];
                	$role = '2';
                	$program = strtoupper($field['program']);
                	$program = str_replace(' ', '', trim($program));

                	$check_code = $this->courses->code_exist($id);
                	if ( $check_code ) {
                		$msg .= '<i class="glyphicon glyphicon-remove text-danger"></i> &nbsp;Code <strong>'.$id.'</strong> already exist.';
            			continue;
                	}
                	if (empty($id)) {
                		$msg .= '<i class="glyphicon glyphicon-remove text-danger"></i> &nbsp;Code is required.';
            			continue;
                	}
                	if (empty($title)) {
                		$msg .= '<i class="glyphicon glyphicon-remove text-danger"></i> &nbsp;Code '.$id.' - Title is required.';
            			continue;
                	}
                	if (empty($program)) {
                		$msg .= '<i class="glyphicon glyphicon-remove text-danger"></i> &nbsp;Code '.$id.' - Program is required.';
            			continue;
                	}
                	$program_exist = $this->programs->code_exist($program);
                	if ( $program_exist == false ) {
                		$msg .= '<i class="glyphicon glyphicon-remove text-danger"></i> &nbsp;Code '.$id.' - Program<strong>'.$program.'</strong> did not exist in programs.';
            			continue;
                	}
                	if (empty($f_ID)) {
                		$msg .= '<i class="glyphicon glyphicon-remove text-danger"></i> &nbsp;Faculty ID is required.';
            			continue;
                	}
                	$fac_exists = $this->user->data($f_ID);
                	if ( $fac_exists ) {
                		if ( $fac_exists->role == '1' || $fac_exists->role == '5' ) {
                			$msg .= '<i class="glyphicon glyphicon-remove text-danger"></i> &nbsp;An error has occured in Code '.$id.'. Pleace check the entered fields then try again.';
                		}
                		else {
	                		$save_course = $this->courses->add($id,$title, $f_ID, $program);
	                		if ( $save_course ) {
	            				$msg .= '<i class="glyphicon glyphicon-ok text-success"></i> &nbsp;Code '.$id.' has been added successfully.';
	            			}
	            			else {
	            				$this->user->delete($f_ID);
	            				$msg .= '<i class="glyphicon glyphicon-remove text-danger"></i> &nbsp;Code '.$id.' has been failed.';
	            			}
                		}
                	}
                	else {
                		$save = $this->user->add($f_ID,$lastname,$firstname,$middlename,$role);
                		if ( $save ) {
                			$save_course = $this->courses->add($id,$title, $f_ID, $program);
                			if ( $save_course ) {
                				$msg .= '<i class="glyphicon glyphicon-ok text-success"></i> &nbsp;Code '.$id.' has been added successfully.';
                			}
                			else {
                				$this->user->delete($f_ID);
                				$msg .= '<i class="glyphicon glyphicon-remove text-danger"></i> &nbsp;Code '.$id.' has been failed.';
                			}
                		}
                	}
                }
                $this->session->set_flashdata('info', $msg);

                unlink($full_path);
                redirect('courses');
            }
		}

		redirect('courses');
	}
}
<?php

class Courses_model extends CI_Model {

  public function get_list() {
    // $this->db->select('*')->from('courses')->join('users', 'courses.assigned = users.id', 'inner');
    $this->db->select('c.*, p.college, u.*, c.id as id');
    $this->db->from('courses c');
    $this->db->join('programs p', 'c.program = p.id');
    $this->db->join('users u', 'u.id = c.assigned');


    if ( isset($_GET['q']) && $_GET['q'] != '' ) {
      $this->db->like('c.id', $_GET['q']);
      $this->db->or_like('c.title', $_GET['q']);
      $this->db->or_like('c.program', $_GET['q']);
      $this->db->or_like('u.lastname', $_GET['q']);
      $this->db->or_like('u.firstname', $_GET['q']);
      $this->db->or_like('u.middlename', $_GET['q']);
      $this->db->or_like('p.college', $_GET['q']);
    }

    $courses = $this->db->get()->result();
    
    return $courses;
  }

  public function data($id) {
    $course = $this->db->select('*')->from('courses')->where('id',$id)->get()->row();
    if (!$course) { return false; }

    $q = $this->db->select('id, lastname, firstname, middlename')->from('users')
                  ->where('id', $course->assigned)->get()->row();

    $course->faculty = $q ? $q : '';
    
    $college = $this->db->select('college')->from('programs')->where('id', $course->program)->get()->row();
    $course->college = $college ? $college->college : '';
    
    return $course;
  }

  public function add($code,$title, $faculty, $program) {
    if ( $this->code_exist($code) ) return false;
    
    $code = trim($code);
    $code = str_replace(' ','',$code);
    $data = array(
      'id' => $code,
      'title' => $title,
      'assigned' => $faculty,
      'program' => $program
    );

    $query = $this->db->insert('courses', $data);

    return $query ? true : false;
  }

  public function edit($id,$code,$title, $faculty, $program) {
    if ($id != $code && $this->code_exist($code)) return false;

    $code = trim($code);
    $code = str_replace(' ','',$code);
    $data = array(
        'id' => $code,
        'title' => $title,
        'assigned' => $faculty,
        'program' => $program
    );
    
    $query = $this->db->where('id', $id)->update('courses', $data);

    return $query ? true: false;
  }

  public function delete_course($id) {
    return $this->db->delete('courses', array('id' => $id));
  }

  function code_exist($code) {
    return $this->db->select('id')->from('courses')->where('id',$code)->get()->row() ? true : false;
  }

  function get_students($code) {
    $query = $this->db->select('*')
                      ->from('course_load')
                      ->where('course', $code)
                      ->get()->result();

    return $query ? $query : false;
  }

  function get_course_students($course) {
    $this->db->select('users.*, roles.title as rolename');
    $this->db->from('users');
    $this->db->join('roles', 'users.role = roles.id');
    $this->db->where('role','1');
    $this->db->order_by('users.lastname', 'ASC');
    
    if ( isset($_GET['p']) && $_GET['p'] ) {
        $this->db->like('users.id', $_GET['p']);
        $this->db->or_like('users.lastname', $_GET['p']);
        $this->db->or_like('users.firstname', $_GET['p']);
        $this->db->or_like('users.middlename', $_GET['p']);
        $this->db->or_like('roles.title', $_GET['p']);
    }

    $query = $this->db->get()->result();
    $count = 0;
    foreach( $query as $q ) {
      if ( $this->course_student($course, $q->id) == false) {
        unset($query[$count]);
      }
      $count++;
    }
    return $query;   
  }

  function get_course_not_students($course) {
    $this->db->select('users.*, roles.title as rolename');
    $this->db->from('users');
    $this->db->join('roles', 'users.role = roles.id');
    $this->db->where('role','1');
    $this->db->order_by('users.lastname', 'ASC');
    
    if ( isset($_GET['q']) && $_GET['q'] ) {
        $this->db->like('users.id', $_GET['q']);
        $this->db->or_like('users.lastname', $_GET['q']);
        $this->db->or_like('users.firstname', $_GET['q']);
        $this->db->or_like('users.middlename', $_GET['q']);
        $this->db->or_like('roles.title', $_GET['q']);
    }

    $query = $this->db->get()->result();
    $count = 0;
    foreach( $query as $q ) {
      if ( $this->course_student($course, $q->id) ) {
        unset($query[$count]);
      }
      $count++;
    }
    return $query;    
  }


  function add_student($course, $student) {
    $this->db->db_debug = FALSE;
    $query = $this->db->insert('course_load', array('course' => $course, 'student' => $student));
    return $query ? true : false;
  }

  function remove_student($course, $student) {
    $this->db->db_debug = FALSE;
    $query = $this->db->delete('course_load', array('course' => $course, 'student' => $student));
    return $query ? true : false;
  }


  function get_courses($student) {
    $this->db->db_debug = FALSE;
    $query = $this->db->select('*')->from('course_load')->where('student', $student)->get()->result();
    return $query;
  }

  function check_student_course($faculty, $student) {
    $query = $this->db->select('course')->from('course_load')->where('student', $student)->get()->result();

    if ( $query ) {
      foreach( $query as $q ) {
        $query2 = $this->db->select('id')->from('courses')->where('id',$q->course)->where('assigned', $faculty)->get()->row();
        if ( $query2 ) 
          return true;
      }
    }

    return false;
  }

  function student_course($faculty, $student) {
    $return = new stdClass();
    $query = $this->db->select('*')->from('course_load')->where('student', $student)->get()->result();

    if ( $query ) {
      foreach( $query as $q ) {
        $query2 = $this->db->select('*')->from('courses')->where('id',$q->course)->where('assigned', $faculty)->get()->row();
        if ( $query2 ) {
          $return = $query2;
        }
      }

      return $return;
    }

    return false;
  }

  function course_student($course, $student) {
    $this->db->select('*');
    $this->db->from('course_load');
    $this->db->where('course', $course);
    $this->db->where('student', $student);

    $query = $this->db->get()->row();
    return $query ? true : false;
  }

  function courses_handled ($faculty) {
    $this->db->select('id');
    $this->db->from('courses');
    $this->db->where('assigned', $faculty);
    return $this->db->get()->result();
  }
}
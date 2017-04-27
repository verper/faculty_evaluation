<?php

class Evaluation_model extends CI_Model {

    function peer_list() {
        $this->db->select('*');
        $this->db->from('peer_peer');
        $this->db->order_by('date', 'DESC');

        $query = $this->db->get()->result();

        if ( $query ) {
            foreach($query as $q) {
                $user = $this->db->select('id,lastname,firstname,middlename')->from('users')->where('id', $q->source)->get()->row();
                $q->source = $user;

                $user = $this->db->select('id,lastname,firstname,middlename')->from('users')->where('id', $q->target)->get()->row();
                $q->target = $user;
            }
        }

        return $query;
    }

    function peer_schedule($date,$evaluator,$subject) {
        $data = array(
            'source' => $evaluator,
            'target' => $subject,
            'date' => $date
        );

        $query = $this->db->insert('peer_peer', $data);

        return $query ? true : false;
    }

    function get_faculty_list($id) {
        $user = $this->db->select('*')->from('users')->where('id',$id)->get()->row();

        // peer to peer 
        if ( $user->role == '2' ) {
            $query = $this->db->select('*')->from('peer_peer')->where('source', $id)->get()->result();

            if ( $query ) {
                foreach( $query as $q ) {
                    $q2 = $this->db->select('*')->from('users')->where('id', $q->target)->get()->row();
                    $q->target = $q2 ? $q2:'';
                }
            }
            return $query ? $query : false;            
        }
        // program head
        elseif ( $user->role == '3' ) {
            $program = $this->db->select('*')->from('programs')->where('supervisor',$user->id)->get()->row();
            $program->courses = $this->db->select('*')->from('courses')->where('program', $program->id)->get()->result();
            if ( $program->courses ) {
                foreach( $program->courses as $course ) {
                    $q = $this->db->select('*')->from('users')->where('id', $course->assigned)->get()->row();
                    $course->assigned = $q ? $q:'';
                }
            }
            return $program ? $program : false;
        }
        // college dean
        elseif ( $user->role == '4' ) {
            $this->load->model('user_model');

            $college = $this->db->select('*')->from('colleges')->where('dean',$user->id)->get()->row();
            $college->programs = $this->db->select('*')->from('programs')->where('college', $college->id)->get()->result();
            $programs = array();
            if ( $college->programs ) {
                foreach( $college->programs as $prog ) {
                    $q = $this->user_model->data($prog->supervisor);
                    $prog->supervisor = $q ? $q:'';
                    $programs[] = $prog->id;
                }
            }
            if ( count($programs) != 0 ) {
                $college->teachers = array();
                foreach( $programs as $pid ) {
                    $query = $this->db->select('*')->from('courses')->where('program', $pid)->get()->result();
                    if ( $query ) {
                        foreach( $query as $q ) {
                            $q2 = $this->user_model->data($q->assigned);
                            $q->supervisor = $q2 ? $q2 : '';
                            $college->programs[] = $q;
                        }
                    }
                }
            }
            return $college ? $college : false;
        }
    }

    function update_schedule($id, $date, $evaluator, $subject, $status) {
        $data = array(
            'source' => $evaluator,
            'target' => $subject,
            'date' => $date,
            'status' => $status
        );

        $query = $this->db->where('id',$id)->update('peer_peer', $data);
        
        return $query ? true : false;
    }


    function process_evaluation($evaluator, $faculty, $ratings, $form_used, $comments) {
        $data = array(
            'evaluator' => $evaluator,
            'subject' => $faculty,
            'data' => json_encode($ratings),
            'form' => json_encode($form_used),
            'comments' => $comments
        );
        
        // $this->db->db_debug = FALSE;
        $query = $this->db->insert('ratings', $data);

        return $query ? true : false;
    }

    /*
     * @ return 
     *      true = has access
     *      false = no access
    */
    function evaluation_access($evaluator, $faculty) {
        // $this->db->db_debug = FALSE;
        $query = $this->db->select('id')->from('ratings')->where('evaluator', $evaluator)->where('subject', $faculty)->get()->row();
        return $query ? false : true;
    }


    /*
     * @ return 
     *      true = has access
     *      false = no access
    */
    function has_connection($evaluator, $faculty) {
        $this->load->model('courses_model', 'courses');
        $this->load->model('programs_model', 'programs');
        $this->load->model('user_model', 'user');

        $user = $this->user->data($evaluator);

        if ( $user->role == '1' ) {
            if ( $this->courses->check_student_course($faculty, $evaluator)) {
                return true;
            }
            return false;
        }
        elseif ( $user->role == '2' ) {
            $query = $this->db->select('*')->from('peer_peer')->where('source',$evaluator)->where('target', $faculty)->get()->row();
            if ( $query ) {
                $schedule = date('M d, Y', strtotime($query->date));
                $today = date('M d, Y');
                return $schedule == $today ? true : false;
            }
            return false; 
        }
        elseif ( $user->role == '3' ) {
            $query = $this->db->select('*')->from('programs')->where('supervisor', $evaluator)->get()->row();
            if ( $query ) {
                $fc = $this->db->select('assigned')->from('courses')->where('program', $query->id)->where('assigned', $faculty)->get()->row();
                return $fc ? true : false;
            }
            return false;
        }
        elseif ( $user->role == '4' ) {
            $return = false;
            $in_program = false;

            $college = $this->db->select('*')->from('colleges')->where('dean',$evaluator)->get()->row();
            if ( $college ) {
                $query = $this->db->select('id')->from('programs')->where('supervisor',$faculty)->where('college', $college->id)->get()->row();
                if ( $query ) {
                    return true;
                }
            }
            
            if ( $in_program == false ) {
                $this->db->select('p.id as pid, p.supervisor, c.id as cid, c.assigned');
                $this->db->from('programs p');
                $this->db->from('courses c');
                $this->db->where('p.college', $college->id);
                $this->db->where('c.program = p.id');
                $this->db->where('c.assigned', $faculty);
                $query = $this->db->get()->result();
                return $query ? true : false;
            }
        }
    }


    function validate_evaluation($evaluator, $faculty) {
        $faculty_data = $this->user->data($faculty);
        if ( !$faculty_data 
            || $evaluator == $faculty_data->id 
            || $this->evaluation_access($evaluator, $faculty_data->id) == false 
            || $this->has_connection($evaluator, $faculty_data->id) == false ) 
            { return false; }

        return true;
    }

    function evaluated_form() {
        
    }


    function question_total($form_id, $question, $faculty, $evaluator ='') {
        $this->db->select('*');
        $this->db->from('ratings');
        $this->db->where('subject', $faculty);
        if ($evaluator != '' ) {
            $this->db->where('evaluator', $evaluator);
        }
        $query = $this->db->get()->result();

        if ( $query ) {
            $total = 0;
            $divisor = 0;
            foreach( $query as $ratings ) {
                $data = json_decode($ratings->data);
                $form = json_decode($ratings->form);
                if( $form->form->id == $form_id ) {
                    $total += $data->$question;
                    $divisor++;
                }
            }
            $overall = $divisor == 0 ? 0 :$total/$divisor;
            return is_float($overall) ? number_format($overall,2) + 0 : $overall;
        }

        return 0;
    }

    function category_total($form_id, $category, $faculty, $evaluator='') {
        $this->db->select('id');
        $this->db->from('questions');
        $this->db->where('category', $category);
        $questions = $this->db->get()->result();

        if ( $questions ) {
            $total = 0;
            foreach( $questions as $que ) {
                $total += $this->question_total($form_id, $que->id, $faculty, $evaluator);
            }
            $overall = $total/count($questions);
            return is_float($overall) ? number_format($overall,2) + 0 : $overall;
        }

        return 0;
    }

    function general_average($form_id, $faculty, $evaluator='') {
        $this->db->select('id');
        $this->db->from('categories');
        $this->db->where('form', $form_id);
        $query = $this->db->get()->result();

        if ( $query ) {
            $total = 0;
            foreach( $query as $q ) {
                $total += $this->category_total($form_id, $q->id, $faculty, $evaluator='');
            }
            $overall = $total/count($query);
            return is_float($overall) ? number_format($overall,2) : $overall;
        }
        return 0;
    }

    function get_comments($faculty, $evaluator='') {
        $this->db->select('comments');
        $this->db->from('ratings');
        $this->db->where('subject', $faculty);
        if( $evaluator != '' ) {
            $this->db->where('evaluator', $evaluator);
        }

        return $this->db->get()->result();
    }
}
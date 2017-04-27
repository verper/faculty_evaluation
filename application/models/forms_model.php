<?php

class Forms_model extends CI_Model {

    function get_list() {
        return $this->db->from('forms')->order_by('title')->get()->result();
    }
    
    function data($id) {
        $query = $this->db->select('*')->from('forms')->where('id', $id)->get()->row();

        return $query ? $query : false;
    }

    function add($title) {
        $data = array(
            'title' => $title
        );

        $query = $this->db->insert('forms', $data);

        return $query ? true : false;
    }

    function edit($id,$status,$title) {
        $data = array(
            'title' => $title,
            'status' => $status
        );
        
        $query = $this->db->where('id', $id)->update('forms', $data);

        return $query ? true: false;
    }

    function delete($id) {
        return $this->db->delete('forms', array('id' => $id)) ? true : false;
    }

    
    function get_categories($form_id) {
        $query = $this->db->select('*')
                        ->from('categories')
                        ->where('form', $form_id)
                        ->get()->result();

        if ($query) {
            foreach($query as $q) {
                $q->questions = $this->get_questions($q->id);
            }
        }

        return $query;
    }


    function get_questions($category) {
        $query = $this->db->select('*')
                        ->from('questions')
                        ->where('category', $category)
                        ->get()->result();

        return $query;
    }


    function add_category($form_id, $category) {
        $data = array(
                'title' => $category,
                'form' => $form_id,
            );

        $query = $this->db->insert('categories', $data);

        return $query ? true : false;
    }


    function delete_category($id) {
        $query = $this->db->query("DELETE FROM categories where id=$id");
        return $query ? true : false;
    }


    function update_questions($cat_id, $category, $questions) {
        $flag = array();
        $query = $this->db->where('id', $cat_id)->update('categories', array('title' => $category));
        $count = 0;
        if ( $questions['new'] ) {
            $new = $questions['new'];
            foreach( $new as $value ) {
                if ( trim($value) != ''  ) {
                    $query = $this->db->insert('questions', array('title' => $value, 'category' => $cat_id));
                }
            }
        }
        
        if ( !empty($questions) ) {
            foreach( $questions as $key => $value ) {
                if ( $key != 'new' ) {
                    if ( trim($value) == '' ) {
                        $query = $this->db->delete('questions', array('id' => $key));
                    }
                    else {
                        $query = $this->db->where('id', $key)->update('questions', array('title' => $value));
                    }                    
                }
            }
        }
        
        return true;
    }


    function form_usage_by_role($form) {
        if ( empty($form) ) { return false; }

        $update = false;
        foreach( $form as $key => $value ) {
            $check = $this->db->select('role')->from('role_form')->where('role',$key)->get()->row();
            
            if ( $check ) {
                $update = $this->db->where('role', $key)->update('role_form', array('form' => $value));    
            }
            else {
                $update = $this->db->insert('role_form', array('role' => $key, 'form' => $value));
            }
        }

        return $update ? true : false;
    }

    function get_role_form() {
        $return = array();
        $query = $this->db->select('*')->from('role_form')->get()->result();

        if ( $query ) {
            foreach ($query as $q) {
                $return[$q->role] = $q->form;
            }
        }
        
        return $query ? $return : false;
    }


    function get_user_form($role) {
        $return = new stdClass();
        $query = $this->db->select('form')->from('role_form')->where('role', $role)->get()->row();
        if ( $query ) {
            $return->form = $this->data($query->form);
            $return->categories = $this->get_categories($query->form);

            return $return;
        }

        return false;
    }


    //end of Class
}
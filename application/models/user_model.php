<?php

class User_model extends CI_Model {

    function get_list() {
        $this->db->select('users.*, roles.title as rolename');
        $this->db->from('users');
        $this->db->join('roles', 'users.role = roles.id');
        $this->db->order_by('users.lastname', 'ASC');
        
        if ( isset($_GET['q']) && $_GET['q'] ) {
            $this->db->like('users.id', $_GET['q']);
            $this->db->or_like('users.lastname', $_GET['q']);
            $this->db->or_like('users.firstname', $_GET['q']);
            $this->db->or_like('users.middlename', $_GET['q']);
            $this->db->or_like('roles.title', $_GET['q']);
        }

        $query = $this->db->get()->result();

        $logged_in = $this->session->userdata('logged_in');
        if ( $logged_in->role == '2' || $logged_in->role == '3' ) {
            $count = 0;
            foreach ( $query as $q ) {
                if ( $q->role != '1' ) {
                    unset($query[$count]);
                }
                $count++;
            }
            return $query;
        }
        return $query;
    }
    
    function data($id) {
        $this->db->select('users.*, roles.title as rolename');
        $this->db->from('users');
        $this->db->join('roles', 'users.role = roles.id');
        $this->db->where('users.id', $id);
        $query = $this->db->get()->row();

        return $query;
    }

    function add($id,$lastname,$firstname,$middlename,$role) {
        if ( $this->check_userid($id) ) {
            return false;
        }

        $id = trim($id);
        $id = str_replace(' ', '', $id);

        $data = array(
            'id' => $id,
            'password' => md5($id),
            'lastname' => $lastname,
            'firstname' => $firstname,
            'middlename' => $middlename,
            'role' => $role,
        );

        $query = $this->db->insert('users', $data);

        return $query ? true : false;
    }

    function edit($id,$new_id,$lastname,$firstname,$middlename,$role,$photo) {
        if ( $id != $new_id && $this->check_userid($new_id) ) {
            return false;
        }

        $new_id = trim($new_id);
        $new_id = str_replace(' ', '', $new_id);

        $data = array(
            'id' => $new_id,
            // 'password' => md5($id),
            'lastname' => $lastname,
            'firstname' => $firstname,
            'middlename' => $middlename,
            'role' => $role
        );

        if ( $photo ) $data['photo'] = $photo;
        
        $query = $this->db->where('id', $id)->update('users', $data);

        return $query ? true : false;
    }

    function delete($id) {
        return $this->db->delete('users', array('id' => $id)) ? true : false;
    }

    function reset() {}

    function get_roles() {
        $query = $this->db
        ->from('roles')
        ->order_by('title')
        ->get()
        ->result();

        return $query;
    }

    function rolename($id) {
        $query = $this->db->select('title')
        ->from('roles')
        ->where('id', $id)
        ->result();

        return $query;
    }

    function get_list_by_role($id) {
        $this->db->select('users.*, roles.title as rolename');
        $this->db->from('users');
        $this->db->join('roles', 'users.role = roles.id');
        $this->db->where('users.role', $id);
        $this->db->order_by('users.lastname', 'ASC');
        $query = $this->db->get()->result();

        return $query;
    }

    function check_userid($id) {
        $this->db->select('id')
                ->from('users')
                ->where('id', $id);

        return (null !== $this->db->get()->row()) ? true : false;
    }


    function reset_password($id) {
        $this->db->db_debug = FALSE;
        $data = array(
            'password' => md5($id)
        );
        $query = $this->db->where('id', $id)->update('users', $data);
        return $query ? true : false;
    }

    function change_password($id, $password) {
        $data = array(
            'password' => md5($password)
        );
        $query = $this->db->where('id', $id)->update('users', $data);
        return $query ? true : false;
    }


    function get_list_by_college($dean) {
        $data = $this->data($dean);
        $facs = array();

        $logged_in = $this->session->userdata('logged_in');
        if ( $logged_in->role == 5 ) {
            $list = $this->db->select('id')->from('users')->where('role = 2')->order_by('role','DESC')->get()->result();
            foreach( $list as $l ) {
                $facs[] = $this->data($l->id);
            }
        }
        else {
            $dean = $this->db->select('id')->from('colleges')->where('dean', $dean)->get()->row();
            if ( $dean ) {
                $ph = $this->db->select('*')->from('programs')->where('college', $dean->id)->get()->result();
                foreach( $ph as $p ) {
                    // $facs[] = $this->data($p->supervisor);

                    $teach = $this->db->select('assigned')->from('courses')->where('program', $p->id)->where('assigned !=', $p->supervisor)->get()->result();
                    if ( $teach ) {
                        foreach ($teach as $t) {
                            $facs[] = $this->data($t->assigned);
                        }
                    }
                }
            }
        }

        return $facs;
    }
}
<?php

class Colleges_Model extends CI_Model {

    function get_list() {
        $this->db->select('colleges.*, users.id as userid, users.lastname, users.firstname, users.middlename');
        $this->db->from('colleges');
        $this->db->join('users', 'colleges.dean = users.id', 'left');
        $this->db->order_by('id', 'ASC');

        if ( isset($_GET['q']) && $_GET['q'] != '' ) {
            $this->db->like('colleges.id', $_GET['q']);
            $this->db->or_like('title', $_GET['q']);
            $this->db->or_like('dean', $_GET['q']);
            $this->db->or_like('lastname', $_GET['q']);
            $this->db->or_like('firstname', $_GET['q']);
            $this->db->or_like('middlename', $_GET['q']);
        }

        $query = $this->db->get()->result();
        return $query;
    }

    function data($id) {
        $this->db->select('colleges.*, users.lastname, users.firstname, users.middlename');
        $this->db->from('colleges');
        $this->db->join('users', 'colleges.dean = users.id');
        $this->db->where('colleges.id', $id);
        $query = $this->db->get()->row();

        return $query;
    }

    function add($code,$title,$dean) {
        if ($this->code_exist($code)) return false;

        $data = array(
            'id' => $code,
            'title' => $title,
            'dean' => $dean
        );

        $this->db->db_debug = FALSE;
        $query = $this->db->insert('colleges', $data);
        
        return $query ? true : false;
    }

    function edit($id,$new_id,$title,$dean) {
        if ( $id != $new_id && $this->code_exist($new_id) ) return false;
        
        $data = array(
            'id' => $new_id,
            'title' => $title,
            'dean' => $dean
        );
        
        $query = $this->db->where('id', $id)->update('colleges', $data);

        return $query ? true: false;
    }

    function delete($id) {
        return $this->db->delete('colleges', array('id' => $id)) ? true : false;
    }

    function reset() {}

    function code_exist($code) {
        return $this->db->select('id')->from('colleges')->where('id',$code)->get()->row();
    }
}
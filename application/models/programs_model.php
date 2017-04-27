<?php

class Programs_model extends CI_Model {

    function get_list() {
        $this->db->select('programs.*, users.lastname, users.firstname, users.middlename')
                ->from('programs')
                ->join('users', 'programs.supervisor = users.id', 'left')
                ->order_by('programs.title', 'ASC');
                            
        if ( isset($_GET['q']) && $_GET['q'] != '' ) {
            $this->db->like('programs.id', $_GET['q']);
            $this->db->or_like('title', $_GET['q']);
            $this->db->or_like('college', $_GET['q']);
            $this->db->or_like('lastname', $_GET['q']);
            $this->db->or_like('firstname', $_GET['q']);
            $this->db->or_like('middlename', $_GET['q']);
        }

        $results = $this->db->get()->result();
        foreach( $results as $result ) {
            $college = $this->db->select('*')->from('colleges')->where('id', $result->college)->get()->row();
            $result->college = $college ? $college:'';
        }

        return $results ? $results : false;
    }

    function data($id) {
        $this->db->select('programs.*, users.lastname, users.firstname, users.middlename');
        $this->db->from('programs');
        $this->db->join('users', 'programs.supervisor = users.id');
        $this->db->where('programs.id', $id);
        $query = $this->db->get()->row();

        return $query ? $query : false;
    }

    function add($code,$title,$supervisor,$college) {
        if ( $this->code_exist($code) ) return false;

        $data = array(
            'id' => $code,
            'title' => $title,
            'supervisor' => $supervisor,
            'college' => $college
        );

        $query = $this->db->insert('programs', $data);

        return $query ? true : false;
    }

    function edit($id,$new_id,$title,$supervisor,$college) {
        if ($id != $new_id && $this->code_exist($new_id)) return false;

        $data = array(
            'id' => $new_id,
            'title' => $title,
            'supervisor' => $supervisor,
            'college' => $college
        );
        
        $query = $this->db->where('id', $id)->update('programs', $data);

        return $query ? true: false;
    }

    function delete($id) {
        return $this->db->delete('programs', array('id' => $id)) ? true : false;
    }

    function reset() {}

    function code_exist($code) {
        return $this->db->select('id')->from('programs')->where('id',$code)->get()->row() ? true : false;
    }
}
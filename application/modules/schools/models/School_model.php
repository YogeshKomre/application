<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class School_model extends MX_Model {
    public function __construct() {
        parent::__construct();
        $this->table = 'schools';
    }

    public function get_schools($search = '', $limit = 10, $offset = 0) {
        $this->db->select('*');
        if (!empty($search)) {
            $this->db->like('school_name', $search);
            $this->db->or_like('contact_person', $search);
            $this->db->or_like('email', $search);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('created_at', 'desc');
        return $this->db->get($this->table)->result();
    }

    public function count_schools($search = '') {
        if (!empty($search)) {
            $this->db->like('school_name', $search);
            $this->db->or_like('contact_person', $search);
            $this->db->or_like('email', $search);
        }
        return $this->db->count_all_results($this->table);
    }

    public function get_school($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function add_school($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update_school($id, $data) {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete_school($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}

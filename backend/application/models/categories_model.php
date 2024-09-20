<?php

class categories_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', true);
	}

	public function get_category_id_by_name($name) {
		$this->db->select('id');
		$this->db->from('categories');
		$this->db->where('name', $name);
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->id;
		} else {
			return false;
		}
	}

}

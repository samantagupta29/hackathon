<?php

class ingredients_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', true);
	}

	public function get_all_ingredients() {
		$this->db->select('name');
		$query = $this->db->get('ingredients');
		if ($query->num_rows() > 0) {
			$ingredients =  $query->result_array();
			return array_column($ingredients, 'name');
		} else {
			return [];
		}
	}

	public function get_or_create($name) {
		$this->db->where('name', $name);
		$query = $this->db->get('ingredients', 1);

		if ($query->num_rows() > 0) {
			return $query->row()->id;
		} else {
			$data = array(
				'name' => $name,
			);
			if ($this->db->insert('ingredients', $data)) {
				return $this->db->insert_id();
			} else {
				return false;
			}
		}
	}
}

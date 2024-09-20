<?php

class user_dietary_restrictions_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', true);
	}

	public function get_existing_restrictions($user_id) {
		$this->db->select('ingredient_id');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user_dietary_restrictions');
		return $query->result_array();
	}

	public function get_user_dietary_restrictions($user_id) {
		$this->db->select('i.name');
		$this->db->from('user_dietary_restrictions u');
		$this->db->join('ingredients i', 'i.id = u.ingredient_id', 'inner');
		$this->db->where('u.user_id', $user_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$ingredients = $query->result_array();
			$ingredients = array_column($ingredients, 'name');
			return implode(', ', $ingredients);
		} else {
			return '';
		}
	}

	public function delete_user_dietary_restrictions($user_id) {
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_dietary_restrictions');
	}

	public function insert_dietary_restrictions($ingredient_id, $user_id) {
		$data = array(
			'ingredient_id' => $ingredient_id,
			'user_id' => $user_id,
		);

		$this->db->insert('user_dietary_restrictions', $data);
	}

}

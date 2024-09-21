<?php

class user_preferences_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', true);
	}

	public function get_user_preferences($user_id) {
		$this->db->select('c.name as meat, c.name as category, c.id as category_id, sc.type as subcategory, sc.id as sub_category_id, sc.type, u.carbs, u.proteins, u.fats, u.cooking_time, u.cuisine, u.spice_tolerance, u.cooking_style');
		$this->db->from('user_preference u');
		$this->db->join('categories c', 'c.id = u.category_id', 'left');
		$this->db->join('sub_categories sc', 'sc.id = u.subcategory_id', 'left');
		$this->db->where('u.user_id', $user_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array()[0] ?? [];
		} else {
			return [];
		}
	}
	public function insert_update_user_preference($data, $user_id) {
		$query = $this->db->get('user_preference');
		if ($query->num_rows() > 0) {
			$this->db->set('category_id', $data['category']);
			$this->db->set('subcategory_id', $data['subcategory']);
			$this->db->set('cuisine', $data['cuisine']);
			$this->db->set('spice_tolerance', $data['spice_tolerance']);
			$this->db->set('cooking_style', $data['cooking_style']);
			$this->db->set('cooking_time', $data['cooking_time']);
			$this->db->set('carbs', $data['carbs']);
			$this->db->set('proteins', $data['proteins']);
			$this->db->set('fats', $data['fats']);
			$this->db->where('user_id', $user_id);
			return $this->db->update('user_preference');
		} else {
			$data = array(
				'user_id' => $user_id,
				'category_id' => $data['category'],
				'subcategory_id' => $data['subcategory'],
				'cuisine' => $data['cuisine'],
				'spice_tolerance' => $data['spice_tolerance'],
				'cooking_style' => $data['cooking_style'],
				'cooking_time' => $data['cooking_time'],
				'carbs' => $data['carbs'],
                'proteins' => $data['proteins'],
                'fats' => $data['fats'],
			);
			return $this->db->insert('user_preference', $data);
		}
	}

}

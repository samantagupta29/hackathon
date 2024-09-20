<?php

class saved_recipes_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', true);
	}



	public function recipe_exists($user_id, $recipe_id) {
		$this->db->where('user_id', $user_id);
		$this->db->where('recipe_id', $recipe_id);
		$query = $this->db->get('saved_recipes');

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function insert_saved_recipe($data) {
		$this->db->insert('saved_recipes', $data);
	}

	public function get_saved_recipes($user_id) {
		$this->db->select('s.id as recipe_id, s.title, s.image as image_url, s.carbs, s.proteins, s.fats, s.food_taste as taste, s.instructions, s.cuisine, s.cooking_style, s.spice, s.cooking_time');
		$this->db->from('saved_recipes r');
		$this->db->join('recipes s', 's.id = r.recipe_id', 'inner');
		$this->db->where('r.user_id', $user_id);
		$query = $this->db->get();

		return $query->result_array() ?? [];
	}

}

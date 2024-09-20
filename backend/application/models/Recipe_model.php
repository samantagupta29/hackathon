<?php
class recipe_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', true);
	}

	public function add_recipe($data) {
		$this->db->where('title', $data['title']);
		$this->db->where('category_id', $data['category']);
		$this->db->where('sub_category_id', $data['subcategory']);
		$this->db->where('instructions', $data['instructions']);
		$query = $this->db->get('recipes', 1);
		$data = array(
			'category_id' => $data['category'],
			'sub_category_id' => $data['subcategory'],
			'title' => $data['title'],
			'image' => $data['image_url'],
			'carbs' => $data['carbs'],
			'proteins' => $data['proteins'],
			'fats' => $data['fats'],
			'instructions' => $data['instructions'],
			'food_taste' => $data['taste'],
			'food_texture' => $data['texture'],
			'cuisine' => $data['cuisine'],
			'location' => $data['location'],
			'spice' => $data['spice'],
			'cooking_style' => $data['cooking_style'],
			'cooking_time' => $data['cooking_time'],
		);

		if ($query->num_rows() == 0) {
			$this->db->insert('recipes', $data);
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

}

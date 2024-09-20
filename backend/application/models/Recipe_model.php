<?php
class recipe_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', true);
	}

	public function get_recipe($recipe_id) {
		$this->db->select('r.title, r.image, r.carbs, r.proteins, r.fats, r.instructions, r.cuisine, r.cooking_style, r.spice, r.cooking_time, s.name as stock_item, s.description as stock_item_description');
		$this->db->from('recipes r');
		$this->db->join('stock s', 's.category_id = r.category_id AND s.sub_category_id = r.sub_category_id AND s.is_available = 1', 'left');
		$this->db->where('r.id', $recipe_id);

		$query = $this->db->get();
		return $query->result_array()[0] ?? [];
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
			'ingredients' => $data['ingredients'],
		);

		if ($query->num_rows() === 0) {
			$this->db->insert('recipes', $data);
			return [$this->db->insert_id(), true];
		} else {
			return [$query->row()->id, false];
		}
	}

}

<?php

class recipe_ingredients_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', true);
	}
	public function insert($ingredient_id, $user_id) {
		$data = array(
			'recipe_id' => $ingredient_id,
			'ingredient_id' => $user_id,
		);

		return $this->db->insert('recipe_ingredients', $data);
	}
}

?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recipe extends MY_Controller {

	public function get_recipe($recipe_id): void {
		$this->load->helper('recipes');
		$data['recipe'] = fetch_recipe($this, $recipe_id);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data);

	}
}

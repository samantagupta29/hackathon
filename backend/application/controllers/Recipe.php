<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recipe extends MY_Controller {

	public function get_recipe($recipe_id): void {
		$this->load->helper('recipes');
		$data['recipe'] = fetch_recipe($this, $recipe_id);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data);

	}

	public function get_recipes(): void {
		$this->load->helper('recipes');
		$data['recipes'] = fetch_recipes($this);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data);
	}

	public function save_recipe(): void {
		$this->load->helper('recipes');
        $recipe = $this->input->post('recipe') ?? 1;
        $data['status'] = save_recipe($this, $recipe);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
	}

	public function saved_recipes(): void {
		$this->load->helper('recipes');
		$data['recipes'] = fetch_saved_recipes($this);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data);
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_preferences extends MY_Controller {

	public function get_filters(): void {
		$this->load->helper('user_preferences');
		$data = get_filters($this);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data);
	}

	public function apply_filters_and_get_recipes(): void {
		$this->load->helper('user_preferences');
		$this->load->helper('recipes');
//		$data['applied_filters'] = apply_filters($this);
		$data = fetch_recipes($this);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data);
	}
}

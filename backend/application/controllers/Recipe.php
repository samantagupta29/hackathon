<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recipe extends CI_Controller {

	public function get_top_recipes(): void {
		$data = new stdClass();
		$data->topRecipes = [
			[
				'id' => 1,
				'name' => 'Butter Chicken',
				'nutrients' => [
					'carbs' => '50g',
					'fats' => '40g',
					'proteins' => '30g'
				],
				'servings' => '2-3',
				'time' => '2 hrs',
				'ingredients' => '1,2,3,4',
				'image' => 'https:xyz.com'
			],
			[
				'id' => 2,
				'name' => 'Chicken Keema',
				'nutrients' => [
					'carbs' => '50g',
					'fats' => '40g',
					'proteins' => '30g'
				],
				'servings' => '2-3',
				'time' => '2 hrs',
				'ingredients' => '1,2,3,4',
				'image' => 'https:xyz.com'
			],
			[
				'id' => 3,
				'name' => 'Butter Chicken',
				'nutrients' => [
					'carbs' => '50g',
					'fats' => '40g',
					'proteins' => '30g'
				],
				'servings' => '2-3',
				'time' => '2 hrs',
				'ingredients' => '1,2,3,4',
				'image' => 'https:xyz.com'
			],
			[
				'id' => 4,
				'name' => 'Butter Chicken 3',
				'nutrients' => [
					'carbs' => '50g',
					'fats' => '40g',
					'proteins' => '30g'
				],
				'servings' => '2-3',
				'time' => '2 hrs',
				'ingredients' => '1,2,3,4',
				'image' => 'https:xyz.com'
			],
			[
				'id' => 5,
				'name' => 'Butter Chicken 5',
				'nutrients' => [
					'carbs' => '50g',
					'fats' => '40g',
					'proteins' => '30g'
				],
				'servings' => '2-3',
				'time' => '2 hrs',
				'ingredients' => '1,2,3,4',
				'image' => 'https:xyz.com'
			]
		];
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data);
	}
}

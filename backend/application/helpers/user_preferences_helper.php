<?php

function get_filters($ci): array {
	$data = [];
	$ci->load->model('ingredients_model');
	$data['applied_filters'] = get_user_applied_filters($ci);
	return $data;
}

function get_user_applied_filters($ci): array {
	$ci->load->model('user_preferences_model');
	$ci->load->model('user_dietary_restrictions_model');
	$user_preference = $ci->user_preferences_model->get_user_preferences($ci->user_id);
	if (!$user_preference) {
		return [];
	}
	$user_preference['dietary_restrictions'] = $ci->user_dietary_restrictions_model->get_user_dietary_restrictions($ci->user_id);
	return $user_preference;
}
function apply_filters($ci): array {
	$ci->load->model('user_preferences_model');
	$input_data = set_data($ci);
	$ci->user_preferences_model->insert_update_user_preference($input_data, $ci->user_id);
	return $ci->user_preferences_model->get_user_preferences($ci->user_id);
}
function set_data($ci) {
	$post_input = file_get_contents("php://input");
	$post_input = json_decode($post_input, true);
	$cuisine = $post_input['cuisine'] ?? null;
	$spice_tolerance = $post_input['spice_tolerance'] ?? null;
	$dietary_restrictions = $post_input['dietary_restricts'] ?? null;
	$cooking_style = $post_input['cooking_style'] ?? null;
	$cooking_time = $post_input['cooking_time'] ?? null;
	$category = $post_input['category'] ?? 'Fish';
	$subcategory = $post_input['subcategory'] ?? null;
	$carbs = $post_input['carbs'] ?? null;
	$proteins = $post_input['proteins'] ?? null;
	$fats = $post_input['fats'] ?? '3g';

	$category_id = NULL;
	$subcategory_id = NULL;
	if ($category) {
		$ci->load->model('categories_model');
		$category_id = $ci->categories_model->get_category_id_by_name($category);
	}

	if ($subcategory) {
		$ci->load->model('sub_categories_model');
		$subcategory_id = $ci->sub_categories_model->get_sub_category_id_by_name($subcategory);
	}

	set_dietary_restrictions($ci, $dietary_restrictions);

	return array(
        'cuisine' => $cuisine,
        'spice_tolerance' => $spice_tolerance,
        'dietary_restrictions' => $dietary_restrictions,
        'cooking_style' => $cooking_style,
		'cooking_time' => $cooking_time,
        'category' => $category_id,
		'subcategory' => $subcategory_id,
		'carbs' => $carbs,
        'proteins' => $proteins,
        'fats' => $fats,
	);
}

function set_dietary_restrictions($ci, $dietary_restrictions) {
	$ci->load->model('user_dietary_restrictions_model');
	if (!$dietary_restrictions) {
		$ci->user_dietary_restrictions_model->delete_user_dietary_restrictions($ci->user_id);
		return;
	}
	$ci->load->model('ingredients_model');
	$dietary_restrictions_array = explode(',', $dietary_restrictions);
	$existing_restrictions = $ci->user_dietary_restrictions_model->get_existing_restrictions($ci->user_id);
	$existing_restrictions_array = array_column($existing_restrictions, 'ingredient_id');
	if (empty($existing_restrictions_array)) {
		$ci->user_dietary_restrictions_model->delete_user_dietary_restrictions($ci->user_id);
	}

	foreach ($dietary_restrictions_array as $dietary_restriction) {
		$ingredient = $ci->ingredients_model->get_or_create(trim($dietary_restriction));
		if ($ingredient) {
			if (!in_array($ingredient, $existing_restrictions_array)) {
				$ci->user_dietary_restrictions_model->insert_dietary_restrictions($ingredient, $ci->user_id);
			}
		}
	}

}
?>

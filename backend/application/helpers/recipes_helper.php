<?php
function fetch_recipes($ci) {
	$ci->load->model('user_preferences_model');
	$ci->load->model('user_dietary_restrictions_model');
	$ci->load->model('ingredients_model');
	$ci->load->model('recipe_model');
	$ci->load->model('recipe_ingredients_model');

	$user_preference = $ci->user_preferences_model->get_user_preferences($ci->user_id);
	$dietary_restrictions = $ci->user_dietary_restrictions_model->get_user_dietary_restrictions($ci->user_id);
	$post_data = restructure_data($ci, $user_preference, $dietary_restrictions);
	$response_from_db = fetch_from_db($ci, $user_preference);
//	$response_from_db =  process_response_from_db($ci, $user_preference, $post_data, $response_from_db);
	$response_from_ai = [];
	$post_data['count_of_recipes_to_fetch'] = 2;
	$response_from_ai = get_response($post_data);
	$response_from_ai['results'] =  process_response($ci, $user_preference, $post_data, $response_from_ai);

	return array_merge($response_from_db, $response_from_ai['results'] ?? []);
}

function fetch_recipe($ci, $recipe_id) {
	$ci->load->model('recipe_model');
    return $ci->recipe_model->get_recipe($recipe_id);
}
function fetch_from_db($ci, $user_preference) {
	return [];
	$dietary_restrictions = $ci->user_dietary_restrictions_model->get_user_dietary_restrictions($ci->user_id);
	return $ci->recipe_model->get_recipe_based_on_preference($user_preference, $dietary_restrictions);
}

function process_response_from_db($ci, $user_preference, $post_data, $recipes): array {
	if (!isset($recipes['results'])) {
		return [];
	}
	$data = [];
	$index = 0;
	foreach ($recipes['results'] as $recipe) {
		$data[$index] = [
			'title' => $recipe['title'],
			'image_url' => upload_image($ci, $recipe['image_url']) ?? NULL,
			'ingredients' => $recipe['ingredients'] ?? NULL,
			'carbs' => $recipe['carbs'] ?? NULL,
			'proteins' => $recipe['protein']?? NULL,
			'fats' => $recipe['fats']?? NULL,
			'servings' => $recipe['servings']?? NULL,
			'cuisine' => $recipe['cuisine'] ?? NULL,
			'spice' => $recipe['spice'] ?? NULL,
			'meal_type' => $recipe['meal_type'] ?? NULL,
			'instructions' => add_br_tags($recipe['instructions'] ?? NULL),
			'cooking_time' => $recipe['cooking_time'] ?? NULL,
			'cooking_style' => $recipe['cooking_style'] ?? NULL,
			'cleaned_ingredients' => $recipe['cleaned_ingredients'] ?? NULL,
		];

		$recipe = add_recipe($ci, $data[$index], $post_data, $user_preference);
		$data[$index]['recipe_id'] = (int)$recipe;
		unset($data[$index]['instructions']);
		unset($data[$index]['cleaned_ingredients']);
		$index++;
	}
	return array_values($data);
}
function process_response($ci, $user_preference, $post_data, $recipes): array {
	$data = [];
	$index = 0;
	foreach ($recipes as $recipe) {
		if (!isset($recipe['title'])) {
			continue;
		}
		$data[$index] = [
			'title' => clean_text($recipe['title']),
			'image_url' => upload_image($ci, $recipe['image_url'] ?? NULL),
			'ingredients' => clean_text(get_instructions($recipe['ingredients'] ?? NULL)),
			'carbs' => clean_text($recipe['carbs'] ?? NULL),
			'proteins' => clean_text($recipe['proteins'] ?? NULL),
			'fats' => clean_text($recipe['fats'] ?? NULL),
			'servings' => clean_text($recipe['servings'] ?? NULL),
			'cuisine' => clean_text($recipe['cuisine'] ?? NULL),
			'spice' => clean_text($recipe['spice'] ?? NULL),
			'meal_type' => clean_text($recipe['meal_type'] ?? NULL),
			'instructions' => clean_text(get_instructions($recipe['instructions'] ?? NULL)),
			'cooking_time' => $recipe['cooking_time'] ?? NULL,
			'cooking_style' => $recipe['cooking_style'] ?? NULL,
			'cleaned_ingredients' => $recipe['cleaned_ingredients'] ?? NULL,
		];
		$recipe = add_recipe($ci, $data[$index], $post_data, $user_preference);
		$data[$index]['recipe_id'] = (int)$recipe;
		unset($data[$index]['instructions']);
		unset($data[$index]['cleaned_ingredients']);
		$index++;
	}
	return array_values($data);
}

function clean_text($text) {
	if ($text) {
		$text = str_replace('-', ' ', $text);
		$text = trim($text);
		return $text;
	}
	return $text;
}

function get_instructions($instructions) {
	if (is_array($instructions)) {
		return implode('<br>', $instructions);
	} else {
		return $instructions;
	}
}

function add_recipe($ci, $recipe, $post_data, $user_preference) {
	$recipe['category'] = $user_preference['category_id'] ?? NULL;
	$recipe['subcategory'] = $user_preference['sub_category_id']?? NULL;
	$recipe['taste'] = $recipe['taste'] ?? NULL;
	$recipe['texture'] = $recipe['taste'] ?? NULL;
	$recipe['location'] = $post_data['location'] ?? NULL;
	list($recipe_id, $newly_created) = $ci->recipe_model->add_recipe($recipe);
	if (!$newly_created) {
		return $recipe_id;
	}
	$ingredients = $recipe['cleaned_ingredients'] ? explode(',', $recipe['ingredients']) : [];
	foreach ($ingredients as $ingredient) {
		$ingredient_id = $ci->ingredients_model->get_or_create(trim($ingredient));
		if ($ingredient_id) {
			$ci->recipe_ingredients_model->insert($recipe_id, $ingredient_id);
		}
	}
	return $recipe_id;
}
function upload_image($ci, $image_url) {
	return $image_url;
	$ci->load->helper('url');
	$ci->load->helper('file');
	$upload_path = './uploads/';
	if (!is_dir($upload_path)) {
		mkdir($upload_path, 0777, true);
	}
	$image_data = file_get_contents($image_url);
	if ($image_data === FALSE) {
		return false;
	}

	$filename = uniqid() . '.jpg';

	$file_path = $upload_path . $filename;
	if (write_file($file_path, $image_data)) {
		return $filename;
	}
}

function restructure_data($ci, $user_preference, $dietary_restrictions): array {
	$data = array();
	if ($user_preference['meat']) {
		$data['hero_ingredient'] = $user_preference['meat'] . ' ' . $user_preference['type'];
	} else {
		$data['hero_ingredient'] = 'Chicken';
	}
	if (isset($user_preference['carbs']) && $user_preference['carbs']) {
		$data['nutrients']['carbs'] = $user_preference['carbs'] . 'g';
	}
	if (isset($user_preference['proteins']) && $user_preference['proteins']) {
		$data['nutrients']['proteins'] = $user_preference['proteins'] . 'g';
	}
	if (isset($user_preference['fats']) && $user_preference['fats']) {
		$data['nutrients']['fats'] = $user_preference['fats'] . 'g';
	}
	if (isset($user_preference['spice_tolerance']) && $user_preference['spice_tolerance']) {
		$data['spice_tolerance'] = $user_preference['spice_tolerance'];
	}

	if (isset($user_preference['cooking_style']) && $user_preference ['cooking_style']) {
        $data['cooking_style'] = $user_preference['cooking_style'];
    }
	if (isset($user_preference['cooking_time']) && $user_preference['cooking_time']) {
        $data['cooking_time'] = 'Less than ' . $user_preference['cooking_time'] . ' minutes';
    }
	if (isset($user_preference['cuisine']) && $user_preference['cuisine']) {
        $data['cuisine'] = $user_preference['cuisine'];
    } else {
		$data['cuisine'] = 'Italian/Indian/Chinese';

	}
	if (isset($user_preference['food_taste']) && $user_preference['food_taste']) {
		$data['food_taste'] = $user_preference['food_taste'];
	}
	if (isset($user_preference['food_texture']) && $user_preference['food_texture']) {
		$data['food_texture'] = $user_preference['food_texture'];
	}
	if ($dietary_restrictions) {
		$data['dietary_restrictions'] = $dietary_restrictions;
	}
	$location = get_location($ci);
	if ($location) {
        $data['location'] = $location;
    }
	$data['servings'] = 2;
	return $data;
}
function add_br_tags($input): string {
	if (!$input) {
		return $input;
	}
	$output = preg_replace('/(\d+\. )/', '<br>$1', $input);
	return ltrim($output, '<br/>');
}

function get_response($post_data) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://13.200.223.248:5000/generate");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		"Content-Type: application/json",
	]);
	$jsonData = json_encode($post_data);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
	$response = curl_exec($ch);

	if (curl_errno($ch)) {
		return [];
	} else {
		return json_decode($response, true);
	}

// Close the cURL session
	curl_close($ch);

	$url = "http://13.200.223.248:5000/generate";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));

	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}

function get_location($ci): false|string {
    $user_ip = $ci->input->ip_address();
    $access_token = 'b70ea86a1781aa';
    $url = "https://ipinfo.io/{$user_ip}/json?token={$access_token}";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($curl);
    curl_close($curl);

    $location_data = json_decode($response, true);
	if (isset($location_data['region']) && isset($location_data['country'])) {
        return $location_data['region'] . ','. $location_data['country'];
    }
	return false;
}
function save_recipe($ci, $recipe_id): bool {
	$ci->load->model('saved_recipes_model');
	$exists = $ci->saved_recipes_model->recipe_exists($ci->user_id, $recipe_id);
	if (!$exists) {
		$data = array(
			'user_id' => $ci->user_id,
			'recipe_id' => $recipe_id
		);

		$ci->saved_recipes_model->insert_saved_recipe($data);
	}
	return true;
}

function fetch_saved_recipes($ci): array {
	$ci->load->model('saved_recipes_model');
	$recipes = $ci->saved_recipes_model->get_saved_recipes($ci->user_id);
	$data = [];
	$index = 0;
	foreach ($recipes as $recipe) {
		$data[$index] = [
			'title' => $recipe['title'],
			'image_url' => upload_image($ci, $recipe['image_url']) ?? NULL,
			'ingredients' => $recipe['ingredients'] ?? NULL,
			'carbs' => $recipe['carbs'] ?? NULL,
			'proteins' => $recipe['protein']?? NULL,
			'fats' => $recipe['fats']?? NULL,
			'servings' => $recipe['servings']?? NULL,
			'cuisine' => $recipe['cuisine'] ?? NULL,
			'spice' => $recipe['spice'] ?? NULL,
			'meal_type' => $recipe['meal_type'] ?? NULL,
			'cooking_time' => $recipe['cooking_time'] ?? NULL,
			'cooking_style' => $recipe['cooking_style'] ?? NULL,
			'cleaned_ingredients' => $recipe['cleaned_ingredients'] ?? NULL,
		];

		$data[$index]['recipe_id'] = (int)$recipe;
		$index++;
	}
	return array_values($data);
}

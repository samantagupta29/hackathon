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
	return process_response($ci, $user_preference, $post_data, get_response($post_data));
}

function fetch_from_db($post_data) {

}

function process_response($ci, $user_preference, $post_data, $response): array {
	if (!$response) {
		return [];
	}

	$recipes = json_decode($response, true);
	if (empty($recipes['results'])) {
		return [];
	}
	$data = [];
	$index = 0;
	foreach ($recipes['results'] as $recipe) {
		$data[$index] = [
			'title' => $recipe['title'],
			'image_url' => upload_image($ci, $recipe['image_url']) ?? NULL,
			'ingredients' => $recipe['ingredients'],
			'carbs' => $recipe['carbs'] ?? NULL,
			'proteins' => $recipe['protein']?? NULL,
			'fats' => $recipe['fats']?? NULL,
			'servings' => $recipe['servings']?? NULL,
			'cuisine' => $recipe['cuisine'] ?? NULL,
			'spice' => $recipe['spice'] ?? NULL,
			'meal_type' => $recipe['meal_type'] ?? NULL,
			'instructions' => $recipe['instructions'] ?? NULL,
			'cooking_time' => $recipe['cooking_time'] ?? NULL,
			'cooking_style' => $recipe['cooking_style'] ?? NULL
		];

		add_recipe($ci, $data[$index], $post_data, $user_preference);
		$index++;
	}
	return array_values($data);
}

function add_recipe($ci, $recipe, $post_data, $user_preference) {
	$recipe['category'] = $user_preference['category_id'] ?? NULL;
	$recipe['subcategory'] = $user_preference['sub_category_id']?? NULL;
	$recipe['taste'] = $recipe['taste'] ?? NULL;
	$recipe['texture'] = $recipe['taste'] ?? NULL;
	$recipe['location'] = $post_data['location'] ?? NULL;
	$recipe_id = $ci->recipe_model->add_recipe($recipe);

	if (!$recipe_id) {
		return;
	}
	$ingredients = $recipe['ingredients'] ? explode(',', $recipe['ingredients']) : [];
	foreach ($ingredients as $ingredient) {
		$ingredient_id = $ci->ingredients_model->get_or_create(trim($ingredient));
		if ($ingredient_id) {
			$ci->recipe_ingredients_model->insert($recipe_id, $ingredient_id);
		}
	}


}
function upload_image($ci, $image_url) {
	return 'sa';
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

function get_response($post_data) {
	$response = [];
	$response['results']  = [
		[
			"title" => "Baked Chicken Curry",
			"image_url" => "https://example.com/images/baked_chicken_curry.jpg",
			"ingredients" => "500g Chicken Curry cuts, 2 tablespoons curry powder, 1 cup yogurt, 1 onion (chopped), 2 tomatoes (chopped), 2 tablespoons cooking oil, salt to taste, fresh cilantro for garnish",
			"carbs" => "244g",
			"protein" => "344g",
			"fats" => "344g",
			"taste" => "Spicy and savory with a hint of tanginess",
			"servings" => "2",
			"cuisine" => "Indian",
			"spice" => "Medium",
			"meal_type" => "Dinner",
			"instructions" => "1. Preheat the oven to 200°C (392°F). 2. In a bowl, mix the chicken with yogurt, curry powder, chopped onion, tomatoes, and salt. 3. Marinate for at least 5 minutes. 4. Place the marinated chicken in a baking dish, drizzle with oil, and bake for 10 minutes or until fully cooked. 5. Garnish with fresh cilantro before serving."
		],
		[
			"title" => "Vegetable Stir-Fry",
			"image_url" => "https://example.com/images/vegetable_stir_fry.jpg",
			"ingredients" => "1 cup bell peppers, 1 cup broccoli, 1 cup carrots, 2 tablespoons soy sauce, 1 tablespoon sesame oil, garlic to taste",
			"carbs" => "100g",
			"protein" => "15g",
			"fats" => "10g",
			"taste" => "Fresh and crunchy with a hint of umami",
			"servings" => "2",
			"cuisine" => "Chinese",
			"spice" => "Low",
			"meal_type" => "Lunch",
			"instructions" => "1. Heat sesame oil in a pan. 2. Add garlic and sauté for 1 minute. 3. Add vegetables and stir-fry for 5-7 minutes. 4. Add soy sauce and cook for another 2 minutes."
		],
		[
			"title" => "Spaghetti Aglio e Olio",
			"image_url" => "https://example.com/images/spaghetti_aglio_e_olio.jpg",
			"ingredients" => "200g spaghetti, 4 cloves garlic (sliced), 1/2 cup olive oil, red pepper flakes, parsley for garnish",
			"carbs" => "120g",
			"protein" => "10g",
			"fats" => "40g",
			"taste" => "Garlicky and mildly spicy",
			"servings" => "2",
			"cuisine" => "Italian",
			"spice" => "Medium",
			"meal_type" => "Dinner",
			"instructions" => "1. Cook spaghetti as per package instructions. 2. In a pan, heat olive oil and sauté garlic until golden. 3. Add red pepper flakes. 4. Toss spaghetti with the oil mixture and garnish with parsley."
		],
		[
			"title" => "Caprese Salad",
			"image_url" => "https://example.com/images/caprese_salad.jpg",
			"ingredients" => "2 large tomatoes, 1 ball of mozzarella, fresh basil leaves, balsamic vinegar, olive oil, salt",
			"carbs" => "15g",
			"protein" => "20g",
			"fats" => "25g",
			"taste" => "Fresh and tangy",
			"servings" => "2",
			"cuisine" => "Italian",
			"spice" => "None",
			"meal_type" => "Appetizer",
			"instructions" => "1. Slice tomatoes and mozzarella. 2. Layer them with basil leaves. 3. Drizzle with olive oil and balsamic vinegar. 4. Sprinkle with salt before serving."
		],
		[
			"title" => "Chicken Tacos",
			"image_url" => "https://example.com/images/chicken_tacos.jpg",
			"ingredients" => "300g shredded chicken, taco shells, 1 cup lettuce, 1 cup diced tomatoes, cheese, salsa",
			"carbs" => "80g",
			"protein" => "50g",
			"fats" => "20g",
			"taste" => "Savory with a kick of freshness",
			"servings" => "2",
			"cuisine" => "Mexican",
			"spice" => "Medium",
			"meal_type" => "Dinner",
			"instructions" => "1. Fill taco shells with shredded chicken. 2. Top with lettuce, tomatoes, cheese, and salsa. 3. Serve immediately."
		],
		[
			"title" => "Beef Stir-Fry",
			"image_url" => "https://example.com/images/beef_stir_fry.jpg",
			"ingredients" => "250g beef strips, 1 cup mixed vegetables, 2 tablespoons soy sauce, 1 tablespoon ginger, garlic to taste",
			"carbs" => "40g",
			"protein" => "60g",
			"fats" => "25g",
			"taste" => "Savory with a hint of sweetness",
			"servings" => "2",
			"cuisine" => "Asian",
			"spice" => "Medium",
			"meal_type" => "Dinner",
			"instructions" => "1. Heat oil in a pan. 2. Add ginger and garlic, sauté until fragrant. 3. Add beef and cook until browned. 4. Add vegetables and soy sauce, stir-fry until cooked."
		],
		[
			"title" => "Lentil Soup",
			"image_url" => "https://example.com/images/lentil_soup.jpg",
			"ingredients" => "1 cup lentils, 1 onion (chopped), 2 carrots (diced), 4 cups vegetable broth, spices to taste",
			"carbs" => "50g",
			"protein" => "20g",
			"fats" => "5g",
			"taste" => "Hearty and comforting",
			"servings" => "2",
			"cuisine" => "Middle Eastern",
			"spice" => "Medium",
			"meal_type" => "Lunch",
			"instructions" => "1. In a pot, sauté onion and carrots. 2. Add lentils and broth. 3. Bring to a boil, then simmer until lentils are tender. 4. Season with spices."
		],
		[
			"title" => "Pancakes",
			"image_url" => "https://example.com/images/pancakes.jpg",
			"ingredients" => "1 cup flour, 1 tablespoon sugar, 1 teaspoon baking powder, 1 cup milk, 1 egg, butter for cooking",
			"carbs" => "60g",
			"protein" => "10g",
			"fats" => "20g",
			"taste" => "Fluffy and sweet",
			"servings" => "2",
			"cuisine" => "American",
			"spice" => "None",
			"meal_type" => "Breakfast",
			"instructions" => "1. Mix dry ingredients. 2. Whisk in milk and egg. 3. Heat a pan, add butter, and pour batter. 4. Cook until bubbles form, then flip."
		],
		[
			"title" => "Mushroom Risotto",
			"image_url" => "https://example.com/images/mushroom_risotto.jpg",
			"ingredients" => "1 cup Arborio rice, 2 cups vegetable broth, 1 cup mushrooms (sliced), 1 onion (chopped), Parmesan cheese",
			"carbs" => "70g",
			"protein" => "15g",
			"fats" => "10g",
			"taste" => "Creamy and earthy",
			"servings" => "2",
			"cuisine" => "Italian",
			"spice" => "Low",
			"meal_type" => "Dinner",
			"instructions" => "1. Sauté onion and mushrooms. 2. Add rice and stir. 3. Gradually add broth, stirring continuously until creamy. 4. Stir in Parmesan before serving."
		],
		[
			"title" => "Greek Salad",
			"image_url" => "https://example.com/images/greek_salad.jpg",
			"ingredients" => "1 cucumber, 2 tomatoes, 1 bell pepper, 100g feta cheese, olives, olive oil, oregano",
			"carbs" => "20g",
			"protein" => "10g",
			"fats" => "15g",
			"taste" => "Fresh and tangy",
			"servings" => "2",
			"cuisine" => "Greek",
			"spice" => "None",
			"meal_type" => "Appetizer",
			"instructions" => "1. Chop all vegetables and mix in a bowl. 2. Crumble feta on top. 3. Drizzle with olive oil and sprinkle with oregano."
		]
	];

	return json_encode($response);
	$url = "https://example.com/api/endpoint";

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

function get_location($ci) {
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

?>

<?php
function fetch_recipes($ci) {
	$ci->load->model('user_preferences_model');
	$ci->load->model('user_dietary_restrictions_model');

	$user_preference = $ci->user_preferences_model->get_user_preferences($ci->user_id);
	$dietary_restrictions = $ci->user_dietary_restrictions_model->get_user_dietary_restrictions($ci->user_id);
	$post_data = restructure_data($ci, $user_preference, $dietary_restrictions);
	process_response(get_response($post_data));
}

function process_response($response) {
	if (!$response) {
		return [];
	}
	$recipes = json_decode($response, true);
	if (!empty($recipes['results'])) {
		return [];
	}
	$recipes = $recipes['results'];
	foreach ($recipes['results'] as $recipe) {
		$title = $recipe['title'];
	}
}

function restructure_data($ci, $user_preference, $dietary_restrictions) {
	$data = array();
	if ($user_preference['meat']) {
		$data['hero_ingredient'] = $user_preference['meat'] . ' ' . $user_preference['type'];
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
	$url = "https://example.com/api/endpoint";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

	$response = curl_exec($ch);
	return $response;
	curl_close($ch);
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

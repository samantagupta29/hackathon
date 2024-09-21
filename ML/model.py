import os
import re
from openai import OpenAI
from flask import Flask, request, jsonify
from constants import (
	API_KEY,
	MODEL_ID,
	MAX_TOKENS,
	TEMPRATURE,
	IMAGE_QUALITY,
	IMAGE_SIZE,
	IMAGE_STYLE,
)

client = OpenAI(api_key=API_KEY)


def generate_recipes(prompt, num_recipes):
	responses = []
	for _ in range(num_recipes):
		response = client.chat.completions.create(
			model=MODEL_ID,
			messages=[
				{
					"role": "system",
					"content": "You are a helpful AI for generating non-vegetarian recipes.",
				},
				{"role": "user", "content": prompt},
			],
			max_tokens=MAX_TOKENS,
			temperature=TEMPRATURE,
		)
		responses.append(response.choices[0].message.content)
	return responses


def generate_image(description):
	prompt = f"Top view of {description} on a white plate."
	try:
		response = client.images.generate(
			prompt=prompt[:400],
			n=1,
			size=IMAGE_SIZE,
			quality=IMAGE_QUALITY,
		)
		return response.data[0].url
	except Exception as e:
		print(f"Error generating image: {e}")
		return None



def generate_recipe_prompt(data):
	prompt_parts = [
		"Create a unique recipe using the following inputs:",
		f"Hero Ingredient: {data['hero_ingredient']}.",
	]

	if "cooking_style" in data:
		prompt_parts.append(f"Cooking Style: {data['cooking_style']}.")

	if "spice_tolerance" in data:
		prompt_parts.append(f"Spice Tolerance: {data['spice_tolerance']}.")

	if "nutrients" in data:
		prompt_parts.append(
			f"Nutrients - Carbs: {data.get('nutrients', {}).get('carbs', 'not specified')}, "
			f"Proteins: {data.get('nutrients', {}).get('proteins', 'not specified')}, "
			f"Fats: {data.get('nutrients', {}).get('fats', 'not specified')}."
		)

	if "cuisine" in data:
		prompt_parts.append(f"Cuisine: {data['cuisine']}.")

	if "servings" in data:
		prompt_parts.append(f"Servings: {data['servings']}.")

	if "location" in data:
		prompt_parts.append(f"Location: {data['location']}.")

	if "cooking_time" in data:
		prompt_parts.append(f"Cooking Time: {data['cooking_time']}.")

	prompt_parts.append(
		"Please ensure to include the following in your output format:"
		"\n1. Title"
		"\n2. Ingredients"
		"\n3. Instructions"
		"\n4. Cooking Time"
		"\n5. Taste (from the categories: 'Sweet', 'Sour', 'Salty', 'Bitter')"
		"\n6. Texture (from the categories: 'Soft', 'Crunchy', 'Creamy', 'Chewy', 'Smooth')"
		"\n7. Image URL"
		"\n8. Nutritional Information (Carbs, Proteins, Fats)"
		"\n9. Servings"
		"\n10. Cuisine"
		"\n11. Spice Tolerance"
		"\n12. Meal Type"
	)

	prompt = " ".join(prompt_parts)

	return prompt


app = Flask(__name__)


@app.route("/generate", methods=["POST", "GET"])
def generate():
	# data = {
		# 	"hero_ingredient": 'chicken'
	# }
	data = request.json
	prompt = generate_recipe_prompt(data)
	num_recipes = data.get("count_of_recipes_to_fetch", 1)

	recipes = generate_recipes(prompt, num_recipes)
	results = []

	for recipe in recipes:
		extracted_components = extract_recipe_components(recipe)

		results.append(
			{
				"title": extracted_components.get('title'),
				"ingredients": extracted_components.get('ingredients'),
				"carbs": extracted_components.get('nutritional_info', {}).get('carbs'),
				"proteins": extracted_components.get('nutritional_info', {}).get('proteins'),
				"fats": extracted_components.get('nutritional_info', {}).get('fats'),
				"taste": extracted_components.get('taste'),
				"servings": extracted_components.get('servings'),
				"cuisine": extracted_components.get('cuisine'),
				"spice": extracted_components.get('spice'),
				"meal_type": extracted_components.get('meal_type'),
				"instructions": extracted_components.get('instructions'),
				"texture": extracted_components.get('texture'),
				"cooking_style": extracted_components.get('cooking_style'),
				"cooking_time": extracted_components.get('cooking_time'),
			}
		)

	return jsonify(results)


def extract_recipe_components(recipe_output):
	components = {}

	# Extract title
	title_match = re.search(r"### Title: (.+)", recipe_output)
	if title_match:
		components['title'] = title_match.group(1).strip()

	# Extract ingredients
	ingredients_match = re.search(r"#### Ingredients:\n((?:- .+\n?)+)", recipe_output)
	if ingredients_match:
		components['ingredients'] = ingredients_match.group(1).strip().splitlines()

	# Extract instructions
	instructions_match = re.search(r"#### Instructions:\n((?:\d+\..+\n?)+)", recipe_output)
	if instructions_match:
		components['instructions'] = instructions_match.group(1).strip().splitlines()

	# Extract cooking time
	cooking_time_match = re.search(r"#### Cooking Time:\n- Total Time: (.+)", recipe_output)
	if cooking_time_match:
		components['cooking_time'] = cooking_time_match.group(1).strip()

	# Extract taste
	taste_match = re.search(r"#### Taste:\n- (.+)", recipe_output)
	if taste_match:
		components['taste'] = taste_match.group(1).strip()

	# Extract texture
	texture_match = re.search(r"#### Texture:\n- (.+)", recipe_output)
	if texture_match:
		components['texture'] = texture_match.group(1).strip()

	# Extract image URL

	# Extract nutritional information
	nutrition_match = re.search(r"#### Nutritional Information \(per serving\):\n- Carbs: (.+)\n- Proteins: (.+)\n- Fats: (.+)", recipe_output)
	if nutrition_match:
		components['nutritional_info'] = {
			'carbs': nutrition_match.group(1).strip(),
			'proteins': nutrition_match.group(2).strip(),
			'fats': nutrition_match.group(3).strip(),
		}

	# Extract servings
	servings_match = re.search(r"#### Servings:\n(\d+)", recipe_output)
	if servings_match:
		components['servings'] = servings_match.group(1).strip()

	# Extract cuisine
	cuisine_match = re.search(r"#### Cuisine:\n(.+)", recipe_output)
	if cuisine_match:
		components['cuisine'] = cuisine_match.group(1).strip()

	# Extract spice tolerance
	spice_tolerance_match = re.search(r"#### Spice Tolerance:\n(.+)", recipe_output)
	if spice_tolerance_match:
		components['spice_tolerance'] = spice_tolerance_match.group(1).strip()

	# Extract meal type
	meal_type_match = re.search(r"#### Meal Type:\n(.+)", recipe_output)
	if meal_type_match:
		components['meal_type'] = meal_type_match.group(1).strip()

	return components

def categorize_taste(recipe):
	if "taste" in recipe:
		taste = recipe["taste"].lower()
		if "sweet" in taste:
			return "Sweet"
		elif "sour" in taste:
			return "Sour"
		elif "salty" in taste:
			return "Salty"
	return "Bitter"


def categorize_texture(recipe):
	if "texture" in recipe:
		texture = recipe["texture"].lower()
		if "crunchy" in texture:
			return "Crunchy"
		elif "soft" in texture:
			return "Soft"
		elif "creamy" in texture:
			return "Creamy"
	return "Chewy"


def extract_recipe_title(recipe):
	match = re.search(r"^(.+?)(?=\n)", recipe, re.MULTILINE)
	return match.group(0).strip() if match else "Recipe"


def extract_ingredients(recipe):
	ingredients_section = re.search(
		r"Ingredients:\s*(.+?)(?=\n\n|Instructions:)", recipe, re.DOTALL
	)
	return (
		ingredients_section.group(1).strip().split("\n") if ingredients_section else []
	)


def extract_instructions(recipe):
	instructions_section = re.search(r"Instructions:\s*(.+)", recipe, re.DOTALL)
	return (
		instructions_section.group(1).strip()
		if instructions_section
		else "Instructions not found."
	)


def extract_cooking_time(recipe):
	match = re.search(r"(\d+)\s*minutes", recipe)
	if match:
		return int(match.group(1))
	return 0


if __name__ == "__main__":
	app.run(host="0.0.0.0", port=5000, debug=True)

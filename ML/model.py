import os
import re
from openai import OpenAI
from flask import Flask, request, jsonify
from constants import (
    API_KEY,
    MODEL_ID,
    MAX_TOKENS,
    TEMPERATURE,
    IMAGE_QUALITY,
    IMAGE_SIZE,
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
            temperature=TEMPERATURE,
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
        "You are a highly advanced AI assistant dedicated to generating a unique recipe based on the inputs provided. "
        "Your task is to ensure that every required element of the recipe is generated without exception. "
        "If any information is missing, you **must** provide a placeholder or estimate based on common recipes to fill in the gaps. "
        "Failure to include any element is unacceptable."
        "\n\n1. **Title**: Provide a descriptive title for the recipe. If no specific title is available, use 'Untitled Recipe'."
        "\n\n2. **Ingredients**: Provide a complete list of ingredients used in this recipe. If specific ingredients are missing, include 'common ingredients for a dish like this' explicitly."
        "\n\n3. **Instructions**: Provide detailed step-by-step cooking instructions. If no instructions are available, include 'No specific instructions found; prepare as you would normally for this type of dish' clearly."
        "\n\n4. **Cooking Time**: Provide an estimated cooking time (in minutes). If the cooking time is unavailable, estimate based on the hero ingredient and cooking style, and explicitly include this estimate."
        "\n\n5. **Taste**: From the categories: 'Sweet', 'Sour', 'Salty', 'Bitter'. If taste is not specified, state 'Taste not specified' clearly."
        "\n\n6. **Texture**: From the categories: 'Soft', 'Crunchy', 'Creamy', 'Chewy', 'Smooth'. If texture is not specified, state 'Texture not specified' clearly."
        "\n\n7. **Image URL**: (This will be generated separately using the image generation model). If the image URL is not generated, provide 'Image URL not available'."
        "\n\n8. **Nutritional Information**: Include Carbs, Proteins, and Fats. If nutritional information is not available, estimate it based on common values for the hero ingredient and clearly indicate this estimate."
        "\n\n9. **Servings**: Provide the number of servings. If servings are not available, use a default value (e.g., 2 servings) and clearly state it."
        "\n\n10. **Cuisine**: Specify the cuisine type. If unspecified, choose based on the input ingredients or hero ingredient. If not available, state 'Cuisine not specified' clearly."
        "\n\n11. **Spice Tolerance**: Specify the spice tolerance level as 'Mild', 'Medium', 'Spicy', or 'Hot'. If not provided, use 'Spice tolerance not specified' clearly."
        "\n\n12. **Meal Type**: Specify if the recipe is for 'Breakfast', 'Lunch', 'Dinner', or 'Snack'. If not provided, use 'Meal type not specified' clearly."
        "\n\n13. **Cooking Style**: Provide the cooking style used (e.g., 'baked', 'grilled', 'fried'). If cooking style is not specified, use 'Traditional Cooking Method' as a placeholder clearly."
        "\n\nYou **must** repeat this process for each recipe. You are required to ensure that **no value is skipped**. Every recipe should have a complete output. "
        "Your priority is to deliver comprehensive and accurate information for every element listed above, regardless of input availability."
    )

    return " ".join(prompt_parts)


app = Flask(__name__)


@app.route("/generate", methods=["POST"])
def generate():
    data = request.json
    prompt = generate_recipe_prompt(data)
    num_recipes = data.get("count_of_recipes_to_fetch", 1)

    recipes = generate_recipes(prompt, num_recipes)
    results = []

    for recipe in recipes:
        extracted_components = extract_recipe_components(recipe)
        results.append(
            {
                "title": extracted_components.get("title"),
                "image_url": extracted_components.get("image_url"),
                "ingredients": extracted_components.get("ingredients"),
                "carbs": extracted_components.get("nutritional_info", {}).get("carbs"),
                "proteins": extracted_components.get("nutritional_info", {}).get(
                    "proteins"
                ),
                "fats": extracted_components.get("nutritional_info", {}).get("fats"),
                "taste": extracted_components.get("taste"),
                "servings": extracted_components.get("servings"),
                "cuisine": extracted_components.get("cuisine"),
                "spice": extracted_components.get("spice"),
                "meal_type": extracted_components.get("meal_type"),
                "instructions": extracted_components.get("instructions"),
                "texture": extracted_components.get("texture"),
                "cooking_style": extracted_components.get("cooking_style"),
                "cooking_time": extracted_components.get("cooking_time"),
            }
        )

    return jsonify(results)


def extract_recipe_components(recipe_output):
    components = {}

    # Extract title
    title_match = re.search(r"Title: (.+)", recipe_output)
    if title_match:
        components["title"] = title_match.group(1).strip()

    # Extract ingredients
    ingredients_match = re.search(r"Ingredients:\n((?:- .+\n?)+)", recipe_output)
    if ingredients_match:
        components["ingredients"] = ingredients_match.group(1).strip().splitlines()

    # Extract instructions
    instructions_match = re.search(r"Instructions:\n((?:\d+\..+\n?)+)", recipe_output)
    if instructions_match:
        components["instructions"] = instructions_match.group(1).strip().splitlines()

    # Extract cooking time
    cooking_time_match = re.search(r"Cooking Time:\n- Total Time: (.+)", recipe_output)
    if cooking_time_match:
        components["cooking_time"] = cooking_time_match.group(1).strip()

    # Extract taste
    taste_match = re.search(r"Taste:\n- (.+)", recipe_output)
    if taste_match:
        components["taste"] = taste_match.group(1).strip()

    # Extract texture
    texture_match = re.search(r"Texture:\n- (.+)", recipe_output)
    if texture_match:
        components["texture"] = texture_match.group(1).strip()

    # Extract image URL
    image_url_match = re.search(r"Image URL:\n!\[(.+?)\]\((.+?)\)", recipe_output)
    if image_url_match:
        components["image_url"] = image_url_match.group(2).strip()

    return components


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)

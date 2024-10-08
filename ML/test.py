import os
import re
import json
from openai import OpenAI
from constants import (
    API_KEY,
    MODEL_ID,
    MAX_TOKENS,
    TEMPRATURE,
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
    # prompt = f"Top view of {description} on a white plate."
    response = client.images.generate(
        prompt=description[:400], n=1, size="256x256", style="vivid", quality="hd"
    )
    return response.data[0].url


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
            f"Nutrients - Carbs: {data['nutrients']['carbs']}, "
            f"Proteins: {data['nutrients']['proteins']}, "
            f"Fats: {data['nutrients']['fats']}."
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
        "You are an AI assistant generating a unique recipe using the following inputs."
        " Please ensure that the final recipe includes every required element."
        " If information is missing, provide a placeholder or estimate based on common recipes."
        "\n\n1. **Title**: Provide a descriptive title for the recipe. If no specific title is available, use 'Untitled Recipe'."
        "\n\n2. **Ingredients**: Provide a list of ingredients used in this recipe."
        " If specific ingredients are missing, include 'common ingredients for a dish like this'."
        "\n\n3. **Instructions**: Provide step-by-step cooking instructions."
        " If no instructions are available, add 'No specific instructions found; prepare as you would normally for this type of dish'."
        "\n\n4. **Cooking Time**: Provide an estimated cooking time (in minutes). If cooking time is unavailable, estimate based on the hero ingredient and cooking style."
        "\n\n5. **Taste**: From the categories: 'Sweet', 'Sour', 'Salty', 'Bitter'."
        "\n\n6. **Texture**: From the categories: 'Soft', 'Crunchy', 'Creamy', 'Chewy', 'Smooth'."
        "\n\n7. **Image URL**: (This will be generated separately using the image generation model)."
        "\n\n8. **Nutritional Information**: Include Carbs, Proteins, and Fats. If nutritional information is not available, estimate it based on common values for the hero ingredient."
        "\n\n9. **Servings**: Provide the number of servings. If servings are not available, use a default value (e.g., 2 servings)."
        "\n\n10. **Cuisine**: Specify the cuisine type. If unspecified, choose based on the input ingredients or hero ingredient."
        "\n\n11. **Spice Tolerance**: Specify the spice tolerance level as 'Mild', 'Medium', 'Spicy', or 'Hot'."
        "\n\n12. **Meal Type**: Specify if the recipe is for 'Breakfast', 'Lunch', 'Dinner', or 'Snack'."
    )

    prompt = " ".join(prompt_parts)
    return prompt


# def categorize_taste(recipe):
#     if "taste" in recipe:
#         taste = recipe["taste"].lower()
#         if "sweet" in taste:
#             return "Sweet"
#         elif "sour" in taste:
#             return "Sour"
#         elif "salty" in taste:
#             return "Salty"
#     return "Bitter"


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
    # Sample input data for testing
    input_data = {
        "hero_ingredient": "Fish",
        "nutrients": {"carbs": "", "proteins": "", "fats": ""},
        "spice_tolerance": "",
        "cooking_style": "",
        "cooking_time": "",
        "cuisine": "",
        "servings": None,
        "location": "",
        "count_of_recipes_to_fetch": 1,
    }

    # Generate prompt
    prompt = generate_recipe_prompt(input_data)

    # Generate recipes
    recipes = generate_recipes(prompt, input_data["count_of_recipes_to_fetch"])
    # print("===============", "\n", recipes, "\n", "===================", "\n")
    # Process each recipe
    results = []
    for recipe in recipes:
        # DALL·E is used to generate images now
        # taste = categorize_taste(recipe)
        texture = categorize_texture(recipe)
        image_url = generate_image(recipe)
        results.append(
            {
                "title": extract_recipe_title(recipe),
                "image_url": image_url,
                "ingredients": extract_ingredients(recipe),
                "carbs": input_data["nutrients"]["carbs"],
                "protein": input_data["nutrients"]["proteins"],
                "fats": input_data["nutrients"]["fats"],
                "taste": "Salty",
                "servings": str(input_data["servings"]),
                "cuisine": input_data["cuisine"],
                "spice": input_data["spice_tolerance"],
                "meal_type": "Dinner",
                "instructions": extract_instructions(recipe),
                "texture": texture,
                "cooking_style": input_data["cooking_style"],
                "cooking_time": extract_cooking_time(recipe),
            }
        )

    # Print the results
    for result in results:
        print(result)

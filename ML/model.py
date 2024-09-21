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
    response = client.images.generate(
        prompt=prompt,
        n=1,
        size=IMAGE_SIZE,
        style=IMAGE_QUALITY,
        quality=IMAGE_STYLE,
    )
    return response.data[0].url


def generate_recipe_prompt(data):
    prompt_parts = [f"Create a unique recipe using {data['hero_ingredient']}."]

    if "cooking_style" in data:
        prompt_parts.append(f"with {data['cooking_style']} cooking style")

    if "spice_tolerance" in data:
        prompt_parts.append(f"and a spice tolerance of {data['spice_tolerance']}")

    if "nutrients" in data:
        prompt_parts.append(
            f"containing {data['nutrients']['carbs']} of carbs, "
            f"{data['nutrients']['proteins']} of proteins, and "
            f"{data['nutrients']['fats']} of fats"
        )

    if "cuisine" in data:
        prompt_parts.append(f"in {data['cuisine']} cuisine")

    if "servings" in data:
        prompt_parts.append(f"for {data['servings']} servings")

    if "location" in data:
        prompt_parts.append(f"located in {data['location']}")

    if "cooking_time" in data:
        prompt_parts.append(f"that can be prepared in {data['cooking_time']}.")

    prompt_parts.append(
        "Please include taste from the categories: 'Sweet', 'Sour', 'Salty', 'Bitter', "
        "and texture from the categories: 'Soft', 'Crunchy', 'Creamy', 'Chewy', 'Smooth'."
    )

    prompt = " ".join(prompt_parts)

    return prompt


app = Flask(__name__)


@app.route("/generate", methods=["POST"])
def generate():
    data = request.json

    prompt = generate_recipe_prompt(data)
    num_recipes = data.get("count_of_recipes_to_fetch", 1)

    recipes = generate_recipes(prompt, num_recipes)

    results = []
    for recipe in recipes:
        image_url = generate_image(recipe)

        taste = categorize_taste(recipe)
        texture = categorize_texture(recipe)

        results.append(
            {
                "title": extract_recipe_title(recipe),
                "image_url": image_url,
                "ingredients": extract_ingredients(recipe),
                "carbs": data["nutrients"]["carbs"],
                "protein": data["nutrients"]["proteins"],
                "fats": data["nutrients"]["fats"],
                "taste": taste,
                "servings": str(data["servings"]),
                "cuisine": data["cuisine"],
                "spice": data["spice_tolerance"],
                "meal_type": "Dinner",
                "instructions": extract_instructions(recipe),
                "texture": texture,
                "cooking_style": data["cooking_style"],
                "cooking_time": extract_cooking_time(recipe),
            }
        )

    return jsonify(results)


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
    app.run(debug=True)

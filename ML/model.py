import os
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
    prompt_parts = [f"I have {data['hero_ingredient']}."]

    if "cooking_style" in data:
        prompt_parts.append(f"with {data['cooking_style']} cooking style")

    if "spice_tolerance" in data:
        prompt_parts.append(f"and spice tolerance of {data['spice_tolerance']}")

    if "nutrients" in data:
        prompt_parts.append(
            f"containing {data['nutrients']['carbs']} carbs, {data['nutrients']['proteins']} proteins, and {data['nutrients']['fats']} fats"
        )

    if "cuisine" in data:
        prompt_parts.append(f"in {data['cuisine']} cuisine")

    if "servings" in data:
        prompt_parts.append(f"for {data['servings']} servings")

    prompt_parts.append(f"in less than {data['cooking_time']}")

    prompt = " ".join(prompt_parts) + ". Suggest me a recipe."

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
    if "sweet" in recipe.lower():
        return "Sweet"
    elif "sour" in recipe.lower():
        return "Sour"
    elif "salty" in recipe.lower():
        return "Salty"
    else:
        return "Bitter"


def categorize_texture(recipe):
    if "crunchy" in recipe.lower():
        return "Crunchy"
    elif "soft" in recipe.lower():
        return "Soft"
    elif "creamy" in recipe.lower():
        return "Creamy"
    else:
        return "Chewy"


def extract_recipe_title(recipe):
    return recipe.split("\n")[0]


def extract_ingredients(recipe):
    return "List of ingredients from the recipe"


def extract_instructions(recipe):
    return "List of instructions from the recipe"


def extract_cooking_time(recipe):
    return 10


if __name__ == "__main__":
    app.run(debug=True)

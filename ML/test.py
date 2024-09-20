from flask import Flask, request, jsonify
import openai
from ML.model import generate_image, generate_recipes

app = Flask(__name__)


@app.route("/generate", methods=["POST"])
def generate():
    data = request.json
    user_preferences = data["user_preferences"]
    num_recipes_per_preference = data["num_recipes_per_preference"]

    results = []
    for pref in user_preferences:
        ingredients_str = ", ".join(pref["ingredients"])
        cooking_style_str = (
            f"with {pref['cooking_style']} cooking style"
            if "cooking_style" in pref
            else ""
        )
        dietary_preferences_str = (
            f"keeping in mind {', '.join(pref['dietary_preferences'])}"
            if "dietary_preferences" in pref
            else ""
        )

        prompt_parts = [f"I have {ingredients_str}."]
        if cooking_style_str:
            prompt_parts.append(cooking_style_str)
        if dietary_preferences_str:
            prompt_parts.append(dietary_preferences_str)

        prompt = " ".join(prompt_parts) + ". Suggest me a recipe."

        recipes = generate_recipes(prompt, num_recipes_per_preference)
        for i, recipe in enumerate(recipes):
            image_description = f"Image of {recipe}"
            image_url = generate_image(image_description)
            results.append({"recipe": recipe, "image_url": image_url})

    return jsonify(results)


if __name__ == "__main__":
    app.run(debug=True)

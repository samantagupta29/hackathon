import os
from openai import OpenAI
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
    response = client.images.generate(
        prompt=description,
        n=1,
        size=IMAGE_SIZE,
        style=IMAGE_QUALITY,
        quality=IMAGE_STYLE,
    )
    return response.data[0].url

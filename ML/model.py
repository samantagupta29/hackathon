import os
from openai import OpenAI

client = OpenAI(
    api_key="sk-9jqcuK8RrFmp-ccA3_07PY0CU79s7ESmrragTjn5c5T3BlbkFJcWNWZwRP6jSepi3Xy5Wis0EKdKpOCm3MMEza4pukYA"
)


def generate_recipes(prompt, num_recipes):
    responses = []
    for _ in range(num_recipes):
        response = client.chat.completions.create(
            model="gpt-4o-mini-2024-07-18",
            messages=[
                {
                    "role": "system",
                    "content": "You are a helpful AI for generating non-vegetarian recipes.",
                },
                {"role": "user", "content": prompt},
            ],
            max_tokens=1024,
            temperature=0.5,
        )
        responses.append(response.choices[0].message.content)
    return responses


def generate_image(description):
    response = client.images.generate(
        prompt=description, n=1, size="512x512", style="vivid", quality="hd"
    )
    return response.data[0].url

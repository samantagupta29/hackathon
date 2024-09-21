import React from 'react'
import {Link} from 'react-router-dom'

function SuggestedRecipe({recipe}) {
  const id = recipe.recipe_id
console.log(recipe.recipe_id)
  return (
    <div class="relative flex flex-col my-6 bg-white shadow-sm border border-slate-200 rounded-lg w-96 m-10 ml-20">
    <div class="relative h-56 m-2.5 overflow-hidden text-white rounded-md">
    <img src="https://thehappyfoodie.co.uk/wp-content/uploads/2023/03/Butter_Chicken.jpg" alt="card-image" />
      {/* <img src={recipe.image_url} alt="card-image" /> */}
    </div>
    <div class="p-4">
      
     {recipe &&  <h6 class="mb-2 text-slate-800 text-xl font-semibold">
        {recipe.title}
      </h6>}
      
      <div class="text-slate-600 leading-normal font-light">
      <p className='font-bold'>Ingredients: </p>
        <p>{recipe.ingredients}</p>
      <div className='flex'>
        <div>
        <p className='font-bold'>Nutrients: </p>
        <ul>
          <li>Fats: {recipe.fats}</li>
          <li>carbs: {recipe.proteins}</li>
          <li>Protein: {recipe.carbs}</li>
        </ul>
        </div>
        <p className='font-bold ml-10'>Cooking Time: {recipe.cooking_time}</p>
      </div>
      </div>
    </div>
    <div class="px-4 pb-4 pt-0 mt-2">
      {/* <button class="rounded-md bg-slate-800 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
        Read more
      </button> */}
      <Link to={`recipe_detail/${recipe?.recipe_id}`} state= { {id : id}}>Read more</Link>
    </div>
  </div>  
  )
}

export default SuggestedRecipe
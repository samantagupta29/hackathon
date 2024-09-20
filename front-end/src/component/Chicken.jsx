import React from 'react'
import SuggestedRecipe from './SuggestedRecipe'
import RecipeButton from './RecipeButton'
import Card from './RecipeCard'

function Chicken() {
  return (
    <div >
    <div className="h-60 flex-col items-center justify-between p-4 bg-red-200">
      <h1 className="text-xl font-bold p-2 pb-4">Chicken </h1>
      <div style={{ backgroundColor: 'rgb(196, 0, 49)' }} className="p-2 rounded-lg">
      <h1 className="text-white text-center">India's Best chicken delivery App </h1>
    </div>
    {/* <img src={licious/src/assets/view1.png}  className="w-full h-auto rounded-lg" /> */}
    </div>
    <div className="flex p-4 space-x-8">
  <Card heading="Chicken Tikka"></Card>
  <Card heading="Chicken Masala"></Card>
  <Card heading="Chicken Grill"></Card>
  <Card heading="Chicken Boiled"></Card>
</div>

<RecipeButton></RecipeButton>

<SuggestedRecipe></SuggestedRecipe>

    </div>
  )
}

export default Chicken
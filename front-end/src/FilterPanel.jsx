import React, { useState } from 'react';
import axios from 'axios'
import SuggestedRecipe from './SugggestedRecipe';
import { useEffect } from 'react';

const FilterPanel = () => {
  const [recipes, setRecipes] = useState([]);
  const [filters, setFilters] = useState({
    category: '',
    subcategory: '',
    spiceTolerance: '',
    dietaryRestrictions: '',
    cookingStyle: '',
    ingredients: '',
    cookingTime: '', // New state for Cooking Time
    cuisine: '', // New state for Cuisine
    carbs: '', // New state for Carbohydrates
    fat: '',   // New state for Fat
    protein: '', // New state for Proteins
  });

  useEffect(() => {
    handleLoading()
  }, []);

  const handleLoading = async () => {
    try {
      const response = await axios.post('/api/user_preferences/apply_filters_and_get_recipes');
      // const response2 = await axios.get('/api/user_preferences/get_filters/apply_filters_and_get_recipes', payload);
      setRecipes(response.data.recipes)
      console.log('Success: default recipes are loaded', response.data);
      // Handle successful response (e.g., reset filters, show a success message)
    } catch (error) {
      console.error('Error:', error);
      // Handle error response (e.g., show an error message)
    }
  }
  const handlecategoryChange = (category) => {
    setFilters((prevFilters) => ({
      ...prevFilters,
      category,
      subcategory: '', // Reset subcategory when changing category
    }));
  };

  const handlesubcategoryChange = (subcategory) => {
    setFilters((prevFilters) => ({
      ...prevFilters,
      subcategory,
    }));
  };

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFilters((prevFilters) => ({
      ...prevFilters,
      [name]: value,
    }));
  };

  const handleSubmit = async () => {
    if (!filters.category) {
      alert("Please select a category."); // Show an alert or use a more user-friendly UI for errors
      return; // Prevent submission
    }
    // Prepare the request payload
    const payload = {
      category: filters.category,
      subcategory: filters.subcategory,
      cuisine: filters.cuisine,
      spice_tolerance: filters.spiceTolerance,
      dietary_restricts: filters.dietaryRestrictions.split(',').map(item => item.trim()).join(','),
      cooking_style: filters.cookingStyle,
      cooking_time: filters.cookingTime,
      carbs: filters.carbs,
      fats: filters.fat,
      proteins: filters.protein,
    };

    try {
      // const response = await axios.get('/api/user_preferences/apply_filters_and_get_recipes', payload);
       const response = await axios.post('/api/user_preferences/apply_filters_and_get_recipes', payload);
      setRecipes(response.data.recipes)
      console.log('Success:', response.data);
      // Handle successful response (e.g., reset filters, show a success message)
    } catch (error) {
      console.error('Error:', error);
      // Handle error response (e.g., show an error message)
    }
  };
  const categoryOptions = ['Chicken', 'Fish', 'Mutton', 'Eggs'];
  const subcategoryOptions = {
    Chicken: ['Curry cuts', 'Boneless', 'Mince'],
    Fish: ['Rohu', 'Indian Salmon'],
    Eggs: ['Classic', 'Quail'],
    Mutton: ['Curry cuts', 'Boneless', 'Mince'],
  };

  const cookingTimeOptions = ['< 15 mins', '< 30 mins', '< 1 hr', '< 2 hrs', '> 2 hrs'];
  const cuisineOptions = ['Indian', 'Chinese', 'Italian'];

  return (
    <div className='flex'>
      <div className="w-full max-w-xs p-6 bg-pink-100 shadow-lg rounded-lg">
        {/* Heading with border */}
        <h2 className="text-xl font-semibold text-gray-700 mb-4 border-b border-gray-300 pb-2">
          Filters
        </h2>

        {/* category Section with Radio Buttons */}
        <div className="mb-6">
          <h3 className="font-semibold text-gray-600 mb-2">category</h3>
          <ul className="space-y-2">
            {categoryOptions?.map((category) => (
              <li key={category}>
                <label className="flex items-center space-x-2">
                  <input
                    type="radio"
                    name="category"
                    className="form-radio h-4 w-4 text-indigo-600 border-gray-300 rounded"
                    checked={filters.category === category}
                    onChange={() => handlecategoryChange(category)}
                  />
                  <span className="text-gray-700">{category}</span>
                </label>
              </li>
            ))}
          </ul>
        </div>

        {/* Categories Section with Radio Buttons (Single Select) */}
        {filters.category && (
          <div className="mb-6">
            <h3 className="font-semibold text-gray-600 mb-2">
              {filters.category} Categories
            </h3>
            <ul className="space-y-2">
              {subcategoryOptions[filters.category].map((subcategory) => (
                <li key={subcategory}>
                  <label className="flex items-center space-x-2">
                    <input
                      type="radio"
                      name="subcategory"
                      className="form-radio h-4 w-4 text-indigo-600 border-gray-300 rounded"
                      checked={filters.subcategory === subcategory}
                      onChange={() => handlesubcategoryChange(subcategory)}
                    />
                    <span className="text-gray-700">{subcategory}</span>
                  </label>
                </li>
              ))}
            </ul>
          </div>
        )}

        {/* Dietary Restrictions */}
        <div className="mb-6">
          <h3 className="font-semibold text-gray-600">Dietary Restrictions</h3>
          <input
            type="text"
            name="dietaryRestrictions"
            className="border-gray-300 rounded-md w-full p-2 mt-1 text-gray-700"
            placeholder="Enter dietary restrictions"
            value={filters.dietaryRestrictions}
            onChange={handleInputChange}
          />
        </div>

        {/* Spice Tolerance */}
        <div className="mb-6">
          <h3 className="font-semibold text-gray-600 mb-2">Spice Tolerance</h3>
          <div className="space-y-2">
            {['Mild', 'Medium', 'Spicy', 'Very Spicy'].map((level) => (
              <label className="flex items-center space-x-2" key={level}>
                <input
                  type="radio"
                  name="spiceTolerance"
                  className="form-radio h-4 w-4 text-indigo-600 border-gray-300"
                  value={level}
                  checked={filters.spiceTolerance === level}
                  onChange={handleInputChange}
                />
                <span className="text-gray-700">{level}</span>
              </label>
            ))}
          </div>
        </div>

        {/* Cooking Style */}
        <div className="mb-6">
          <h3 className="font-semibold text-gray-600 mb-2">Cooking Style</h3>
          <select
            name="cookingStyle"
            className="border-gray-300 rounded-md w-full p-2 text-gray-700"
            value={filters.cookingStyle}
            onChange={handleInputChange}
          >
            <option value="">Select Cooking Style</option>
            <option value="Grilled">Grilled</option>
            <option value="Baked">Baked</option>
            <option value="Fry">Fry</option>
          </select>
        </div>

        {/* Ingredients */}
        <div className="mb-6">
          <h3 className="font-semibold text-gray-600">Ingredients to Include</h3>
          <input
            type="text"
            name="ingredients"
            className="border-gray-300 rounded-md w-full p-2 mt-1 text-gray-700"
            placeholder="Enter ingredients"
            value={filters.ingredients}
            onChange={handleInputChange}
          />
        </div>

        {/* Cooking Time Section */}
        <div className="mb-6">
          <h3 className="font-semibold text-gray-600 mb-2">Cooking Time</h3>
          <ul className="space-y-2">
            {cookingTimeOptions.map((time) => (
              <li key={time}>
                <label className="flex items-center space-x-2">
                  <input
                    type="radio"
                    name="cookingTime"
                    className="form-radio h-4 w-4 text-indigo-600 border-gray-300"
                    value={time}
                    checked={filters.cookingTime === time}
                    onChange={handleInputChange}
                  />
                  <span className="text-gray-700">{time}</span>
                </label>
              </li>
            ))}
          </ul>
        </div>

        {/* Cuisine Section */}
        <div className="mb-6">
          <h3 className="font-semibold text-gray-600 mb-2">Cuisine</h3>
          <ul className="space-y-2">
            {cuisineOptions.map((cuisine) => (
              <li key={cuisine}>
                <label className="flex items-center space-x-2">
                  <input
                    type="radio"
                    name="cuisine"
                    className="form-radio h-4 w-4 text-indigo-600 border-gray-300"
                    value={cuisine}
                    checked={filters.cuisine === cuisine}
                    onChange={handleInputChange}
                  />
                  <span className="text-gray-700">{cuisine}</span>
                </label>
              </li>
            ))}
          </ul>
        </div>

        {/* Carbohydrates Input */}
        <div className="mb-6">
          <h3 className="font-semibold text-gray-600">Carbohydrates (g)</h3>
          <input
            type="number"
            name="carbs"
            className="border-gray-300 rounded-md w-full p-2 mt-1 text-gray-700"
            placeholder="Enter carbohydrates"
            value={filters.carbs}
            onChange={handleInputChange}
          />
        </div>

        {/* Fat Input */}
        <div className="mb-6">
          <h3 className="font-semibold text-gray-600">Fat (g)</h3>
          <input
            type="number"
            name="fat"
            className="border-gray-300 rounded-md w-full p-2 mt-1 text-gray-700"
            placeholder="Enter fat"
            value={filters.fat}
            onChange={handleInputChange}
          />
        </div>

        {/* Protein Input */}
        <div className="mb-6">
          <h3 className="font-semibold text-gray-600">Protein (g)</h3>
          <input
            type="number"
            name="protein"
            className="border-gray-300 rounded-md w-full p-2 mt-1 text-gray-700"
            placeholder="Enter protein"
            value={filters.protein}
            onChange={handleInputChange}
          />
        </div>

        {/* Submit Button */}
        <div className="mt-6">
          <button
            className="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600"
            onClick={handleSubmit}
          >
            Submit Filters
          </button>
        </div>
      </div>
      <div>
      <div className="flex justify-end  mt-5 mr-10">
          <button
          className="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600"
          onClick={handleSubmit}
        >
         Try More Recipes
        </button> </div>
        <div className='flex flex-wrap ml-10'>

          {recipes.map((recipe) => (
            <SuggestedRecipe recipe={recipe} />
          ))}
        </div>
      </div>
    </div>

  );
};

export default FilterPanel;

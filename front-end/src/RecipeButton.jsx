import React from 'react'
import { useState } from 'react';

function RecipeButton() {
    const [showFilterPanel, setShowFilterPanel] = useState(false);
  
    const handleButtonClick = () => {
      setShowFilterPanel(!showFilterPanel); // Toggle the panel visibility
    };
  
    return (
      <div className="mt-auto flex flex-col justify-end pr-12">
        <button 
          className="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600" 
          onClick={handleButtonClick}
        >
          Generate Recipe
        </button>
  
        {showFilterPanel && <FilterPanel />}
      </div>
    );
  }
  
  export default RecipeButton;
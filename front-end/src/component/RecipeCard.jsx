import React from 'react';

const RecipeCard = ({ portrait, heading }) => {
  return (
    <div className="flex  bg-pink-300 shadow-md rounded-lg p-4 m-2, w-80">
      <h2 className="text-lg font-semibold">{heading}</h2>
    </div>
  );
};

export default RecipeCard;

import React from 'react';
import { Routes, Route } from 'react-router-dom';
import ReceipeDetails from './ReceipeDetails';
import SavedReceipes from './SavedReceipes';
import Home from './Home';
import FilterPanel from './FilterPanel';
import FestivePage from './FestiveBanner';
import Currency from './Currency';

export default function Router() {
  return (
    <div>
      <Routes>
        <Route path='/' element={<Home />} />
        <Route path='/generate_receipe' element={<FilterPanel />} />
        <Route path='/generate_receipe/recipe_detail/:recipeId' element={<ReceipeDetails />} />
        <Route path='/saved_recipes' element={<SavedReceipes />} />
        <Route path='/festive' element={<FestivePage />} />
        <Route path='/currency' element={<Currency />} />
      </Routes>
    </div>
  );
}

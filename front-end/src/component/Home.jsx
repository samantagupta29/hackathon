import React, { useState } from 'react';
import Header from './Header'; // Adjust the path if needed
import FilterPanel from './FilterPanel'; // Assuming FilterPanel is needed
import FestiveBanner from './FestiveBanner.jsx'; // Import the FestiveBanner component
import { Link } from 'react-router-dom';

function Home() {
  const [isFilterOpen, setIsFilterOpen] = useState(false);

  const toggleFilterPanel = () => {
    setIsFilterOpen(!isFilterOpen);
  };

  return (
    <div>
      <Header />
      
      {/* Render the FestiveBanner component */}
      <div className="mt-4">
        <FestiveBanner />
      </div>

      {/* Conditionally render the FilterPanel */}
      {isFilterOpen && <FilterPanel />}

      <div className='mt-4'>
        
        {/* Button to go to the "Generate Recipe" page */}
        <Link 
          className="absolute right-10 top-50 bg-red-600 text-white border-none rounded-lg px-4 py-2 cursor-pointer text-lg" 
          to="/generate_receipe"
        >
          Generate recipe
        </Link>

        {/* Button to go to the "Currency" page */}
        <Link 
          className="absolute left-10 top-50 bg-blue-600 text-white border-none rounded-lg px-4 py-2 cursor-pointer text-lg" 
          to="/currency"
        >
         Linious Currency 
        </Link>

      </div> 
    </div>
  );
}

export default Home;

import React from "react";

function Currency({ val }) {
  return (
    <div className="flex justify-center items-center h-screen bg-[#f4dce3] relative overflow-hidden">
      {/* Colorful Background Circles */}
      <div className="absolute top-0 left-0 w-full h-full overflow-hidden">
        <div className="bg-gradient-to-br from-pink-400 to-red-400 opacity-50 rounded-full w-80 h-80 animate-bounce absolute -top-20 -left-20"></div>
        <div className="bg-gradient-to-br from-purple-400 to-pink-300 opacity-60 rounded-full w-60 h-60 animate-bounce absolute -bottom-20 -right-20"></div>
      </div>

      <div className="bg-[#efc1cf] w-1/4 p-8 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 relative z-10">
        <div className="flex items-center mb-4">
          <svg
            className="w-8 h-8 text-red-600"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path d="M18 5h-.7c.229-.467.349-.98.351-1.5a3.5 3.5 0 0 0-3.5-3.5c-1.717 0-3.215 1.2-4.331 2.481C8.4.842 6.949 0 5.5 0A3.5 3.5 0 0 0 2 3.5c.003.52.123 1.033.351 1.5H2a2 2 0 0 0-2 2v3a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V7a2 2 0 0 0-2-2ZM8.058 5H5.5a1.5 1.5 0 0 1 0-3c.9 0 2 .754 3.092 2.122-.219.337-.392.635-.534.878Zm6.1 0h-3.742c.933-1.368 2.371-3 3.739-3a1.5 1.5 0 0 1 0 3h.003ZM11 13H9v7h2v-7Zm-4 0H2v5a2 2 0 0 0 2 2h3v-7Zm6 0v7h3a2 2 0 0 0 2-2v-5h-5Z" />
          </svg>
          <h5 className="ml-2 text-2xl font-semibold text-red-700">
            Licious Coins:
          </h5>
        </div>
        <div className="flex justify-center items-center">
          <img
            className="ml-3"
            src="https://images.emojiterra.com/google/noto-emoji/unicode-15.1/color/svg/1fa99.svg"
            width="40px"
          />
          <h5 className="ml-3 text-4xl font-normal text-gray-700">{val ? val : 43}</h5>
        </div>
      </div>
    </div>
  );
}

export default Currency;

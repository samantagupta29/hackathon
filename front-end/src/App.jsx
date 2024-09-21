import { useState } from 'react'
import FilterPanel from './component/FilterPanel'
import Header from './component/Header'
import Home from './component/Home'
import { BrowserRouter as BRouter } from 'react-router-dom'
import Router from './component/Router'

function App() {

  return (
    <>
      {/* <Chicken></Chicken> */}
      {/* <FilterPanel></FilterPanel> */}
      <BRouter>
        <Router />
      </BRouter>
      {/* <Home></Home> */}
      {/* <Header></Header> */}
    </>
  )
}

export default App

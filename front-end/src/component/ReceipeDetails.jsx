import React from "react";
import { styled } from "@mui/material/styles";
import { Card, CardContent, Typography, CardMedia, Box } from "@mui/material";
import { useLocation } from 'react-router-dom';
import { useEffect } from "react";
import axios from "axios";
import { useState } from "react";
// import FoodImage from "../FoodImage.jpg";


const Container = styled("div")(({ theme }) => ({
 padding: "20px",
 // display: "flex",
 // justifyContent: "center",
 // alignItems: "center",
 height: "100%",
 maxWidth: "1080px",
 margin: "0 auto",
}));


export default function ReceipeDetails() {
    const location = useLocation();
    const [recipes, setResponse] = useState([]);
    const { id } = location.state || {};
    console.log(id)

    useEffect(() => {
      axios.get(`http://13.200.223.248/recipe/get_recipe/${id}`)
      .then((data) => {
        console.log(data)
        setResponse(data.data);
      })
    })

 const instructionSteps = recipes?.instructions?.split('\n')?.map(step => step.trim()).filter(step => step);
 instructionSteps?.map((step) => {
   console.log(step);
 })
 return (
   <Container>
     <Card sx={{ maxWidth: 600, margin: "auto", mt: 5 }}>
       {/* Recipe Image */}
       <CardMedia
         component="img"
         height="250"
         image={recipes.image_url}
        //  image={FoodImage} // Replace with a valid image URL
         alt={recipes.title}
       />


       {/* Recipe Content */}
       <CardContent sx={{ textAlign: "left" }}>
         {/* Title */}
         <Typography variant="h5" component="div" gutterBottom>
           {recipes.title}
         </Typography>


         {/* Cuisine, Spice, Meal Type */}
         <Typography variant="body2"  gutterBottom style={{marginBottom: "15px"}}>
           <strong>Cuisine:</strong> {recipes.cuisine}&nbsp;&nbsp; |{" "}
           <strong>Spice Level:</strong> {recipes.spice}&nbsp;&nbsp; |{" "}
           <strong>Meal Type:</strong> {recipes.meal_type}
         </Typography>


         {/* Ingredients */}
         <Typography variant="body2" color="textPrimary" gutterBottom>
         <strong>Ingredients:</strong>
       </Typography>
       {recipes?.ingredients?.map((ingredient, index) => (
         <Typography key={index} variant="body2" color="textSecondary">
           {ingredient}
         </Typography>
       ))}


         {/* Nutritional Information */}
         <Box sx={{ display: "flex", justifyContent: "space-between", mt: 2 , marginBottom: "20px"}}>
           <Typography variant="body2">
             <strong>Carbs:</strong> {recipes.carbs}
           </Typography>
           <Typography variant="body2">
             <strong>Protein:</strong> {recipes.protein}
           </Typography>
           <Typography variant="body2">
             <strong>Fats:</strong> {recipes.fats}
           </Typography>
         </Box>


         {/* Instructions */}
         <Typography variant="body2" color="textPrimary" gutterBottom>
           <strong>Instructions:</strong>
         </Typography>
         <ul>
           {instructionSteps?.map((instruction, index) => (
             <Typography variant="body2" key={index}>{instruction}</Typography>
           ))}
         </ul>


       </CardContent>
     </Card>
   </Container>
 );
}




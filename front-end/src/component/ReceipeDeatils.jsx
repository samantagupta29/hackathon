import React from "react";
import { styled } from "@mui/material/styles";
import { Card, CardContent, Typography, CardMedia, Box } from "@mui/material";
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
 const recipe = {
   title: "Baked Chicken Curry",
   image_url: "https://thehappyfoodie.co.uk/wp-content/uploads/2023/03/Butter_Chicken.jpg", // Use a placeholder image for now
   ingredients: [
     "500g Chicken Curry cuts",
     "2 tablespoons curry powder",
     "1 cup yogurt",
     "1 onion (chopped)",
     "2 tomatoes (chopped)",
     "2 tablespoons cooking oil",
     "salt to taste",
     "fresh cilantro for garnish",
   ],
   carbs: "244g",
   protein: "344g",
   fats: "344g",
   taste: "Spicy and savory with a hint of tanginess",
   servings: "2",
   cuisine: "Indian",
   spice: "Medium",
   meal_type: "Dinner",
   instructions: `1. Preheat the oven to 200°C (392°F).
                 2. In a bowl, mix the chicken with yogurt, curry powder, chopped onion, tomatoes, and salt.
                 3. Marinate for at least 5 minutes.
                 4. Place the marinated chicken in a baking dish, drizzle with oil, and bake for 10 minutes or until fully cooked.
                 5. Garnish with fresh cilantro before serving.`,
 }


 const instructionSteps = recipe.instructions.split('\n').map(step => step.trim()).filter(step => step);
 instructionSteps.map((step) => {
   console.log(step);
 })
 return (
   <Container>
     <Card sx={{ maxWidth: 600, margin: "auto", mt: 5 }}>
       {/* Recipe Image */}
       <CardMedia
         component="img"
         height="250"
         image={recipe.image_url}
        //  image={FoodImage} // Replace with a valid image URL
         alt={recipe.title}
       />


       {/* Recipe Content */}
       <CardContent sx={{ textAlign: "left" }}>
         {/* Title */}
         <Typography variant="h5" component="div" gutterBottom>
           {recipe.title}
         </Typography>


         {/* Cuisine, Spice, Meal Type */}
         <Typography variant="body2"  gutterBottom style={{marginBottom: "15px"}}>
           <strong>Cuisine:</strong> {recipe.cuisine}&nbsp;&nbsp; |{" "}
           <strong>Spice Level:</strong> {recipe.spice}&nbsp;&nbsp; |{" "}
           <strong>Meal Type:</strong> {recipe.meal_type}
         </Typography>


         {/* Ingredients */}
         <Typography variant="body2" color="textPrimary" gutterBottom>
         <strong>Ingredients:</strong>
       </Typography>
       {recipe.ingredients.map((ingredient, index) => (
         <Typography key={index} variant="body2" color="textSecondary">
           {ingredient}
         </Typography>
       ))}


         {/* Nutritional Information */}
         <Box sx={{ display: "flex", justifyContent: "space-between", mt: 2 , marginBottom: "20px"}}>
           <Typography variant="body2">
             <strong>Carbs:</strong> {recipe.carbs}
           </Typography>
           <Typography variant="body2">
             <strong>Protein:</strong> {recipe.protein}
           </Typography>
           <Typography variant="body2">
             <strong>Fats:</strong> {recipe.fats}
           </Typography>
         </Box>


         {/* Instructions */}
         <Typography variant="body2" color="textPrimary" gutterBottom>
           <strong>Instructions:</strong>
         </Typography>
         <ul>
           {instructionSteps.map((instruction, index) => (
             <Typography variant="body2" key={index}>{instruction}</Typography>
           ))}
         </ul>


       </CardContent>
     </Card>
   </Container>
 );
}




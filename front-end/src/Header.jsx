import React, { useState } from "react";
import {
 AppBar,
 Toolbar,
 Typography,
 IconButton,
 InputBase,
 Box,
} from "@mui/material";
import LocationOnIcon from "@mui/icons-material/LocationOn";
import SearchIcon from "@mui/icons-material/Search";
import ShoppingCartIcon from "@mui/icons-material/ShoppingCart";
import AccountCircleIcon from "@mui/icons-material/AccountCircle";
import LiciousLogo from "../assets/LiciousLogo.png"
import LayersIcon from "@mui/icons-material/Layers";
import ReceipeDetails from "./ReceipeDetails";


export default function Header() {
 return (
   <>
     <AppBar
       position="static"
       style={{ backgroundColor: "#fff", color: "#000", height: 80 }}
     >
       <Toolbar
         sx={{
           display: "flex",
           justifyContent: "center",
           alignItems: "center",
           height: "100%",
         }}
       >
         <img
           src={LiciousLogo}
           alt="Licious"
           style={{ height: 50, marginTop: 10, marginRight: 30 }}
         />


         <IconButton>
           <LocationOnIcon />
           <Box
             sx={{
               alignItems: "flex-start",
               display: "flex",
               flexDirection: "column",
             }}
           >
             <Typography
               variant="body2"
               sx={{ fontWeight: "bold" }}
               style={{ marginLeft: 5 }}
             >
               NCR
             </Typography>
             <Typography variant="caption" style={{ marginLeft: 5 }}>
               A Block, Block A, Sector 30
             </Typography>
           </Box>
         </IconButton>


         <Box
           sx={{
             display: "flex",
             alignItems: "center",
             backgroundColor: "#f0f0f0",
             borderRadius: 1,
             width: "23%",
             marginLeft: 20,
           }}
         >
           <IconButton type="submit" sx={{ p: "10px" }}>
             <SearchIcon />
           </IconButton>
           <InputBase placeholder="Search for any delicious product" />
         </Box>


         <IconButton style={{ marginLeft: 30 }}>
           <LayersIcon />
           <Typography variant="body1" style={{ marginLeft: 5 }}>
             Categories
           </Typography>
         </IconButton>


         <IconButton style={{ marginLeft: 30 }}>
           <AccountCircleIcon />
           <Typography variant="body1" style={{ marginLeft: 5 }}>
             Login
           </Typography>
         </IconButton>


         <IconButton style={{ marginLeft: 30 }}>
           <ShoppingCartIcon />
           <Typography variant="body1" style={{ marginLeft: 5 }}>
             Cart
           </Typography>
         </IconButton>
       </Toolbar>
     </AppBar>
     {/* <ReceipeDetails/> */}
   </>
 );
}



CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `image` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `created_at`, `last_updated_at`) VALUES
(1, 'Chicken', '', '2024-09-19 03:07:01', '2024-09-20 04:34:08'),
(2, 'Fish', '', '2024-09-19 03:07:16', '2024-09-20 04:34:03'),
(3, 'Mutton', '', '2024-09-19 03:07:24', '2024-09-20 04:34:12'),
(4, 'Eggs', '', '2024-09-19 03:08:33', '2024-09-20 04:35:07');

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('unconfirmed','active') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `status`, `created_at`, `last_updated_at`) VALUES
(2, 'milk', 'unconfirmed', '2024-09-20 07:23:14', '2024-09-20 07:23:14'),
(3, 'bread', 'unconfirmed', '2024-09-20 07:23:14', '2024-09-20 07:23:14'),
(4, 'Nuts', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(5, 'Dairy', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(6, 'Gluten', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(7, 'Shellfish', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(8, 'Fish', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(9, 'Eggs', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(10, 'Soy', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(11, 'Legumes', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(12, 'Sweeteners', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(13, 'Additives', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(14, 'Corn', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(15, 'Peanuts', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(16, 'Sesame', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(17, 'Coconut', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(18, 'Almonds', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(19, 'Wheat', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(20, 'Barley', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(21, 'Rye', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(22, 'Oats', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(23, 'Sulfites', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(24, 'Nightshades', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(25, 'Mustard', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(26, 'Celery', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(27, 'Ginger', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(28, 'Garlic', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(29, 'Fennel', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(30, 'Citrus Fruits', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(31, 'Mushrooms', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(32, 'Honey', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(33, 'Artificial Sweeteners', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(34, 'Preservatives', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(35, 'Potatoes', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(36, 'Tomatoes', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(37, 'Eggplants', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(38, 'Peppers', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(39, 'Zucchini', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(40, 'Carrots', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(41, 'Spinach', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(42, 'Broccoli', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(43, 'Cauliflower', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(44, 'Lettuce', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(45, 'Radishes', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(46, 'Cabbage', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(47, 'Asparagus', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(48, 'Brussels Sprouts', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(49, 'Kale', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(50, 'Artichokes', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(51, 'Beets', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(52, 'Avocado', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(53, 'Berries', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(54, 'Cherries', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(55, 'Grapes', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(56, 'Apples', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(57, 'Bananas', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(58, 'Peaches', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(59, 'Pineapple', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(60, 'Mango', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(61, 'Kiwi', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(62, 'Pears', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(63, 'Melons', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(64, 'Papaya', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(65, 'Coconut Milk', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(66, 'Coconut Cream', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(67, 'Soy Milk', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(68, 'Rice', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(69, 'Quinoa', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(70, 'Chia Seeds', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(71, 'Flaxseeds', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(72, 'Hemp Seeds', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(73, 'Sunflower Seeds', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(74, 'Pumpkin Seeds', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(75, 'Yeast', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(76, 'Malt', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(77, 'Cocoa', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(78, 'Chocolate', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(79, 'Coffee', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(80, 'Tea', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(81, 'Cinnamon', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(82, 'Nutmeg', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(83, 'Cloves', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(84, 'Allspice', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(85, 'Cardamom', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(86, 'Black Pepper', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(87, 'White Pepper', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(88, 'Salt', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(89, 'Baking Soda', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(90, 'Baking Powder', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(91, 'Vanilla', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(92, 'Carob', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(93, 'Glycerin', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(94, 'Lecithin', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(95, 'Tapioca', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(96, 'Arrowroot', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(97, 'Sago', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(98, 'Kudzu', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(99, 'Sorghum', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(100, 'Buckwheat', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(101, 'Amaranth', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(102, 'Millet', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(103, 'Teff', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(104, 'Fava Beans', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(105, 'Split Peas', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(106, 'Black-eyed Peas', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(107, 'Lima Beans', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(108, 'Navy Beans', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(109, 'Pinto Beans', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07'),
(110, 'Kidney Beans', 'active', '2024-09-20 07:26:07', '2024-09-20 07:26:07');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int NOT NULL,
  `title` varchar(1000) NOT NULL,
  `image` varchar(100) NOT NULL,
  `carbs` float NOT NULL,
  `proteins` float NOT NULL,
  `fats` float NOT NULL,
  `instructions` text NOT NULL,
  `food_taste` enum('Sweet','Sour','Salty','Bitter') NOT NULL,
  `food_texture` enum('Soft','Crunchy','Creamy','Chewy','Smooth') NOT NULL,
  `cuisine` enum('Indian','Chinese','Italian') NOT NULL,
  `cooking_style` enum('grilled','baked','fry') DEFAULT NULL,
  `spice` enum('Mild','Medium','Spicy','Very spicy') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipe_ingredients`
--

CREATE TABLE `recipe_ingredients` (
  `id` int NOT NULL,
  `recipe_id` int NOT NULL,
  `ingredient_id` int NOT NULL,
  `created_at` timestamp NOT NULL,
  `last_updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `category_id` int NOT NULL,
  `sub_category_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `name`, `description`, `category_id`, `sub_category_id`, `created_at`, `last_updated_at`) VALUES
(1, 'Chicken Curry Cut - Small Pieces', 'Bone-in | Small Cuts | Curry Cut\n', 1, 1, '2024-09-20 04:42:04', '2024-09-20 04:43:43'),
(2, 'Chicken Curry Cut - Large Pieces', 'Bone-in | Large cuts | Curry Cut\n', 1, 1, '2024-09-20 04:42:17', '2024-09-20 04:44:12'),
(3, 'Premium Chicken Leg Curry Cut', 'Bone-in | Medium Pieces | Thigh & Drumstick\n', 1, 1, '2024-09-20 04:42:50', '2024-09-20 04:43:30'),
(4, 'Chicken Curry Cut with Skin - Small Pieces', 'Bone-in | with Skin', 1, 1, '2024-09-20 04:45:42', '2024-09-20 04:45:42'),
(5, 'Chicken Breast - Boneless', 'Fillet | Boneless', 1, 2, '2024-09-20 04:46:07', '2024-09-20 04:46:07');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int NOT NULL,
  `type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `type`, `created_at`, `last_updated_at`) VALUES
(1, 'Curry cuts', '2024-09-19 16:49:48', '2024-09-20 04:33:49'),
(2, 'Boneless', '2024-09-19 16:50:40', '2024-09-20 04:33:51'),
(3, 'Mince', '2024-09-19 16:51:52', '2024-09-20 04:33:54'),
(4, 'Rohu', '2024-09-20 04:31:47', '2024-09-20 04:31:47'),
(5, 'Indian Salmon', '2024-09-20 04:31:58', '2024-09-20 04:31:58'),
(6, 'Classic', '2024-09-20 04:35:28', '2024-09-20 04:41:45'),
(7, 'Quail', '2024-09-20 04:35:33', '2024-09-20 04:41:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `created_at`, `last_updated_at`) VALUES
(1, 'guptasamanta29@gmail.com', '2024-09-20 07:03:13', '2024-09-20 07:03:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_dietary_restrictions`
--

CREATE TABLE `user_dietary_restrictions` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `ingredient_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_dietary_restrictions`
--

INSERT INTO `user_dietary_restrictions` (`id`, `user_id`, `ingredient_id`, `created_at`, `last_updated_at`) VALUES
(1, 1, 2, '2024-09-20 08:19:42', '2024-09-20 08:19:42'),
(2, 1, 3, '2024-09-20 08:19:42', '2024-09-20 08:19:42');

-- --------------------------------------------------------

--
-- Table structure for table `user_preference`
--

CREATE TABLE `user_preference` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `subcategory_id` int DEFAULT NULL,
  `carbs` float DEFAULT NULL,
  `proteins` float DEFAULT NULL,
  `fats` float DEFAULT NULL,
  `cooking_time` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `food_taste` enum('Sweet','Sour','Salty','Bitter') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `food_texture` enum('Soft','Crunchy','Creamy','Chewy','Smooth') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cuisine` enum('Indian','Chinese','Italian') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `spice_tolerance` enum('Mild','Medium','Spicy','Very spicy') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cooking_style` enum('baked','grilled','fry') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_preference`
--

INSERT INTO `user_preference` (`id`, `user_id`, `category_id`, `subcategory_id`, `carbs`, `proteins`, `fats`, `cooking_time`, `food_taste`, `food_texture`, `cuisine`, `spice_tolerance`, `cooking_style`, `created_at`, `last_updated_at`) VALUES
(3, 1, 1, 2, 140, 20, 3, '10', NULL, NULL, 'Indian', 'Medium', 'grilled', '2024-09-20 08:14:51', '2024-09-20 08:14:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carbs` (`carbs`,`proteins`,`fats`,`food_taste`,`food_texture`,`cuisine`,`spice`);

--
-- Indexes for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingredient_id` (`ingredient_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_category_id` (`sub_category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_dietary_restrictions`
--
ALTER TABLE `user_dietary_restrictions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingredient_id` (`ingredient_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_preference`
--
ALTER TABLE `user_preference`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carbs` (`carbs`,`proteins`,`fats`,`food_taste`,`food_texture`,`cuisine`,`spice_tolerance`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_dietary_restrictions`
--
ALTER TABLE `user_dietary_restrictions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_preference`
--
ALTER TABLE `user_preference`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD CONSTRAINT `recipe_ingredients_ibfk_1` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `recipe_ingredients_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_dietary_restrictions`
--
ALTER TABLE `user_dietary_restrictions`
  ADD CONSTRAINT `user_dietary_restrictions_ibfk_1` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_dietary_restrictions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_preference`
--
ALTER TABLE `user_preference`
  ADD CONSTRAINT `user_preference_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

CREATE TABLE `recipe_ratings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `recipe` int NOT NULL,
  `rating` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `recipe` (`recipe`),
  CONSTRAINT `recipe_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `recipe_ratings_ibfk_2` FOREIGN KEY (`recipe`) REFERENCES `recipes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
);

ALTER TABLE `stock` ADD `is_available` TINYINT NOT NULL DEFAULT '1' AFTER `sub_category_id`;
ALTER TABLE `recipes` ADD `category_id` INT NULL AFTER `id`;
ALTER TABLE `recipes` ADD `sub_category_id` INT NULL AFTER `category_id`;
ALTER TABLE `recipes` ADD `cooking_time` INT NULL DEFAULT NULL AFTER `cooking_style`;
ALTER TABLE `recipes` ADD `location` VARCHAR(100) NULL AFTER `cooking_time`;
ALTER TABLE `recipes` ADD `ingredients` TEXT NULL AFTER `location`;

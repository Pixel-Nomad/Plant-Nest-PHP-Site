-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.27-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for plants
CREATE DATABASE IF NOT EXISTS `plants` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `plants`;

-- Dumping structure for table plants.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `plant_id` int(11) NOT NULL DEFAULT 0,
  `Quantity` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cart_id`) USING BTREE,
  KEY `USER` (`user_id`) USING BTREE,
  KEY `Plants` (`plant_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.cart: ~0 rows (approximately)
DELETE FROM `cart`;

-- Dumping structure for table plants.category
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.category: ~6 rows (approximately)
DELETE FROM `category`;
INSERT INTO `category` (`category_id`, `Name`) VALUES
	(1, 'Flowering'),
	(2, 'Non-flowering'),
	(3, 'Indoor'),
	(4, 'Outdoor'),
	(5, 'Succulents'),
	(6, 'Medicinal');

-- Dumping structure for table plants.codes
CREATE TABLE IF NOT EXISTS `codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(50) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.codes: ~0 rows (approximately)
DELETE FROM `codes`;

-- Dumping structure for table plants.feedbacks
CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `Feedback_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `satisfaction` varchar(50) NOT NULL DEFAULT '0',
  `message` longtext NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_3` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.feedbacks: ~1 rows (approximately)
DELETE FROM `feedbacks`;
INSERT INTO `feedbacks` (`id`, `user_id`, `Feedback_Date`, `satisfaction`, `message`) VALUES
	(1, 2, '2023-08-12 23:49:10', 'Neutral', 'test');

-- Dumping structure for table plants.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `order_secret` varchar(50) NOT NULL DEFAULT '0',
  `OrderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `Total_Amount` int(11) NOT NULL DEFAULT 0,
  `Total_Price` int(11) NOT NULL DEFAULT 0,
  `Status` varchar(50) NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`order_id`),
  KEY `USER` (`user_id`),
  KEY `Secret` (`order_secret`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.orders: ~2 rows (approximately)
DELETE FROM `orders`;
INSERT INTO `orders` (`order_id`, `user_id`, `order_secret`, `OrderDate`, `Total_Amount`, `Total_Price`, `Status`) VALUES
	(1, 1, 'LA5B6zIOcV', '2023-08-12 20:06:26', 1, 590, 'Delivered'),
	(2, 2, '4r3gWL9LFe', '2023-08-12 23:51:15', 5, 62894, 'Cancelled');

-- Dumping structure for table plants.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_secret` varchar(50) NOT NULL,
  `plant_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `plant_id` (`plant_id`),
  KEY `secret` (`order_secret`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.order_items: ~6 rows (approximately)
DELETE FROM `order_items`;
INSERT INTO `order_items` (`id`, `order_secret`, `plant_id`, `quantity`) VALUES
	(1, 'LA5B6zIOcV', 9, 1),
	(2, '4r3gWL9LFe', 1, 4),
	(3, '4r3gWL9LFe', 12, 1),
	(4, '4r3gWL9LFe', 16, 1),
	(5, '4r3gWL9LFe', 11, 4),
	(6, '4r3gWL9LFe', 26, 1);

-- Dumping structure for table plants.plants
CREATE TABLE IF NOT EXISTS `plants` (
  `plant_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `description` longtext NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `image` longtext NOT NULL,
  `featured` varchar(5) NOT NULL DEFAULT 'no',
  `category_id` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`plant_id`),
  KEY `Index 2` (`category_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.plants: ~54 rows (approximately)
DELETE FROM `plants`;
INSERT INTO `plants` (`plant_id`, `name`, `description`, `price`, `quantity`, `image`, `featured`, `category_id`) VALUES
	(1, 'Sunflower', 'Sunflower plants are native to North America and are known for their large, bright yellow flowers that resemble the sun.\r\nThey belong to the family Asteraceae and are cultivated for their oil-rich seeds, which are commonly used for cooking oil, bird feed, and other purposes.', 5000, 3, 'https://s3.amazonaws.com/YouGarden/Web/500x500/560541_2.jpg', 'yes', '1'),
	(2, 'Daffodil', 'Narcissus is a genus of predominantly spring flowering perennial plants of the amaryllis family, Amaryllidaceae. Various common names including daffodil,[Note 1] narcissus and jonquil, are used to describe all or some members of the genus. Narcissus has conspicuous flowers with six petal-like tepals surmounted by a cup- or trumpet-shaped corona. The flowers are generally white and yellow (also orange or pink in garden varieties), with either uniform or contrasting coloured tepals and corona.', 5000, 8, 'https://s3.amazonaws.com/YouGarden/Web/500x500/600098_3.jpg', 'yes', '1'),
	(4, 'Marigold', 'Marigold plants (Tagetes spp.) are popular flowering plants known for their vibrant and colorful blooms. They are commonly grown in gardens, landscapes, and even containers due to their ease of cultivation and attractive appearance. Marigolds come in various sizes, shapes, and colors, with shades ranging from yellow and orange to red and even bi-color varieties.', 400, 6, 'https://www.vitri.in/wp-content/uploads/2020/03/marigold1-500x500-1.jpg', 'no', '1'),
	(6, 'Common Daisy', 'A common daisy, scientifically known as Bellis perennis, is a small flowering plant that belongs to the family Asteraceae. It is native to Europe but has been widely naturalized in other regions around the world.', 600, 8, 'https://images.finegardening.com/app/uploads/2018/01/23142030/leucanthemum_x_superbum_becky_mg_1_lg-main-500x500.jpg', 'no', '1'),
	(7, 'Buttercup', 'Buttercup flowers belong to the Ranunculus genus and are known for their bright and cheerful appearance. Here\'s some information about them.Buttercup flowers typically have bright yellow petals that resemble shiny butter, which is how they got their name. They are part of the Ranunculaceae family and come in various species. The flowers have a distinctive cup shape with glossy petals.Buttercup flowers can be found in various regions around the world, including North America, Europe, and Asia. They often thrive in meadows, grasslands, and along streams or wetlands. While buttercup flowers are charming, some species contain compounds that can be harmful to humans and animals if ingested. ', 500, 6, 'https://fleurfarm.com/wp-content/uploads/2021/09/Ranunculus-LaBelle-Buttercup-1.jpg', 'no', '1'),
	(8, 'Summer Lilac', 'Summer lilac is a common name for several plants, but one of the most well-known is the \'Buddleja davidii,\' also known as butterfly bush or orange eye. It\'s a deciduous shrub that produces clusters of fragrant flowers in various colors, including shades of purple, pink, white, and even yellow. The name \'summer lilac\' is often used because the flowers somewhat resemble those of true lilacs and they bloom during the summer months. Summer lilac plants typically have long, arching branches covered in lance-shaped leaves. The flowers are usually clustered at the tips of the branches. Most varieties of summer lilac are hardy in USDA zones 5-9, which covers a wide range of climates. There are numerous cultivars available, each with its own unique flower color and characteristics. Some popular cultivars include \'Black Knight\' (deep purple flowers), \'Royal Red\' (dark red flowers), and \'White Profusion\' (white flowers).', 400, 8, 'https://i.etsystatic.com/27743352/r/il/48913c/4048263262/il_500x500.4048263262_342e.jpg', 'no', '1'),
	(9, 'Rhododendron', 'Rhododendrons are a genus of flowering plants in the heath family (Ericaceae). They are known for their stunning, showy flowers that come in a variety of colors, including pink, purple, red, white, and more. Rhododendrons are popular ornamental shrubs and are often used in gardens and landscapes for their vibrant blooms and attractive foliage. Rhododendron flowers are typically large and trumpet-shaped. They can vary in size, shape, and color depending on the species and cultivar.Rhododendrons are native to various regions around the world, including North America, Europe, and Asia. They often thrive in woodland areas with acidic soil. They generally thrive in dappled or filtered sunlight, avoiding intense afternoon sun. Regular watering is important, especially during dry periods. However, they don\'t like to sit in waterlogged soil.', 500, 6, 'https://s3.amazonaws.com/YouGarden/Web/500x500/510717.jpg', 'no', '1'),
	(10, 'Aster', 'An aster plant, commonly known as an aster, is a flowering plant belonging to the Asteraceae family. Asters are known for their daisy-like flowers and are popular choices for gardeners due to their vibrant colors and late-season blooming, which can add a burst of color to gardens in the fall. Aster plants typically have simple, composite flowers with a central disk surrounded by petals. The petals can come in various colors, including shades of purple, pink, blue, and white. Some well-known species include the New England aster (Symphyotrichum novae-angliae) and the Michaelmas daisy (Aster novi-belgii). Asters generally prefer well-drained soil and full sun, although some species can tolerate partial shade. They are relatively low-maintenance and can thrive in a variety of soil types.Aside from their ornamental value, some aster species have been used for medicinal purposes in traditional herbal medicine.', 600, 7, 'https://h2.commercev3.net/cdn.brecks.com/images/500/06645_5.jpg', 'no', '1'),
	(11, 'soil', 'Soil is the loose surface material that covers most land. It consists of inorganic particles and organic matter. Soil provides the structural support to plants used in agriculture and is also their source of water and nutrients', 12000, 66, 'https://buchanansplants.com/wp-content/uploads/2021/11/iStock-489871228-500x500.jpg', 'yes', '0'),
	(12, 'spades', 'a tool for digging, having an iron blade adapted for pressing into the ground with the foot and a long handle commonly with a grip or crosspiece at the top, and with the blade usually narrower and flatter than that of a shovel. some implement, piece, or part resembling this.', 3900, 86, 'https://5.imimg.com/data5/GK/NM/MY-13001331/garden-spade-500x500.jpg', 'no', '0'),
	(13, 'Epipremnum aureum', 'Epipremnum aureum commonly called golden pothos or devil\'s ivy, is native to the Solomon Islands. \r\nIt is a climbing vine that produces abundant yellow-marbled foliage.\r\n In its native habitat, it climbs tree trunks by aerial rootlets and tumbles along the ground as a ground cover, reaching up to 40\' or more in length.', 7000, 8, 'https://www.provenwinners.com/sites/provenwinners.com/files/imagecache/500x500/ifa_upload/epipremnum_aureum_beautifall_marble_queen_tpc_scene.jpg', 'no', '3'),
	(14, 'PHILODENDRON LEMON', 'The foliage of philodendrons is usually green but may be coppery, red, or purplish; parallel leaf veins are usually green or sometimes red or white.\r\n Shape, size, and texture of the leaves vary considerably, depending on species and maturity of the plant. \r\nThe fruit is a white to orange berry.\r\n', 10000, 11, 'https://static.wixstatic.com/media/e6172c_b6c8606ab4264da18c95b571311b8e9f~mv2.jpg/v1/fit/w_500,h_500,q_90/file.jpg', 'no', '3'),
	(15, 'PRAYER PLANT', 'An evergreen tropical plant commonly grown as a houseplant in temperate climates.\r\nThe Prayer Plant has variegated ovate leaves with entire margins that fold at night to resemble praying hands.\r\nThe undersides of the leaves are gray-green to purple-green. New leaves appear as a rolled tube.', 8000, 7, 'https://gardenerspath.com/wp-content/uploads/2020/12/Calathea-x-Burle.jpg', 'no', '3'),
	(16, 'pesticides', 'Pesticides are chemical compounds used to eliminate pests, like rodents, insects, plants, and fungi. They are used in public health to control vectors of disease, such as mosquitoes, and in agriculture, to prevent damage of harvests by pests (World Health Organization, 2020).', 700, 22, 'https://5.imimg.com/data5/SELLER/Default/2023/6/316236491/JU/MS/OJ/40946500/organic-pesticides-500x500.JPG', 'yes', '0'),
	(17, 'SPIDER PLANT', 'This clump-forming, perennial, herbaceous plant, native to coastal areas of South Africa, has narrow, strap-shaped leaves arising from a central point.\r\n The leaves may be solid green or variegated with lengthwise stripes of white or yellow. The leaves are not flat, but appear channeled or folded down the middle.', 6000, 6, 'https://paudhawala.com/wp-content/uploads/2022/10/2d92b193f5fc5db4b2b5225ba432ad62.jpg', 'no', '3'),
	(18, 'Hand Trowel', 'Pesticides are chemical compounds used to eliminate pests, like rodents, insects, plants, and fungi. They are used in public health to control vectors of disease, such as mosquitoes, and in agriculture, to prevent damage of harvests by pests (World Health Organization, 2020).', 700, 15, 'https://5.imimg.com/data5/FR/OW/MY-67058799/hand-trowel-500x500.jpg', 'no', '0'),
	(19, 'HAWORTHIA PLANT', 'Haworthia tend to have erect or creeping stems from a thick woody root stock and often form small to large groups of plants.\r\n In the wild, these plants grow in very harsh conditions and are commonly found buried in sand. For gardeners, they are easy to grow, preferring a well-draining soil mix.', 70, 9, 'https://sagegarden.ca/cdn/shop/products/HaworthiaEnonNov212020_grande.jpg?v=1606021242', 'no', '3'),
	(20, 'wheelbarrow', 'a small usually single-wheeled vehicle that is used for carrying small loads and is fitted with handles at the rear by which it can be pushed and guided', 1400, 17, 'https://5.imimg.com/data5/BN/NV/MY-3858401/youngman-chillington-wheelbarrow-500x500.jpg', 'no', '0'),
	(21, 'Areca Palm', 'Description. The Areca Palm gets its nickname, the Butterfly Palm, because its long feathery fronds (leaves) arch upwards off of multiple reed like stems. Although the areca palm can grow as high as 30 feet outdoors, in interior locations, it tends to average only 6 to 7 feet.', 8000, 14, 'https://gardenerspath.com/wp-content/uploads/2022/10/Majesty-Palm.jpg', 'no', '3'),
	(22, 'Bird of Paradise', 'Most are distinguished by striking colors and bright plumage of yellow, blue, scarlet, and green. These colors distinguish them as some of the world\'s most dramatic and attractive birds. Males often sport vibrant feathered ruffs or amazingly elongated feathers, which are known as wires or streamers.', 14500, 4, 'https://m.media-amazon.com/images/I/51bHVkmFX9L.jpg', 'no', '3'),
	(23, 'Cat Palm', 'Cat Palm is bushy palm with arching, airy fronds. Native to Mexico, this species can be grown in the understory of other plants outdoors, but is most commonly used as an easy-care houseplant. Arrange Cat Palm amongst broader leaved houseplants for a stylish display.', 8500, 6, 'https://i.etsystatic.com/18139571/r/il/d85c21/3437349935/il_500x500.3437349935_saj3.jpg', 'no', '3'),
	(24, 'Lawn Mower', 'Abstract. A lawn mower is a machine used to mow grass or plants. This machine is commonly used to tidy up the garden and also to clear the fields from grass or other types of grass. The commonly used lawn mowers are made of thin, hard and very sharp iron plates, so they can easily mow the grass.', 2500, 23, 'https://industryparts.pk/cdn/shop/products/BR9432_6985f578-3055-40b5-a7f7-a40f7cbb63ab.jpg?v=1678715835', 'no', '0'),
	(25, 'Corn Plant', 'The corn plant is a tall annual grass with a stout, erect, solid stem. The large narrow leaves have wavy margins and are spaced alternately on opposite sides of the stem.\r\nStaminate (male) flowers are borne on the tassel terminating the main axis of the stem.', 6500, 7, 'https://cdn.shopify.com/s/files/1/0281/1533/7285/products/CornPlant_250x250@2x.jpg?v=1594356954', 'no', '3'),
	(26, 'watering can', 'A watering can (or watering pot) is a portable container, usually with a handle and a funnel, used to water plants by hand. It has been in use since at least A.D. 79 and has since seen many improvements in design. Apart from watering plants, it has varied uses, as it is a fairly versatile tool.', 700, 13, 'https://maxgrowshop.com/eng_pl_Watering-Can-10-L-with-Shower-Head-736_1.jpg', 'no', '0'),
	(27, 'Ferns', 'Ferns are plants that do not have flowers. Ferns generally reproduce by producing spores. Similar to flowering plants, ferns have roots, stems and leaves.', 4500, 5, 'https://search-static.byjusweb.com/question-images/byjus/infinitestudent-images/ckeditor_assets/pictures/660876/original_ferns-plants-500x500.jpg', 'no', '2'),
	(28, 'Crassula Ovata', 'Oblong, fleshy, shiny, evergreen leaves (to 2” long). Leaves may acquire red tints when grown in direct sun. Tiny flowers may appear in spring. Flowers are white to pink, but rarely appear on indoor plants.', 5000, 6, 'https://5.imimg.com/data5/TN/MW/MY-48809865/crassula-ovata-jade-plant-friendship-tree-500x500.jpg', 'yes', '2'),
	(29, 'axe', 'The axe head is typically bounded by the bit (or blade) at one end, and the poll (or butt) at the other, though some designs feature two bits opposite each other. The top corner of the bit where the cutting edge begins is called the toe, and the bottom corner is known as the axe.', 380, 27, 'https://industryparts.pk/cdn/shop/products/IngcoAxe800gmHAX0208008inPakistan.jpg?v=1678715193', 'no', '0'),
	(30, 'Plug plants', 'Plug plants are young plants – either seedlings or cuttings grown in single units in modular trays. This allows for minimum root disturbance when planting / potting on. They are a ready to plant unit, having been professionally nurtured through propagation & early growth stages.', 3000, 4, 'https://babyplants.co.uk/wp-content/uploads/2017/09/p-423-coleus-canina-green-plug-pl.jpg', 'no', '2'),
	(31, 'NEEM TREE', 'neem, (Azadirachta indica), also called nim or margosa, fast-growing tree of the mahogany family (Meliaceae), valued as a medicinal plant, as a source of organic pesticides, and for its timber. Neem is likely native to the Indian subcontinent and to dry areas throughout South Asia.', 1200, 6, 'https://m.media-amazon.com/images/I/61ubgWjZ44L.jpg', 'no', '6'),
	(32, 'Episcia', 'Episcia cupreata has oval, wrinkled, green leaves flecked with copper and purple underneath with orange-red flowers with yellows in the axils; the lobes may be fringed. Flame violet has a definite creeping habit. Genus name comes from the Greek word episkios meaning shaded for the natural habitat of these plants.', 6000, 6, 'https://ashokavanam.com/uploads/product/photo/213/episcia.jpg', 'no', '2'),
	(33, 'ALOE VERA', 'Aloe vera is a popular medicinal plant with antioxidant and antibacterial properties. It may be useful for reducing dental plaque, accelerating wound healing, preventing wrinkles, and managing blood sugar, among other benefits.', 600, 8, 'https://images.squarespace-cdn.com/content/v1/5a639725aeb625e1e36ad85e/1519830452024-PZCURG56FFRJMA5ZDRBI/aloe-vera-plants.jpg', 'no', '6'),
	(34, 'HERBAL MEDICINE PLANT', 'Herbal medicine is the use of plants to treat disease and enhance general health and wellbeing. Herbs can interact with other pharmaceutical medications and should be taken with care.', 5200, 8, 'https://4.imimg.com/data4/IL/IJ/MY-3371336/her-bas13-2-500x500.jpg', 'no', '6'),
	(35, 'Carissa Desert', 'Carissa Desert Star produces glossy rounded leaves and fragrant white star-shaped flowers during spring and summer. Carissa Desert Star is an ideal plant for rockeries, hedging and as a feature plant. Carissa Desert Star grows well in most soil types, in particular well draining soil.', 3000, 7, 'https://www.australianplantsonline.com.au/media/catalog/product/a/p/apo-carissa-closeup.jpg?optimize=medium&bg-color=255,255,255&fit=bounds&height=720&width=720&canvas=720:720', 'no', '2'),
	(36, 'non-grafted cactus', 'A non-grafted cactus refers to a cactus plant that has not undergone the process of grafting. Grafting is a horticultural technique where a cutting or portion of one plant (the scion) is joined onto the rootstock of another plant. This is often done to combine the desirable characteristics of both plants, such as the hardiness of one with the unique appearance of the other.', 10000, 5, 'https://5.imimg.com/data5/ECOM/Default/2023/2/AW/ZZ/GD/5443582/whatsappimage2023-02-10at2-17-57pm-500x500.jpg', 'no', '2'),
	(37, 'akban plant', 'The plant of Aakban has slender appearance, it grows to a height of 2.0 to 2.5 mts. It has light green coloured large leaves. The bloom time is generally November to April. It has beautiful flowers of various colours like white, purple and blue', 6300, 9, 'https://nationalviews.com/wp-content/uploads/2016/04/aakban-plant-medicinal-uses.jpg', 'no', '6'),
	(38, 'capillary thread moss ', 'It grows in tufts or patches, with stems mostly 1 to 3 cm tall. Dry plants usually have corkscrew-like shoots, with leaves spirally twisted around the stem. However, in some populations the dry shoots have leaves that are straight or only slightly twisted.', 5500, 5, 'https://www.heenecemetery.org.uk/wp-content/uploads/2021/02/worthing-heene-non-flowering-plants-capillary-thread-moss-21-february2021-aspect-ratio-500-500.jpg', 'no', '2'),
	(39, 'Hosta', 'Hosta plants are herbaceous perennial plants that belong to the family Asparagaceae.\r\nThey are primarily grown for their lush and vibrant foliage, which comes in a variety of colors, shapes, and sizes.Hosta leaves can be solid, variegated, or even striped, and they range from shades of green to blue, yellow, and white. Hostas thrive in moist, well-draining soil that is rich in organic matter. Keep the soil consistently moist, especially during the growing season. \r\nSupply water regularly to encourage root development.', 500, 8, 'https://www.provenwinners.com/sites/provenwinners.com/files/imagecache/500x500/ifa_upload/hosta_autumn_frost_apj21_2.jpg', 'no', '4'),
	(40, 'Mount Horeb Area', 'It seems like you\'re asking about plants in the Mount Horeb area. Mount Horeb is a village in Wisconsin, USA, known for its Norwegian heritage and scenic beauty. The specific plants you might find in the Mount Horeb area could include a variety of native and ornamental species.', 3200, 6, 'https://chambermaster.blob.core.windows.net/images/customers/3289/members/529/events/6805/EVENT_PHOTO/yarrow_square.png', 'no', '6'),
	(41, 'Begonia', 'Begonias are popular flowering plants that come in a wide variety of colors, sizes, and shapes. \r\nThey are commonly grown for their attractive foliage and vibrant flowers. There are several types of begonias, including fibrous-rooted begonias, tuberous begonias, rhizomatous begonias, and rex begonias. Each type has its unique characteristics and care requirements. Begonias generally prefer bright, indirect light. Some varieties can tolerate more sunlight, while others thrive in shadier conditions. Allow the top inch of soil to dry out between waterings.\r\nWater the plant at the base to avoid getting water on the leaves, which can lead to fungal issues.', 800, 6, 'https://buchanansplants.com/wp-content/uploads/2021/10/Bigreg-Red-Green-Leaf-Begonia-500x500.jpg', 'no', '4'),
	(42, 'Variegated Ajwain Plant', 'The ajwain plant is must having plant for your kitchen or home garden. Growing of ajwain plant is very easy and it has multiple uses. This plant does not require much care. Even a window light is sufficient to grow ajwain and this also helps to solve health problems.', 5500, 10, 'https://gachwala.in/wp-content/uploads/2022/06/51Yuh4E1nL.jpg', 'no', '6'),
	(43, 'KACHNAR', 'Kachnar is a deciduous tree of small to medium sized height up to 15mt with spreading crown and a short bole. Twigs of the tree are slender, light green, angled, hairy and brownish grey in color.', 4700, 9, 'https://i0.wp.com/plant.pk/wp-content/uploads/2020/02/bauhinia-Buy-Plants-Online-Plant.Pk_.jpg?fit=500%2C500&ssl=1', 'no', '6'),
	(44, 'Daylily', 'Daylilies (Hemerocallis) are popular perennial flowering plants known for their vibrant and colorful blossoms. \r\nThey belong to the family Hemerocallidaceae and are native to Asia. Daylilies are herbaceous plants that typically produce clumps of long, linear leaves that emerge from the base. \r\nThe flowers are trumpet-shaped and come in a wide range of colors, including shades of yellow, orange, red, pink, and even near-white. \r\nEach flower typically lasts for only one day, hence the name \'daylily.\'\r\nSome popular varieties include \'Stella de Oro\' (golden-yellow flowers), \'Happy Returns\' (pale yellow flowers) and \'Rosy Returns\' (pink flowers).', 2000, 9, 'https://www.brecksbulbs.ca/images/500/86873.jpg', 'no', '4'),
	(45, 'Agave', 'Agave plants are a group of succulent plants primarily native to the Americas, particularly in the southwestern United States and Mexico. \r\nThey are well-known for their distinctive rosette-shaped leaves, often ending in a sharp point, and their ability to thrive in arid and dry conditions. \r\nSome common species include Agave americana (Century Plant), Agave tequilana (Blue Agave), and Agave victoriae-reginae (Queen Victoria Agave).\r\nAgave plants have various uses. The sap or juice extracted from certain species, particularly the Blue Agave, is used to make beverages like tequila and mezcal. \r\nThe fibers from the leaves can be used to make ropes, baskets, and mats.', 700, 7, 'https://images-static.nykaa.com/media/catalog/product/3/2/327c1018907895073213_1.jpg?tr=w-500,pr-true', 'no', '4'),
	(46, 'Shrub', 'Shrub plants are woody plants that are typically smaller than trees and have multiple stems arising from the base. \r\nThey are commonly used in landscaping and gardening for their decorative and functional purposes. \r\nExamples of popular shrubs include roses, azaleas, hydrangeas, boxwoods, and lilacs. \r\nWhen planting shrubs,it\'s important to consider factors such as soil type, sunlight requirements, and climate conditions. ', 1500, 10, 'https://www.gardendesign.com/pictures/images/400x400Exact_16x0/dream-team-s-portland-garden_6/double-doozie-spirea-spirea-shrub-proven-winners_17570.jpg', 'no', '4'),
	(48, 'Grasses', 'Grasses are a type of flowering plant that belongs to the Poaceae family. They are characterized by their long, narrow leaves and hollow stems. \r\nGrasses are incredibly diverse and can be found in a wide range of environments, from lawns and meadows to savannas and prairies. \r\nGrasses are of immense economic importance. Many of the world\'s major food crops are grasses, such as rice, wheat, corn (maize), oats, and barley. \r\nThese crops provide a significant portion of the global human diet. Many grass species are commonly used in landscaping and gardening for their aesthetic appeal. \r\nOrnamental grasses come in various sizes, colors, and textures, adding beauty and interest to gardens.', 2000, 6, 'https://s3.amazonaws.com/YouGarden/Web/500x500/560214_2.jpg', 'no', '4'),
	(49, 'Chrysanthemums', 'Chrysanthemums are composite flowers that grow in varying petal arrangements, with some types having a daisy-like structure, others having a rounder, \r\npompom-like appearance, and even some blooms with quill-like petals. \r\nThe blossoms also have varying hues, from white and light yellow to deep burgundies and purples.', 1600, 5, 'https://3.imimg.com/data3/AQ/OV/MY-9356266/chrysanthemum-plant-500x500.jpg', 'no', '4'),
	(50, 'Dracaena ', 'The dracaena plant is a popular ornamental houseplant, grown both indoors and outdoors in subtropical climates. \r\nIt reaches a height of about three feet indoors, and has a bushy tree type of look. \r\nIts glossy leaves can grow up to one foot long and a couple of inches wide.', 1800, 10, 'https://cdn11.bigcommerce.com/s-jmzfi5zcr2/products/5878/images/18478/Healthy_Malaika_Dracaena___85021.1664309172.500.750.png?c=2', 'no', '4'),
	(51, '2 inch Succulent plant', 'These 2-inch succulents are the perfect size for a variety of uses.\r\nWhether you want to plant them indoors or outside, they\'re easy to care for and will brighten up any space! These succulents are rooted in 2inch nursery pots but the actual size of your succulents will vary based on their specific growth habits.	', 4500, 5, 'https://cdn11.bigcommerce.com/s-k9bxvmpetf/images/stencil/500x500/products/113/463/20220629032821_file_62bc6f9582bed_62bc71278d48c__59636__78898.1661976671.jpg?c=1', 'no', '5'),
	(52, 'Succulent GATHERING ', 'By definition, succulent plants are drought-resistant plants in which the leaves, stem, or roots have become more than usually fleshy by the development of water-storing tissue. Other sources exclude roots as in the definition \'a plant with thick, fleshy and swollen stems and/or leaves, adapted to dry environments\'.', 3500, 4, 'https://redsquareflowers.com/wp-content/uploads/2017/01/succulent-garden-e1550859763627.jpg', 'no', '5'),
	(53, '2.0 Succulent Pot', 'succulent, any plant with thick fleshy tissues adapted to water storage. Some succulents (e.g., cacti) store water only in the stem and have no leaves or very small leaves, whereas others (e.g., agaves) store water mainly in the leaves.', 5500, 6, 'https://houseplantwest.com/cdn/shop/products/2_Succulents_5PACK2_1_500x500.jpg?v=1638394257', 'no', '5'),
	(54, 'Flowering Succulents', 'Their pretty rosettes may be a solid color or variegated in green, red, white, and yellow. \r\nThey produce clusters of small star-like flowers that emerge from the rosette centers. These are relatively slow-growing plants and may take up to five years before they produce the little bunches of flowers', 4500, 3, 'https://balconygardenweb.b-cdn.net/wp-content/uploads/2018/12/Christmas-Cactus.jpg', 'no', '5'),
	(55, 'green hawothia', 'Haworthia herbacea is a slow growing succulent featuring yellowish-green foliage with firm, hairy spines and glassy white edges. Pointed leaves curve upwards in a dense rosette that is low to the ground. It will bloom in summer with creamy-white flowers with pink tips.', 8500, 7, 'https://5.imimg.com/data5/SELLER/Default/2022/9/WT/KF/RL/21357291/haworthia-zebra-cactus-indoor-plant-500x500.jpg', 'no', '5'),
	(56, 'northern california', 'Nothern California Plant is a succulent plant known by the common name Abrams\' liveforever. It is native to California and northern Baja California, where it grows in rocky areas in a number of habitat types. It is a fleshy perennial forming a small basal cluster of leaves around a central caudex.', 7000, 10, 'https://images.finegardening.com/app/uploads/2019/07/09132201/Succulent-pot-by-fionuala-campion-thumb-1x1.jpg', 'no', '5'),
	(57, 'Large Succulent Garden', 'This plants have thickened stems, or leaves, such as this Aloe. Succulent plants may store water in various structures, such as leaves and stems. The water content of some succulent organs can get up to 90–95%, such as Glottiphyllum semicyllindricum and Mesembryanthemum barkleyii.', 6500, 5, 'https://cathycowgillflowers.com/media/catalog/product/cache/d9f0292d056786776dd2d4498ea9708f/g/r/gray-bowl-silk-succulents.jpg', 'no', '5');

-- Dumping structure for table plants.reviews
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plant_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `Review_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `stars` int(11) NOT NULL DEFAULT 0,
  `review` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.reviews: ~1 rows (approximately)
DELETE FROM `reviews`;
INSERT INTO `reviews` (`id`, `plant_id`, `user_id`, `Review_Date`, `stars`, `review`) VALUES
	(1, 1, 2, '2023-08-12 23:51:45', 5, 'Nice Flower');

-- Dumping structure for table plants.sliders
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` longtext NOT NULL,
  `text` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `dark` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.sliders: ~3 rows (approximately)
DELETE FROM `sliders`;
INSERT INTO `sliders` (`id`, `image`, `text`, `description`, `dark`) VALUES
	(6, 'https://w0.peakpx.com/wallpaper/782/398/HD-wallpaper-green-leaves-in-blur-green-background-nature.jpg', 'Green Leaves', ' ', 'no'),
	(7, 'https://w0.peakpx.com/wallpaper/54/973/HD-wallpaper-green-leaves-tree-branch-in-blur-green-bokeh-background-nature.jpg', 'Green Leaves', ' ', 'no'),
	(8, 'https://images.wallpaperscraft.com/image/single/leaves_dark_plant_128531_1280x720.jpg', 'more leaves', ' ', 'no');

-- Dumping structure for table plants.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL DEFAULT '',
  `company` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(50) NOT NULL DEFAULT '',
  `country` varchar(50) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.users: ~2 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`user_id`, `username`, `fullname`, `email`, `contact`, `company`, `address`, `country`, `city`, `password`, `role`, `date`) VALUES
	(1, 'masterAccount', 'Tayyab Naseem', 'mr.tgamer247797703@gmail.com', '00000000000', 'aptech', 'address 1', 'PK', 'Karachi', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'master', '2023-08-12 23:59:25'),
	(2, '9dgamer123', 'Tayyab Naseem', 'mr.tgamer247797704@gmail.com', '03123456789', 'aptech', 'address 1', 'PK', 'Karachi', 'bc53b5813c49642762c251319405523e399e6176', 'user', '2023-08-13 00:00:45');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

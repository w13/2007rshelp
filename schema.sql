-- 2007rshelp.com MySQL Schema
-- Generated based on codebase analysis

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--
CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `text` longtext,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quests`
--
CREATE TABLE IF NOT EXISTS `quests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` tinyint(1) DEFAULT '0',
  `reward` text,
  `difficulty` int(11) DEFAULT '0',
  `length` int(11) DEFAULT '0',
  `text` longtext,
  `author` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` int(11) DEFAULT '0',
  `member` tinyint(1) DEFAULT '0',
  `equip` tinyint(1) DEFAULT '0',
  `trade` tinyint(1) DEFAULT '0',
  `stack` tinyint(1) DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `quest` text,
  `weight` decimal(10,3) DEFAULT '0.000',
  `examine` text,
  `lowalch` int(11) DEFAULT '0',
  `highalch` int(11) DEFAULT '0',
  `sellgen` int(11) DEFAULT '0',
  `buygen` int(11) DEFAULT '0',
  `att` varchar(255) DEFAULT NULL,
  `def` varchar(255) DEFAULT NULL,
  `otherb` varchar(255) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `obtain` text,
  `notes` text,
  `credits` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `complete` tinyint(1) DEFAULT '0',
  `pid` int(11) DEFAULT '0',
  `equip_type` int(11) DEFAULT '-1',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `monsters`
--
CREATE TABLE IF NOT EXISTS `monsters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `combat` int(11) DEFAULT '0',
  `hp` int(11) DEFAULT '0',
  `maxhit` int(11) DEFAULT '0',
  `race` varchar(255) DEFAULT NULL,
  `member` tinyint(1) DEFAULT '0',
  `quest` varchar(255) DEFAULT NULL,
  `nature` varchar(255) DEFAULT NULL,
  `attstyle` varchar(255) DEFAULT NULL,
  `examine` text,
  `locations` text,
  `drops` text,
  `i_drops` text,
  `tactic` text,
  `notes` text,
  `credits` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `npc` tinyint(1) DEFAULT '1',
  `img` varchar(255) DEFAULT 'nopic.gif',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `combat` (`combat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--
CREATE TABLE IF NOT EXISTS `shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `member` varchar(50) DEFAULT NULL,
  `shopkeeper` varchar(255) DEFAULT NULL,
  `notes` text,
  `image` varchar(255) DEFAULT NULL,
  `use_stock` tinyint(1) DEFAULT '0',
  `credits` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `shops_items`
--
CREATE TABLE IF NOT EXISTS `shops_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` int(11) DEFAULT '0',
  `item_currency` varchar(50) DEFAULT 'gp',
  `item_stock` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`),
  KEY `item_name` (`item_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--
CREATE TABLE IF NOT EXISTS `stats` (
  `Time` int(11) NOT NULL,
  `User` varchar(12) NOT NULL,
  -- Each skill has r (rank), l (level), x (xp)
  `Overallr` bigint(20) DEFAULT '-1', `Overalll` int(11) DEFAULT '1', `Overallx` bigint(20) DEFAULT '0',
  `Attackr` bigint(20) DEFAULT '-1', `Attackl` int(11) DEFAULT '1', `Attackx` bigint(20) DEFAULT '0',
  `Defencer` bigint(20) DEFAULT '-1', `Defencel` int(11) DEFAULT '1', `Defencex` bigint(20) DEFAULT '0',
  `Strengthr` bigint(20) DEFAULT '-1', `Strengthl` int(11) DEFAULT '1', `Strengthx` bigint(20) DEFAULT '0',
  `Hitpointsr` bigint(20) DEFAULT '-1', `Hitpointsl` int(11) DEFAULT '10', `Hitpointsx` bigint(20) DEFAULT '0',
  `Rangedr` bigint(20) DEFAULT '-1', `Rangedl` int(11) DEFAULT '1', `Rangedx` bigint(20) DEFAULT '0',
  `Prayerr` bigint(20) DEFAULT '-1', `Prayerl` int(11) DEFAULT '1', `Prayerx` bigint(20) DEFAULT '0',
  `Magicr` bigint(20) DEFAULT '-1', `Magicl` int(11) DEFAULT '1', `Magicx` bigint(20) DEFAULT '0',
  `Cookingr` bigint(20) DEFAULT '-1', `Cookingl` int(11) DEFAULT '1', `Cookingx` bigint(20) DEFAULT '0',
  `Woodcuttingr` bigint(20) DEFAULT '-1', `Woodcuttingl` int(11) DEFAULT '1', `Woodcuttingx` bigint(20) DEFAULT '0',
  `Fletchingr` bigint(20) DEFAULT '-1', `Fletchingl` int(11) DEFAULT '1', `Fletchingx` bigint(20) DEFAULT '0',
  `Fishingr` bigint(20) DEFAULT '-1', `Fishingl` int(11) DEFAULT '1', `Fishingx` bigint(20) DEFAULT '0',
  `Firemakingr` bigint(20) DEFAULT '-1', `Firemakingl` int(11) DEFAULT '1', `Firemakingx` bigint(20) DEFAULT '0',
  `Craftingr` bigint(20) DEFAULT '-1', `Craftingl` int(11) DEFAULT '1', `Craftingx` bigint(20) DEFAULT '0',
  `Smithingr` bigint(20) DEFAULT '-1', `Smithingl` int(11) DEFAULT '1', `Smithingx` bigint(20) DEFAULT '0',
  `Miningr` bigint(20) DEFAULT '-1', `Miningl` int(11) DEFAULT '1', `Miningx` bigint(20) DEFAULT '0',
  `Herblorer` bigint(20) DEFAULT '-1', `Herblorel` int(11) DEFAULT '1', `Herblorex` bigint(20) DEFAULT '0',
  `Agilityr` bigint(20) DEFAULT '-1', `Agilityl` int(11) DEFAULT '1', `Agilityx` bigint(20) DEFAULT '0',
  `Thievingr` bigint(20) DEFAULT '-1', `Thievingl` int(11) DEFAULT '1', `Thievingx` bigint(20) DEFAULT '0',
  `Slayerr` bigint(20) DEFAULT '-1', `Slayerl` int(11) DEFAULT '1', `Slayerx` bigint(20) DEFAULT '0',
  `Farmingr` bigint(20) DEFAULT '-1', `Farmingl` int(11) DEFAULT '1', `Farmingx` bigint(20) DEFAULT '0',
  `Runecraftr` bigint(20) DEFAULT '-1', `Runecraftl` int(11) DEFAULT '1', `Runecraftx` bigint(20) DEFAULT '0',
  `Hunterr` bigint(20) DEFAULT '-1', `Hunterl` int(11) DEFAULT '1', `Hunterx` bigint(20) DEFAULT '0',
  `Constructionr` bigint(20) DEFAULT '-1', `Constructionl` int(11) DEFAULT '1', `Constructionx` bigint(20) DEFAULT '0',
  -- Optional historical/misc fields mentioned in legacy code
  `Summoningr` bigint(20) DEFAULT '-1', `Summoningl` int(11) DEFAULT '1', `Summoningx` bigint(20) DEFAULT '0',
  PRIMARY KEY (`Time`,`User`),
  KEY `User` (`User`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quests_ip`
--
CREATE TABLE IF NOT EXISTS `quests_ip` (
  `id` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `hidden_id` text,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `price_items`
--
CREATE TABLE IF NOT EXISTS `price_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price_low` int(11) DEFAULT '0',
  `price_high` int(11) DEFAULT '0',
  `jagex_pid` int(11) DEFAULT '0',
  `phold_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `calc_info`
--
CREATE TABLE IF NOT EXISTS `calc_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calc_name` varchar(50) NOT NULL,
  `calc_type` varchar(50) DEFAULT NULL,
  `level` int(11) DEFAULT '1',
  `xp` decimal(10,2) DEFAULT '0.00',
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `member` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `calc_name` (`calc_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `price_groups`
--
CREATE TABLE IF NOT EXISTS `price_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `parent` int(11) DEFAULT '0',
  `items` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`id`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Generic tables for guides (misc, minigames, guilds, dungeonmaps, miningmaps, tomes)
--
CREATE TABLE IF NOT EXISTS `misc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `text` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `minigames` LIKE `misc`;
CREATE TABLE IF NOT EXISTS `guilds` LIKE `misc`;
CREATE TABLE IF NOT EXISTS `dungeonmaps` LIKE `misc`;
CREATE TABLE IF NOT EXISTS `miningmaps` LIKE `misc`;
CREATE TABLE IF NOT EXISTS `tomes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `content` longtext,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

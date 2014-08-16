
DROP TABLE IF EXISTS `alibaba_op`;
CREATE TABLE `alibaba_op` (
  `op_name` varchar(200) NOT NULL,
  `op_value` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`op_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` bigint(20) NOT NULL COMMENT 'Category Id',
  `parent_id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Parent Category ID',
  `class_id` varchar(255) NOT NULL DEFAULT '' COMMENT 'Tree Path',
  `child_count` int(11) NOT NULL DEFAULT '0' COMMENT 'Child Count',
  `category_url` varchar(255) NOT NULL DEFAULT '' COMMENT 'Category Url',
  `category_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Category Name',
  `category_image` varchar(255) NOT NULL DEFAULT '' COMMENT 'Category Image',
  `meta_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Meta Title',
  `meta_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'Meta keywords',
  `meta_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'Meta Description',
  `sort_order` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Sort Order',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Added Date',
  `date_modified` datetime NOT NULL DEFAULT '2013-01-01 00:00:00' COMMENT 'Last Modified Date',
  `date_available` datetime NOT NULL DEFAULT '2013-01-01 00:00:00' COMMENT 'Available Date',
  `data_states` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Data States',
  PRIMARY KEY (`id`),
  KEY `IDX_CATEGORY_PARENT_ID_ID` (`parent_id`,`id`),
  KEY `IDX_CATEGORY_SORT_ORDER` (`sort_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `license`;
CREATE TABLE `license` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(64) NOT NULL DEFAULT '',
  `project_key` varchar(128) NOT NULL DEFAULT '',
  `project_version` varchar(16) NOT NULL DEFAULT '',
  `project_patch` varchar(255) NOT NULL DEFAULT '',
  `project_patch_source` varchar(255) NOT NULL DEFAULT '',
  `project_comment` varchar(250) NOT NULL DEFAULT '',
  `license_company` varchar(255) NOT NULL DEFAULT '',
  `license_type` varchar(32) NOT NULL DEFAULT '',
  `date_start` datetime NOT NULL DEFAULT '2013-01-01 00:00:00' COMMENT 'Start Date',
  `date_end` datetime NOT NULL DEFAULT '2013-01-01 00:00:00' COMMENT 'End Date',
  `data_states` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Data States',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNQ_PROJECT_LICENSE_PROJECT_KEY` (`project_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` bigint(20) NOT NULL COMMENT 'Product Id',
  `product_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Product Name',
  `product_url` varchar(255) NOT NULL DEFAULT '' COMMENT 'Product Url',
  `category_id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'categories id',
  `product_image` varchar(255) NOT NULL DEFAULT '' COMMENT 'Product Image',
  `product_quantity` float NOT NULL DEFAULT '0' COMMENT 'Product Quantity',
  `product_model` varchar(255) NOT NULL DEFAULT '' COMMENT 'Product SKU',
  `product_price` decimal(15,4) NOT NULL DEFAULT '0.0000' COMMENT 'product price',
  `product_a_price` decimal(15,4) NOT NULL DEFAULT '0.0000' COMMENT 'product group a price',
  `product_b_price` decimal(15,4) NOT NULL DEFAULT '0.0000' COMMENT 'product group b price',
  `product_c_price` decimal(15,4) NOT NULL DEFAULT '0.0000' COMMENT 'product group c price',
  `product_d_price` decimal(15,4) NOT NULL DEFAULT '0.0000' COMMENT 'product group d price',
  `product_discount` int(11) NOT NULL DEFAULT '0' COMMENT 'product discount',
  `product_size` varchar(255) NOT NULL DEFAULT '' COMMENT 'Product Size',
  `product_color` varchar(255) NOT NULL DEFAULT '' COMMENT 'Product Color',
  `product_rate` int(11) NOT NULL DEFAULT '1' COMMENT 'Product Rate',
  `product_feedback` int(11) NOT NULL DEFAULT '1' COMMENT 'Product Feedback',
  `meta_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Meta Title',
  `meta_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'Meta keywords',
  `meta_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'Meta Description',
  `product_specifics` text COMMENT 'Product Specifics',
  `Product_description` text COMMENT 'Product Description',
  `product_packaging` text COMMENT 'Packaging Details',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Added Date',
  `date_modified` datetime NOT NULL DEFAULT '2013-01-01 00:00:00' COMMENT 'Last Modified Date',
  `date_available` datetime NOT NULL DEFAULT '2013-01-01 00:00:00' COMMENT 'Available Date',
  `sort_order` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Sort Order',
  `data_states` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Data States',
  PRIMARY KEY (`id`),
  KEY `IDX_PRODUCT_MODEL` (`product_model`),
  KEY `IDX_PRODUCT_PRICE` (`product_price`),
  KEY `IDX_CATEGORY_ID` (`category_id`),
  KEY `IDX_PRODUCT_SORT_ORDER` (`sort_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `store`;
CREATE TABLE `store` (
  `id` bigint(20) NOT NULL COMMENT 'Store Id',
  `store_url` varchar(255) NOT NULL DEFAULT '' COMMENT 'Store Url',
  `store_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Store Name',
  `store_score` int(11) NOT NULL DEFAULT '0' COMMENT 'Store Score',
  `memberid` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Member Id',
  `meta_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Meta Title',
  `meta_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'Meta keywords',
  `meta_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'Meta Description',
  `data_states` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Data States',
  PRIMARY KEY (`id`),
  KEY `IDX_STORE_STORE_NAME` (`store_name`),
  KEY `IDX_STORE_MEMBER_ID` (`memberid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` bigint(20) NOT NULL,
  `task_type` int(11) NOT NULL DEFAULT '0',
  `data_states` int(11) NOT NULL DEFAULT '0',
  `task_url` tinytext NOT NULL,
  `last_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `IDX_TASK_TASK_TYPE_ITEM_ID` (`task_type`,`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

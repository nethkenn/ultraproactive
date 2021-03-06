/*
	-- Adminer 4.2.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

INSERT INTO `rel_product_type` (`product_id`, `product_type_id`) VALUES
(64,	7),
(63,	7),
(62,	7),
(61,	7),
(60,	7),
(59,	6),
(58,	6),
(57,	6),
(56,	6),
(55,	6),
(54,	6),
(53,	6),
(52,	6),
(51,	5),
(50,	5),
(49,	5),
(48,	5),
(47,	5),
(46,	5),
(45,	5),
(44,	5),
(43,	5),
(42,	5),
(41,	5),
(40,	5),
(39,	5),
(38,	5),
(37,	5),
(36,	5),
(35,	5),
(34,	5),
(33,	5),
(31,	4),
(30,	4),
(28,	1),
(27,	1),
(26,	1),
(25,	1),
(24,	1),
(23,	3),
(22,	3),
(21,	3),
(20,	2),
(19,	2),
(18,	2),
(17,	2),
(16,	2),
(15,	4),
(14,	4),
(13,	4),
(12,	4),
(11,	4),
(10,	4),
(9,	4),
(8,	4),
(7,	4),
(6,	4),
(5,	4),
(4,	4),
(3,	4),
(2,	4),
(1,	4);








INSERT INTO `tbl_product` (`product_id`, `product_name`, `product_description`, `product_detail`, `product_tags`, `product_main_image`, `product_images`, `product_brand_id`, `product_active`, `product_featured`, `product_collection`, `product_rating`, `product_views`, `created_at`) VALUES
(1,	'Rutsen Ballpen A',	'',	'',	'Rutsen Ballpen A',	'1431101867.jpg',	'',	2,	1,	0,	2,	0,	0,	'0000-00-00 00:00:00'),
(2,	'Rutsen Ballpen B',	'',	'',	'Rutsen Ballpen B',	'1431101873.jpg',	'',	2,	1,	0,	2,	0,	0,	'0000-00-00 00:00:00'),
(3,	'Rutsen Ballpen C',	'',	'',	'Rutsen Ballpen C',	'1431101878.jpg',	'',	2,	1,	0,	2,	0,	0,	'0000-00-00 00:00:00'),
(4,	'Rutsen Ballpen D',	'',	'',	'Rutsen Ballpen D',	'1431101884.jpg',	'',	2,	1,	0,	2,	0,	0,	'0000-00-00 00:00:00'),
(5,	'Rutsen Ballpen E',	'',	'',	'Rutsen Ballpen E',	'1431101895.jpg',	'',	2,	1,	0,	2,	0,	0,	'0000-00-00 00:00:00'),
(6,	'Rutsen Ballpen F',	'',	'',	'Rutsen Ballpen F',	'1431101901.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(7,	'Rutsen Ballpen G',	'',	'',	'Rutsen Ballpen G',	'1431101906.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(8,	'Rutsen Ballpen H',	'',	'',	'Rutsen Ballpen H',	'1431101914.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(9,	'Rutsen Ballpen I',	'',	'',	'Rutsen Ballpen I',	'1431101920.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(10,	'Rutsen Ballpen J',	'',	'',	'Rutsen Ballpen J',	'1431101926.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(11,	'Rutsen Ballpen K',	'',	'',	'Rutsen Ballpen K',	'1431101931.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(12,	'Rutsen Ballpen L',	'',	'',	'Rutsen Ballpen L',	'1431101938.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(13,	'Rutsen Ballpen M',	'',	'',	'Rutsen Ballpen M',	'1431101945.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(14,	'Rutsen Ballpen N',	'',	'',	'Rutsen Ballpen N',	'1431101959.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(15,	'Rutsen Ballpen O',	'',	'',	'Rutsen Ballpen O',	'1431101867.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(16,	'Rutsen Cap A',	'',	'',	'Rutsen Cap A',	'1431101999.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(17,	'Rutsen Cap B',	'',	'',	'Rutsen Cap A',	'1431102011.jpg',	'',	2,	1,	0,	30,	0,	0,	'0000-00-00 00:00:00'),
(18,	'Rutsen Cap C',	'',	'',	'Rutsen Cap C',	'1431102025.jpg',	'',	2,	1,	0,	2,	0,	0,	'0000-00-00 00:00:00'),
(19,	'Rutsen Cap D',	'',	'',	'Rutsen Cap D',	'1431102035.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(20,	'Rutsen Cap E',	'',	'',	'Rutsen Cap E',	'1431102051.jpg',	'',	2,	1,	0,	30,	0,	0,	'0000-00-00 00:00:00'),
(21,	'Rutsen Cup A',	'',	'',	'Rutsen Cup A',	'1431102078.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(22,	'Rutsen Cup B',	'',	'',	'Rutsen Cup B',	'1431102090.jpg',	'',	2,	1,	0,	30,	0,	0,	'0000-00-00 00:00:00'),
(23,	'Rutsen Cup C',	'',	'',	'Rutsen Cup C',	'1431102105.jpg',	'',	2,	1,	0,	30,	0,	0,	'0000-00-00 00:00:00'),
(24,	'Rutsen Jacket A',	'',	'',	'Rutsen Jacket A',	'1431102132.jpg',	'',	2,	1,	0,	2,	0,	0,	'0000-00-00 00:00:00'),
(25,	'Rutsen Jacket B',	'',	'',	'Rutsen Jacket B',	'1431102156.jpg',	'',	2,	1,	1,	2,	0,	0,	'0000-00-00 00:00:00'),
(26,	'Rutsen Jacket C',	'',	'',	'Rutsen Jacket B',	'1431102179.jpg',	'',	2,	1,	1,	30,	0,	0,	'0000-00-00 00:00:00'),
(27,	'Rutsen Jacket D',	'',	'',	'Rutsen Jacket D',	'1431102195.jpg',	'',	2,	1,	1,	30,	0,	0,	'0000-00-00 00:00:00'),
(28,	'Rutsen Jacket E',	'',	'',	'Rutsen Jacket D',	'1431102216.jpg',	'',	2,	1,	1,	30,	0,	0,	'0000-00-00 00:00:00'),
(29,	'Rutsen Wallet',	'',	'',	'Rutsen Wallet',	'1431102269.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(30,	'Pen with Pen Holder',	'',	'',	'Pen with Pen Holder',	'1431102276.jpg',	'',	2,	1,	0,	30,	0,	0,	'0000-00-00 00:00:00'),
(31,	'Rutsen Pens',	'',	'',	'Rutsen Pens',	'1431102284.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(32,	'Rutsen Booklet',	'',	'',	'Rutsen Booklet',	'1431102296.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(33,	'Rutsen Polo Shirt A',	'',	'',	'Rutsen Jacket D',	'1431102332.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(34,	'Rutsen Polo Shirt B',	'',	'',	'Rutsen Polo Shirt B',	'1431102355.jpg',	'',	2,	1,	0,	30,	0,	0,	'0000-00-00 00:00:00'),
(35,	'Rutsen Polo Shirt C',	'',	'',	'Rutsen Polo Shirt C',	'1431102376.jpg',	'',	2,	1,	0,	1,	0,	0,	'0000-00-00 00:00:00'),
(36,	'Rutsen Polo Shirt D',	'',	'',	'Rutsen Polo Shirt D',	'1431102394.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(37,	'Rutsen Polo Shirt E',	'',	'',	'Rutsen Polo Shirt E',	'1431102415.jpg',	'',	2,	1,	0,	1,	0,	0,	'0000-00-00 00:00:00'),
(38,	'Rutsen Polo Shirt F',	'',	'',	'Rutsen Polo Shirt F',	'1431102431.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(39,	'Rutsen Polo Shirt G',	'',	'',	'Rutsen Polo Shirt G',	'1431102447.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(40,	'Rutsen Polo Shirt H',	'',	'',	'Rutsen Polo Shirt H',	'1431102466.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(41,	'Rutsen Polo Shirt I',	'',	'',	'Rutsen Polo Shirt I',	'1431102482.jpg',	'',	2,	1,	0,	1,	0,	0,	'0000-00-00 00:00:00'),
(42,	'Rutsen Polo Shirt J',	'',	'',	'Rutsen Polo Shirt J',	'1431102496.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(43,	'Rutsen Polo Shirt K',	'',	'',	'Rutsen Polo Shirt K',	'1431102516.jpg',	'',	2,	1,	0,	1,	0,	0,	'0000-00-00 00:00:00'),
(44,	'Rutsen Polo Shirt L',	'',	'',	'Rutsen Polo Shirt L',	'1431102530.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(45,	'Rutsen Polo Shirt M',	'',	'',	'Rutsen Polo Shirt M',	'1431102549.jpg',	'',	2,	1,	0,	1,	0,	0,	'0000-00-00 00:00:00'),
(46,	'Rutsen Polo Shirt N',	'',	'',	'Rutsen Polo Shirt N',	'1431102565.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(47,	'Rutsen Polo Shirt O',	'',	'',	'Rutsen Polo Shirt O',	'1431102355.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(48,	'Rutsen Polo Shirt P',	'',	'',	'Rutsen Polo Shirt B',	'1431102578.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(49,	'Rutsen Polo Shirt Q',	'',	'',	'Rutsen Polo Shirt Q',	'1431102592.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(50,	'Rutsen Polo Shirt R',	'',	'',	'Rutsen Polo Shirt R',	'1431102611.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(51,	'Rutsen Polo Shirt S',	'',	'',	'Rutsen Polo Shirt S',	'1431102631.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(52,	'Rutsen Shirt A',	'',	'',	'Rutsen Shirt A',	'1431102711.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(53,	'Rutsen Shirt B',	'',	'',	'Rutsen Shirt B',	'1431102964.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(54,	'Rutsen Shirt C',	'',	'',	'Rutsen Shirt C',	'1431102977.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(55,	'Rutsen Shirt E',	'',	'',	'Rutsen Shirt E',	'1431102992.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(56,	'Rutsen Shirt F',	'',	'',	'Rutsen Shirt F',	'1431103006.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(57,	'Rutsen Shirt G',	'',	'',	'Rutsen Shirt G',	'1431103024.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(58,	'Rutsen Shirt H',	'',	'',	'Rutsen Shirt H',	'1431103035.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(59,	'Rutsen Shirt I',	'',	'',	'Rutsen Shirt I',	'1431103047.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(60,	'Rutsen Umbrella A',	'',	'',	'Rutsen Umbrella A',	'1431103070.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(61,	'Rutsen Umbrella B',	'',	'',	'Rutsen Umbrella B',	'1431103080.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(62,	'Rutsen Umbrella C',	'',	'',	'Rutsen Umbrella C',	'1431103089.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(63,	'Rutsen Umbrella D',	'',	'',	'Rutsen Umbrella D',	'1431103102.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00'),
(64,	'Rutsen Umbrella E',	'',	'',	'Rutsen Umbrella E',	'1431103110.jpg',	'',	2,	1,	0,	0,	0,	0,	'0000-00-00 00:00:00');

INSERT INTO `tbl_product_attribute` (`attribute_id`, `product_id`, `attribute_name`) VALUES
(46,	29,	''),
(109,	64,	''),
(110,	63,	''),
(111,	62,	''),
(112,	61,	''),
(113,	60,	''),
(114,	59,	''),
(115,	58,	''),
(116,	57,	''),
(117,	56,	''),
(118,	55,	''),
(119,	54,	''),
(120,	53,	''),
(121,	52,	''),
(122,	51,	''),
(123,	50,	''),
(124,	49,	''),
(125,	48,	''),
(126,	47,	''),
(127,	46,	''),
(128,	45,	''),
(129,	44,	''),
(130,	43,	''),
(131,	42,	''),
(132,	41,	''),
(133,	40,	''),
(134,	39,	''),
(135,	38,	''),
(136,	37,	''),
(137,	36,	''),
(138,	35,	''),
(140,	34,	''),
(141,	33,	''),
(142,	32,	''),
(143,	31,	''),
(144,	30,	''),
(145,	28,	''),
(146,	27,	''),
(147,	26,	''),
(148,	25,	''),
(149,	24,	''),
(150,	23,	''),
(151,	22,	''),
(152,	21,	''),
(153,	20,	''),
(154,	19,	''),
(155,	18,	''),
(156,	17,	''),
(157,	16,	''),
(158,	15,	''),
(159,	14,	''),
(160,	13,	''),
(161,	12,	''),
(162,	11,	''),
(163,	10,	''),
(164,	9,	''),
(165,	8,	''),
(166,	7,	''),
(167,	6,	''),
(168,	5,	''),
(169,	4,	''),
(171,	3,	''),
(172,	2,	''),
(173,	1,	'');

INSERT INTO `tbl_product_attribute_option` (`option_id`, `attribute_id`, `option_name`) VALUES
(46,	46,	''),
(109,	109,	''),
(110,	110,	''),
(111,	111,	''),
(112,	112,	''),
(113,	113,	''),
(114,	114,	''),
(115,	115,	''),
(116,	116,	''),
(117,	117,	''),
(118,	118,	''),
(119,	119,	''),
(120,	120,	''),
(121,	121,	''),
(122,	122,	''),
(123,	123,	''),
(124,	124,	''),
(125,	125,	''),
(126,	126,	''),
(127,	127,	''),
(128,	128,	''),
(129,	129,	''),
(130,	130,	''),
(131,	131,	''),
(132,	132,	''),
(133,	133,	''),
(134,	134,	''),
(135,	135,	''),
(136,	136,	''),
(137,	137,	''),
(138,	138,	''),
(140,	140,	''),
(141,	141,	''),
(142,	142,	''),
(143,	143,	''),
(144,	144,	''),
(145,	145,	''),
(146,	146,	''),
(147,	147,	''),
(148,	148,	''),
(149,	149,	''),
(150,	150,	''),
(151,	151,	''),
(152,	152,	''),
(153,	153,	''),
(154,	154,	''),
(155,	155,	''),
(156,	156,	''),
(157,	157,	''),
(158,	158,	''),
(159,	159,	''),
(160,	160,	''),
(161,	161,	''),
(162,	162,	''),
(163,	163,	''),
(164,	164,	''),
(165,	165,	''),
(166,	166,	''),
(167,	167,	''),
(168,	168,	''),
(169,	169,	''),
(171,	171,	''),
(172,	172,	''),
(173,	173,	'');

INSERT INTO `tbl_product_brand` (`brand_id`, `brand_name`) VALUES
(1,	''),
(2,	'Rutsen');

INSERT INTO `tbl_product_collection` (`collection_id`, `collection_name`, `collection_description`) VALUES
(1,	'Top',	' Top Products '),
(30,	'New',	'Newest Products');




INSERT INTO `tbl_product_tag` (`product_tag_id`, `product_tag_name`, `product_id`) VALUES
(46,	'Rutsen Wallet',	29),
(109,	'Rutsen Umbrella E',	64),
(110,	'Rutsen Umbrella D',	63),
(111,	'Rutsen Umbrella C',	62),
(112,	'Rutsen Umbrella B',	61),
(113,	'Rutsen Umbrella A',	60),
(114,	'Rutsen Shirt I',	59),
(115,	'Rutsen Shirt H',	58),
(116,	'Rutsen Shirt G',	57),
(117,	'Rutsen Shirt F',	56),
(118,	'Rutsen Shirt E',	55),
(119,	'Rutsen Shirt C',	54),
(120,	'Rutsen Shirt B',	53),
(121,	'Rutsen Shirt A',	52),
(122,	'Rutsen Polo Shirt S',	51),
(123,	'Rutsen Polo Shirt R',	50),
(124,	'Rutsen Polo Shirt Q',	49),
(125,	'Rutsen Polo Shirt B',	48),
(126,	'Rutsen Polo Shirt O',	47),
(127,	'Rutsen Polo Shirt N',	46),
(128,	'Rutsen Polo Shirt M',	45),
(129,	'Rutsen Polo Shirt L',	44),
(130,	'Rutsen Polo Shirt K',	43),
(131,	'Rutsen Polo Shirt J',	42),
(132,	'Rutsen Polo Shirt I',	41),
(133,	'Rutsen Polo Shirt H',	40),
(134,	'Rutsen Polo Shirt G',	39),
(135,	'Rutsen Polo Shirt F',	38),
(136,	'Rutsen Polo Shirt E',	37),
(137,	'Rutsen Polo Shirt D',	36),
(138,	'Rutsen Polo Shirt C',	35),
(140,	'Rutsen Polo Shirt B',	34),
(141,	'Rutsen Jacket D',	33),
(142,	'Rutsen Booklet',	32),
(143,	'Rutsen Pens',	31),
(144,	'Pen with Pen Holder',	30),
(145,	'Rutsen Jacket D',	28),
(146,	'Rutsen Jacket D',	27),
(147,	'Rutsen Jacket B',	26),
(148,	'Rutsen Jacket B',	25),
(149,	'Rutsen Jacket A',	24),
(150,	'Rutsen Cup C',	23),
(151,	'Rutsen Cup B',	22),
(152,	'Rutsen Cup A',	21),
(153,	'Rutsen Cap E',	20),
(154,	'Rutsen Cap D',	19),
(155,	'Rutsen Cap C',	18),
(156,	'Rutsen Cap A',	17),
(157,	'Rutsen Cap A',	16),
(158,	'Rutsen Ballpen O',	15),
(159,	'Rutsen Ballpen N',	14),
(160,	'Rutsen Ballpen M',	13),
(161,	'Rutsen Ballpen L',	12),
(162,	'Rutsen Ballpen K',	11),
(163,	'Rutsen Ballpen J',	10),
(164,	'Rutsen Ballpen I',	9),
(165,	'Rutsen Ballpen H',	8),
(166,	'Rutsen Ballpen G',	7),
(167,	'Rutsen Ballpen F',	6),
(168,	'Rutsen Ballpen E',	5),
(169,	'Rutsen Ballpen D',	4),
(171,	'Rutsen Ballpen C',	3),
(172,	'Rutsen Ballpen B',	2),
(173,	'Rutsen Ballpen A',	1);

INSERT INTO `tbl_product_type` (`product_type_id`, `product_type_parent_id`, `product_type_name`, `product_type_slug`, `product_type_thumbnail`, `product_type_archive`) VALUES
(1,	0,	'Jacket',	'Jacket',	'1431105432.jpg',	0),
(2,	0,	'Cap',	'Cap',	'1431105428.jpg',	0),
(3,	0,	'Cup',	'Cup',	'1431105430.jpg',	0),
(4,	0,	'Pen',	'Pen',	'1431105434.jpg',	0),
(5,	0,	'Polo Shirt',	'Polo-Shirt',	'1431105435.jpg',	0),
(6,	0,	'Shirt',	'Shirt',	'1431105437.jpg',	0),
(7,	0,	'Umbrella',	'Umbrella',	'1431105439.jpg',	0);

INSERT INTO `tbl_product_variation` (`variation_id`, `product_id`, `variation_attribute`, `variation_image`, `variation_price`, `variation_price_compare`, `variation_sku`, `variation_barcode`, `variation_stock_qty`, `variation_weight`) VALUES
(46,	29,	'simple',	'default.jpg',	500,	0,	'',	'',	0,	0),
(109,	64,	'simple',	'default.jpg',	90,	0,	'',	'',	0,	0),
(110,	63,	'simple',	'default.jpg',	80,	0,	'',	'',	0,	0),
(111,	62,	'simple',	'default.jpg',	70,	0,	'',	'',	0,	0),
(112,	61,	'simple',	'default.jpg',	60,	0,	'',	'',	0,	0),
(113,	60,	'simple',	'default.jpg',	50,	0,	'',	'',	0,	0),
(114,	59,	'simple',	'default.jpg',	150,	0,	'',	'',	0,	0),
(115,	58,	'simple',	'default.jpg',	100,	0,	'',	'',	0,	0),
(116,	57,	'simple',	'default.jpg',	200,	0,	'',	'',	0,	0),
(117,	56,	'simple',	'default.jpg',	150,	0,	'',	'',	0,	0),
(118,	55,	'simple',	'default.jpg',	100,	0,	'',	'',	0,	0),
(119,	54,	'simple',	'default.jpg',	200,	0,	'',	'',	0,	0),
(120,	53,	'simple',	'default.jpg',	150,	0,	'',	'',	0,	0),
(121,	52,	'simple',	'default.jpg',	100,	0,	'',	'',	0,	0),
(122,	51,	'simple',	'default.jpg',	200,	0,	'',	'',	0,	0),
(123,	50,	'simple',	'default.jpg',	300,	0,	'',	'',	0,	0),
(124,	49,	'simple',	'default.jpg',	200,	0,	'',	'',	0,	0),
(125,	48,	'simple',	'default.jpg',	300,	0,	'',	'',	0,	0),
(126,	47,	'simple',	'default.jpg',	250,	0,	'',	'',	0,	0),
(127,	46,	'simple',	'default.jpg',	250,	0,	'',	'',	0,	0),
(128,	45,	'simple',	'default.jpg',	200,	0,	'',	'',	0,	0),
(129,	44,	'simple',	'default.jpg',	300,	0,	'',	'',	0,	0),
(130,	43,	'simple',	'default.jpg',	250,	0,	'',	'',	0,	0),
(131,	42,	'simple',	'default.jpg',	200,	0,	'',	'',	0,	0),
(132,	41,	'simple',	'default.jpg',	200,	0,	'',	'',	0,	0),
(133,	40,	'simple',	'default.jpg',	300,	0,	'',	'',	0,	0),
(134,	39,	'simple',	'default.jpg',	250,	0,	'',	'',	0,	0),
(135,	38,	'simple',	'default.jpg',	200,	0,	'',	'',	0,	0),
(136,	37,	'simple',	'default.jpg',	200,	0,	'',	'',	0,	0),
(137,	36,	'simple',	'default.jpg',	300,	0,	'',	'',	0,	0),
(138,	35,	'simple',	'default.jpg',	300,	0,	'',	'',	0,	0),
(140,	34,	'simple',	'default.jpg',	250,	0,	'',	'',	0,	0),
(141,	33,	'simple',	'default.jpg',	200,	0,	'',	'',	0,	0),
(142,	32,	'simple',	'default.jpg',	200,	0,	'',	'',	0,	0),
(143,	31,	'simple',	'default.jpg',	300,	0,	'',	'',	0,	0),
(144,	30,	'simple',	'default.jpg',	150,	0,	'',	'',	0,	0),
(145,	28,	'simple',	'default.jpg',	600,	0,	'',	'',	0,	0),
(146,	27,	'simple',	'default.jpg',	500,	0,	'',	'',	0,	0),
(147,	26,	'simple',	'default.jpg',	400,	0,	'',	'',	0,	0),
(148,	25,	'simple',	'default.jpg',	400,	0,	'',	'',	0,	0),
(149,	24,	'simple',	'default.jpg',	300,	0,	'',	'',	0,	0),
(150,	23,	'simple',	'default.jpg',	120,	0,	'',	'',	0,	0),
(151,	22,	'simple',	'default.jpg',	110,	0,	'',	'',	0,	0),
(152,	21,	'simple',	'default.jpg',	100,	0,	'',	'',	0,	0),
(153,	20,	'simple',	'default.jpg',	50,	0,	'',	'',	0,	0),
(154,	19,	'simple',	'default.jpg',	40,	0,	'',	'',	0,	0),
(155,	18,	'simple',	'default.jpg',	30,	0,	'',	'',	0,	0),
(156,	17,	'simple',	'default.jpg',	35,	0,	'',	'',	0,	0),
(157,	16,	'simple',	'default.jpg',	30,	0,	'',	'',	0,	0),
(158,	15,	'simple',	'default.jpg',	15,	0,	'',	'',	0,	0),
(159,	14,	'simple',	'default.jpg',	15,	0,	'',	'',	0,	0),
(160,	13,	'simple',	'default.jpg',	15,	0,	'',	'',	0,	0),
(161,	12,	'simple',	'default.jpg',	15,	0,	'',	'',	0,	0),
(162,	11,	'simple',	'default.jpg',	15,	0,	'',	'',	0,	0),
(163,	10,	'simple',	'default.jpg',	10,	0,	'',	'',	0,	0),
(164,	9,	'simple',	'default.jpg',	10,	0,	'',	'',	0,	0),
(165,	8,	'simple',	'default.jpg',	10,	0,	'',	'',	0,	0),
(166,	7,	'simple',	'default.jpg',	10,	0,	'',	'',	0,	0),
(167,	6,	'simple',	'default.jpg',	10,	0,	'',	'',	0,	0),
(168,	5,	'simple',	'default.jpg',	10,	0,	'',	'',	0,	0),
(169,	4,	'simple',	'default.jpg',	10,	0,	'',	'',	0,	0),
(171,	3,	'simple',	'default.jpg',	10,	0,	'',	'',	0,	0),
(172,	2,	'simple',	'default.jpg',	10,	0,	'',	'',	0,	0),
(173,	1,	'simple',	'default.jpg',	10,	0,	'',	'',	0,	0);



INSERT INTO `tbl_slider_image` (`slider_image_id`, `slider_image_name`) VALUES
(2,	'1429722318.jpg'),
(3,	'1429722322.jpg'),
(4,	'1429722338.jpg');



-- 2015-05-08 17:49:18
*/
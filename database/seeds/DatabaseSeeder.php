<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('tbl_rank');
        $this->call('tbl_membership');
        $this->call('tbl_account');
        $this->call('tbl_slot');
        $this->call('tbl_country');
        $this->call('tbl_product_category');
        $this->call('tbl_inventory_update_type');
        $this->call('tbl_code_type');
        $this->call('tbl_module');
        $this->call('tbl_team');
        $this->call('tbl_admin_position');
        $this->call('tbl_admin_position_has_module');
        $this->call('tbl_admin');
        $this->call('tbl_slide');
        $this->call('tbl_testimony');
        $this->call('tbl_product');
    }
}





class tbl_account extends Seeder
{
    public function run()
    {
        DB::table('tbl_account')->delete();
        DB::statement("INSERT INTO `tbl_account`    (`account_id`, `account_name`, `account_email`, `account_username`, `account_contact_number`, `account_country_id`, `account_date_created`, `account_password`, `custom_field_value`, `account_created_from`, `archived`) VALUES
                                                    (1, 'Company Head', 'companyhead@gmail.com',    'companyhead',  '09165801584',  1,  '2015-06-28 04:12:03',  'eyJpdiI6IkJpMFE0ejVUNGhacVRoNDMzOWxBTHc9PSIsInZhbHVlIjoiR25YazdybnJzTlYrZWNtYVpxMTVIQ3MwQm50Wkx2bkNLdGJvUExSbENPTT0iLCJtYWMiOiJjMmZlMjNiNDliZWIwNDhiNjZmZDI3NmY5ZWVmMDU4ZTg4ZDcyODQwYThmMGJmZTA1ZTU1NDJmNjFiNTRkNWE0In0=', 'N;',   'Back Office',  0);");
    } 
}
class tbl_rank extends Seeder
{
    public function run()
    {
        DB::table('tbl_rank')->delete();
        DB::statement("INSERT INTO `tbl_rank`   (`rank_id`, `rank_name`, `rank_level`) VALUES
                                                (1, 'REGULAR',  1);");
    } 
}
class tbl_membership extends Seeder
{
    public function run()
    {
        DB::table('tbl_membership')->delete();
        DB::statement("INSERT INTO `tbl_membership` (`membership_id`, `membership_name`, `membership_price`, `archived`) VALUES
                                                    (1, 'REGULAR',  500,    0),
                                                    (2, 'GOLD', 30000,  0),
                                                    (3, 'SILVER',   20000,  0),
                                                    (4, 'BRONZE',   10000,  0);");
    } 
}
class tbl_slot extends Seeder
{
    public function run()
    {
        DB::table('tbl_slot')->delete();
        DB::statement("INSERT INTO `tbl_slot`   (`slot_id`, `slot_owner`, `slot_membership`, `slot_type`, `slot_rank`, `slot_wallet`, `slot_sponsor`, `slot_placement`, `slot_position`, `slot_binary_left`, `slot_binary_right`, `slot_personal_points`, `slot_group_points`, `created_at`, `updated_at`) VALUES
                                                (1, 1,  1,  'PS',   1,  0,  999999999,  999999999,  'left', 0,  0,  0,  0,   '0000-00-00 00:00:00',  '0000-00-00 00:00:00');");
    } 
}
class tbl_country extends Seeder
{
    public function run()
    {
        DB::table('tbl_country')->delete();
        DB::statement("INSERT INTO `tbl_country`    (`country_id`, `country_name`, `currency`, `rate`, `archived`) VALUES
                                                    (1, 'United Arab Emirates', 'AED',  1,  0),
                                                    (2, 'Philippines',  'PHP',  12.2578,    0),
                                                    (3, 'United States of America', 'USD',  0.27229,    0);");
    } 
}


class tbl_product_category extends Seeder
{
    public function run()
    {
        DB::table('tbl_product_category')->delete();
        DB::statement("INSERT INTO `tbl_product_category` (`product_category_id`, `product_category_name`, `slug`, `created_at`, `updated_at`, `archived`) VALUES
        (4, 'Beverages',    'beverages',    '2015-07-17 07:58:38',  '2015-07-17 07:58:38',  0),
        (5, 'Beauty Products',  'beauty-products',  '2015-07-17 08:11:29',  '2015-07-17 08:11:29',  0),
        (6, 'Hygiene',  'hygiene',  '2015-07-17 08:34:40',  '2015-07-17 08:34:40',  0);"
        );
    } 
}


class tbl_inventory_update_type extends Seeder
{
    public function run()
    {
        DB::table('tbl_inventory_update_type')->delete();
        DB::statement("INSERT INTO `tbl_inventory_update_type` (`inventory_update_type_id`, `inventory_update_type_name`) VALUES
                (1, 'Claimable Voucher'),
                (2, 'Deduct Rightr Away'),
                (3, 'No Inventory Update');");
    }
}


class tbl_code_type extends Seeder
{
    public function run()
    {
        DB::table('tbl_code_type')->delete();
        DB::statement("INSERT INTO `tbl_code_type` (`code_type_id`, `code_type_name`) VALUES
                        (1, 'Paid Slot'),
                        (2, 'Free Slot'),
                        (3, 'Comission Deductable');
                    ");
    }
}

class tbl_module extends Seeder
{
    public function run()
    {
        DB::table('tbl_module')->delete();
        DB::statement("INSERT INTO `tbl_module` (`module_id`, `module_name`, `url_segment`, `archived`) VALUES
        (1, 'Transaction / Process Sale',   'sales',    0),
        (2, 'Transaction / Process Payout', 'payout',   0),
        (3, 'Transaction / Process Claims', 'claims',   0),
        (4, 'Transaction / Unilevel Distribution',  'unilevel', 0),
        (5, 'Maintenance / Accounts',   'accounts', 0),
        (6, 'Maintenance / Membership Codes',   'codes',    0),
        (7, 'Maintenance / Package',    'product_package',  0),
        (8, 'Maintenance / Product',    'product',  0),
        (9, 'Maintenance / Slots',  'slots',    0),
        (10,    'Utitlities / Admin',   'admin_maintenance',    0),
        (11,    'Utitlities / Admin Levels',    'position', 0),
        (12,    'Utitlities / Company Settings',    'setting',  0),
        (14,    'Reports / Product Sales Report',   'product_sales',    0),
        (15,    'Reports / Membership Sales Report',    'membership_sales', 0),
        (16,    'Maintenance / Product',    'country',  0),
        (17,    'Maintenance / Deduction',  'deduction',    0),
        (18,    'Maintenance / membership', 'membership',   0),
        (19,    'Maintenance / Ranking',    'ranking',  0),
        (20,    'Maintenance / News',   'news', 0),
        (21,    'Maintenance / Earn',   'earn', 0),
        (22,    'Maintenance / Inventory',  'inventory',    0),
        (23,    'Utitlities / Computation Plan',    'complan',  0),
        (24,    'Maintenance / Slide',  'slide',    0),
        (25,    'Maintenance / Team',   'team', 0),
        (26,    'Maintenance / Testimonial',    'testimony',    0),
        (27,    'Maintenance / Partners',   'partner',  0);"
        );
    } 
}
class tbl_team extends Seeder
{
    public function run()
    {
        DB::table('tbl_team')->delete();
        DB::statement("INSERT INTO `tbl_team` (`team_id`, `team_title`, `team_description`, `team_role`, `team_image`, `created_at`, `updated_at`, `archived`) VALUES
        (1, 'Mrs. Rose S. Rajeh',   '', '', '1436855352.jpg',   '2015-07-14 06:29:16',  '2015-07-14 06:29:32',  0),
        (2, 'Mr. Gino Antonio S. Rajeh',    '', '', '1436855359.jpg',   '2015-07-14 06:29:49',  '0000-00-00 00:00:00',  0);
        ");
    } 
}


class tbl_admin_position extends Seeder
{
    public function run()
    {
        DB::table('tbl_admin_position')->delete();
        DB::statement("INSERT INTO `tbl_admin_position` (`admin_position_id`, `admin_position_name`, `admin_position_rank`, `admin_position_module`, `archived`) VALUES
    (1,    'super_admin',  '0',    '', 0),
    (2,    'admin',    '1',    '', 0),
    (3,    'Secretary',    '2',    '', 0);");
    } 
}



class tbl_admin_position_has_module extends Seeder
{
    public function run()
    {
        DB::table('tbl_admin_position_has_module')->delete();
        DB::statement("INSERT INTO `tbl_admin_position_has_module` (`id`, `admin_position_id`, `module_id`) VALUES
        (1, 1,  1),
        (2, 1,  2),
        (3, 1,  3),
        (4, 1,  4),
        (5, 1,  5),
        (6, 1,  6),
        (7, 1,  7),
        (8, 1,  8),
        (9, 1,  9),
        (10,    1,  10),
        (11,    1,  11),
        (12,    1,  12),
        (13,    1,  14),
        (14,    1,  15),
        (15,    1,  16),
        (16,    1,  17),
        (17,    1,  18),
        (18,    1,  19),
        (19,    1,  20),
        (20,    1,  21),
        (21,    1,  22),
        (22,    1,  23),
        (23,    2,  1),
        (24,    2,  2),
        (25,    2,  3),
        (26,    2,  4),
        (27,    2,  6),
        (28,    2,  7),
        (29,    2,  8),
        (30,    2,  9),
        (31,    2,  10),
        (32,    2,  11),
        (33,    2,  12),
        (34,    2,  14),
        (35,    2,  15),
        (36,    2,  16),
        (37,    2,  17),
        (38,    2,  18),
        (39,    2,  19),
        (40,    2,  20),
        (41,    2,  21),
        (42,    2,  22),
        (43,    2,  23),
        (44,    3,  5),
        (45,    3,  21),
        (46,    1,  24),
        (47,    1,  25),
        (48,    1,  26),
        (49,    1,  27);
        ");
    } 
}


class tbl_admin extends Seeder
{
    public function run()
    {
        DB::table('tbl_admin')->delete();
        DB::statement("INSERT INTO `tbl_admin` (`admin_id`, `account_id`, `admin_position_id`) VALUES
        (1, 1,1);");
    } 
}

class tbl_slide extends Seeder
{
    public function run()
    {
        DB::table('tbl_slide')->delete();
        DB::statement("INSERT INTO `tbl_slide` (`slide_id`, `slide_title`, `slide_image`, `created_at`, `updated_at`, `archived`) VALUES
        (1, 'Skin Care',    '1436764123.jpg',   '2015-07-17 07:45:25',  '0000-00-00 00:00:00',  0),
        (2, 'OFW',  '1436763703.jpg',   '2015-07-17 07:45:48',  '0000-00-00 00:00:00',  0),
        (3, 'Cafe Verde',   '1436763174.jpg',   '2015-07-17 07:46:03',  '0000-00-00 00:00:00',  0),
        (4, 'Chocorite',    '1436763179.jpg',   '2015-07-17 07:46:14',  '0000-00-00 00:00:00',  0);
        ");
    }
}

class tbl_testimony extends Seeder
{
    public function run()
    {
        DB::table('tbl_testimony')->delete();
        DB::statement("INSERT INTO `tbl_testimony` (`testimony_id`, `testimony_text`, `testimony_person`, `testimony_position`, `created_at`, `updated_at`, `archived`) VALUES
        (1, '“The products are excellent! I love using the organic soaps, it makes me feel cleaner and refreshed all day long”',    'Marieta Gutierrez',    'Advance Fasteners',    '2015-07-17 07:00:40',  '2015-07-17 07:09:49',  0),
        (2, '“The products are excellent! I love using the organic soaps, it makes me feel cleaner and refreshed all day long”',    'Marieta Gutierrez',    'Advance Fasteners',    '2015-07-17 07:01:08',  '0000-00-00 00:00:00',  1),
        (3, '“The on-line services are easy and user-friendly. The technical support are awesome!”',    'Lorenz Pasion',    'Pinoy Express',    '2015-07-17 07:10:55',  '0000-00-00 00:00:00',  0),
        (4, '“In one word, Fantastic! This is what I was waiting for. A company with a heart and concern for its members”\r\n', 'Jerry Macatuno',   'Painter / Designer',   '2015-07-17 07:11:17',  '0000-00-00 00:00:00',  0);
        ");
    }
}

class tbl_product extends Seeder
{
    public function run()
    {
        DB::table('tbl_product')->delete();
        DB::statement("INSERT INTO `tbl_product` (`product_id`, `product_info`, `sku`, `product_name`, `slug`, `product_category_id`, `unilevel_pts`, `binary_pts`, `price`, `image_file`, `created_at`, `updated_at`, `archived`) VALUES
        (1, 'A stimulating and refreshing coffee drink enriched with distinct aromatic taste. It is made from natural and organic blend of Acai Berries, Moringa, Barley, Spirulina, Green Tea, Chlorella, Stevia and Green Coffee. PROLIFE CAFÉ VERDE will surely perk up your mood anytime of the day.\r\n\r\nPROLIFE CAFE VERDE is caffeine-free, contains natural  sweet compound that has no carcinogenic activity. It is  loaded with protein, fibre, essential fatty acids, anti-oxidants, amino acids, vitamins and minerals that helps to reduce the risks of damaged cells, helps in lowering bad cholesterol, treats unpleasant body and breath odour, cleanses digestive tracts, helps reduce body fats and improves  the body’s rate of metabolism for a completely healthy lifestyle.\r\n',   '0',    'Cafe Verde',   'cafe-verde',   4,  0,  0,  0,  '1437119789.jpg',   '2015-07-17 07:58:38',  '2015-07-17 07:58:38',  0),
        (2, 'A delicious and nutritious chocolate drink that helps to strengthen the immune system and enhances regeneration of damaged tissues. CHOCO-RITE helps to maintain mental alertness and sharpen memory. \r\n \r\nFortified with calcium, CHOCO-RITE is made from Ginkgo Biloba and Chlorella Growth Factor that is known to regulate the production of body enzymes, gives energy and protein for a complete and balance development of neuro-mechanism.\r\n \r\nThe right chocolate drink for everybody!\r\n',  '1',    'Chocorite',    'chocorite',    4,  1,  1,  1,  '1437119806.jpg',   '2015-07-17 08:10:06',  '2015-07-17 08:10:06',  0),
        (3, 'Helps to deeply moisturize and lighten the skin. \r\nContains special sun-filters that helps protect the skin from damaging free radicals.\r\nHelps to prevent dark spots and hyper-pigmentation caused by aging and over-exposure to the sun.\r\nComprises of Vitamin B3 as a triple Vitamin Sunscreen. \r\nEnriched with Anti-oxidants such as Vitamin B5, Vitamin E and Glutathione.\r\nMade from Grapefruit and Apple Extract.\r\n100% Paraben free and Mercury free.\r\n',    '2',    'Pearl White Cream',    'pearl-white-cream',    5,  2,  2,  2,  '1437119893.jpg',   '2015-07-17 08:11:29',  '2015-07-17 08:11:29',  0),
        (4, 'With its rich and generous texture, Pearl White Lotion will help plump the skin, hydrate and deeply nourish through the epidermis.\r\nHelps provide natural radiance to the skin.\r\nUltrafine protection from UV rays of the sun.\r\nMoisturize and softens the skin.\r\nPrevents dry, itchy skin and minor skin irritations.\r\n',   '3',    'Pearl White Lotion',   'pearl-white-lotion',   5,  3,  3,  3,  '1437119902.jpg',   '2015-07-17 08:12:30',  '2015-07-17 08:12:30',  0),
        (5, 'Under-arm protection from odour and sweat.\r\nDries quickly, non-sticky and does not sting.\r\nWhitening effect on armpit.\r\n',   '4',    'Pearl White Deodorant',    'pearl-white-deodorant',    5,  4,  4,  4,  '1437119898.jpg',   '2015-07-17 08:26:31',  '2015-07-17 08:26:31',  0),
        (6, 'For whole day protection and freshness.\r\nReduces rashes and irritation.\r\nHelps to absorb moisture.\r\nPrevents chafing. \r\n', '5',    'Pearl White Talcum Powder',    'pearl-white-talcum-powder',    5,  5,  5,  5,  '1437119906.jpg',   '2015-07-17 08:27:44',  '2015-07-17 08:27:44',  0),
        (7, 'Enhanced whitening for bright, light and beautiful skin. Brings out your skin’s natural radiance.\r\nAs part of your daily skin care regime, use this toner to help brighten skin, refine skin texture and minimize pores.\r\nRemoves make-up, dirt and excess oil. Leaving your skin fresh and clean.\r\n',   '6',    'Pearl White Facial Toner', 'pearl-white-facial-toner', 5,  6,  6,  6,  'default.jpg',  '2015-07-17 08:29:55',  '2015-07-17 08:29:55',  0),
        (8, 'A fragrance soap that utilizes the properties of fruit stem cell and Kojic Acid. \r\n\r\nCell Allure Soap helps to:\r\nRENEW and trim dormant cells.\r\nREPAIR damaged cells due to UV radiation exposure\r\nREGENERATE healthy cells for total protection of skin at cellular level\r\nREJUVENATE for smooth and silky skin. \r\n',   '7',    'Cell Allure Soap', 'cell-allure-soap', 5,  7,  7,  7,  '1437119799.jpg',   '2015-07-17 08:30:44',  '2015-07-17 08:30:44',  0),
        (9, 'This unique and refreshing soap has a combination of essential ingredients that create a feeling of complete, refreshing and detoxifying bath experience. \r\nThe gentle lather of PROLIFE ROSE ESSENCE SOAP removes impurities, smoothens and tones skin, leaving it soft, supple and looking younger. \r\n\r\nPROLIFE ROSE ESSENCE SOAP - for fresh and youthful glowing skin.\r\n', '8',    'Prolife Rose Essence Soap',    'prolife-rose-essence-soap',    5,  8,  8,  8,  '1437119915.jpg',   '2015-07-17 08:31:18',  '2015-07-17 08:31:18',  0),
        (10,    'A unique soap noted for its moisturizing and cleansing abilities, leaves your skin clean, smoother and softer. Flavored with essences of vanilla and sunburst orange fragrance, it gives a sensual aroma that lingers in the skin.\r\nWith a blend of moisturizers and essential oils, PROLIFE NONI SOAP also contains premium ingredients such as coconut oil, morinda seed oil, alkali builders, dried noni fruits and leaves.\r\n\r\nPROLIFE NONI SOAP - cleanses, moisturizes and keeps skin free from harmful bacteria.\r\n', '9',    'Prolife Noni Soap',    'prolife-noni-soap',    5,  9,  9,  9,  '1437119824.jpg',   '2015-07-17 08:32:11',  '2015-07-17 08:32:11',  0),
        (11,    'PROLIFE GREEN KOJIC SOAP is formulated with pure Kojic acid derived from mushrooms that has been successfully used to lighten pigment spots, removes blemishes and helps to whiten skin without the usual drying effect. It helps in removing pimples, freckles and other skin blemishes. \r\n  \r\nPROLIFE GREEN  KOJIC SOAP is primarily an exfoliating skincare product that  helps to break down the top layer of skin cells and peel away damaged skin.\r\n\r\nPROLIFE GREEN KOJIC SOAP - the safest herbal extract for fresh and healthier skin.\r\n',   '10',   'Prolife Green Kojic Soap', 'prolife-green-kojic-soap', 5,  10, 10, 10, '1437119814.jpg',   '2015-07-17 08:32:59',  '2015-07-17 08:32:59',  0),
        (12,    'PROLIFE GLUTA PLUS SOAP helps to remove toxins produced by the body, assists to inhibit the skin’s production of melanin, resulting in natural lightening of the skin.\r\n\r\nPROLIFE GLUTA PLUS SOAP contributes to remove free radicals and harmful toxins in the skin. It is also often used to treat hyper-pigmentation, freckles, melasma, age spots, blemishes and other uneven skin tones.  \r\n \r\nPROLIFE GLUTA PLUS SOAP - for a fairer and lovelier skin.\r\n\r\n',    '11',   'Prolife Gluta Plus Soap',  'prolife-gluta-plus-soap',  5,  11, 11, 11, 'default.jpg',  '2015-07-17 08:33:52',  '2015-07-17 08:33:52',  0),
        (13,    'Prolife Hand Sanitizer has 2 active ingredients:\r\n\r\nEthyl Alcohol - helps destroy transient germs. Monolaurin - a germicide that aids in moisturizing the skin. \r\n\r\nProlife Hand Sanitizer helps prevent dryness and itchiness making your hands smooth and germ-free. \r\n\r\n\r\n\r\n\r\n\r\n\r\n',  '12',   'Prolife Hand Sanitizer',   'prolife-hand-sanitizer',   6,  12, 12, 12, '1437119819.jpg',   '2015-07-17 08:34:40',  '2015-07-17 08:34:40',  0),
        (14,    '   Prolife Regime Oil is formulated from the combination of  specially selected oils. \r\n\r\n Prolife Regime Oil helps:\r\nNourishes the skin to promote cell turn-over\r\nCombat irritation and inflammation\r\nTo heal damaged tissues\r\nReduce unwanted fats effectively\r\nStimulate the production of Collagen and Elastin which can soften and hydrate the skin.\r\n', '13',   'Prolife Regime Oil',   'prolife-regime-oil',   6,  13, 13, 13, '1437119910.jpg',   '2015-07-17 08:35:24',  '2015-07-17 08:35:24',  0);
        ");
    }
}






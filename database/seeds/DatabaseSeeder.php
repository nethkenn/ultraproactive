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
        $this->call('tbl_news');
        $this->call('tbl_partner');
        $this->call('tbl_about');
        $this->call('tbl_service');
        $this->call('tbl_settings');
        $this->call('tbl_stories');
    }
}






class tbl_settings extends Seeder
{
    public function run()
    {
        DB::table('tbl_settings')->delete();
        DB::statement("INSERT INTO `tbl_settings` (`logs_id`, `key`, `value`) VALUES
        (1, 'company_email',    'ultraproactive2014@gmail.com'),
        (2, 'company_name', 'UltraProactive'),
        (3, 'company_address',  ' Second level, Metrowalk Commercial Complex, Meralco Avenue,Ortigas Business Center, 1605 Pasig City, Philippines'),
        (4, 'company_mobile',   '0927-7447286'),
        (5, 'company_telephone',    ' +63 (02) 234-1993 0927-7447286');
        ");
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
                                                (1, 1,  1,  'PS',   1,  100,  999999999,  999999999,  'left', 0,  0,  0,  0,   '0000-00-00 00:00:00',  '0000-00-00 00:00:00');");
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
        (4, 'Beverages',    'beverages',    '2015-07-16 23:58:38',  '2015-07-16 23:58:38',  1),
        (5, 'Beauty Products',  'beauty-products',  '2015-07-17 00:11:29',  '2015-07-17 00:11:29',  1),
        (6, 'Hygiene',  'hygiene',  '2015-07-17 00:34:40',  '2015-07-17 00:34:40',  1),
        (7, 'Personal Care',    'personal-care',    '2015-08-03 13:38:50',  '2015-08-03 13:38:50',  0),
        (8, 'Healthy Beverages',    'healthy-beverages',    '2015-08-03 13:40:05',  '2015-08-03 13:40:05',  0),
        (9, 'Nutraceuticals',   'nutraceuticals',   '2015-08-03 13:40:54',  '2015-08-03 13:40:54',  0);"
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
        DB::statement("
        INSERT INTO `tbl_module` (`module_id`, `module_name`, `url_segment`, `archived`) VALUES
        (1, 'Transaction / Process Sale',   'sales',    0),
        (2, 'Transaction / Process Payout', 'payout',   0),
        (3, 'Transaction / Process Claims', 'claims',   0),
        (4, 'Transaction / Unilevel Distribution',  'unilevel', 0),
        (5, 'Maintenance / Accounts',   'accounts', 0),
        (6, 'Maintenance / Membership Codes',   'codes',    0),
        (7, 'Maintenance / Package',    'product_package',  0),
        (8, 'Maintenance / Product',    'product',  0),
        (9, 'Maintenance / Slots',  'slots',    0),
        (10,    'Utilities / Admin',    'admin_maintenance',    0),
        (11,    'Utilities / Admin Levels', 'position', 0),
        (12,    'Utilities / Company Settings', 'setting',  0),
        (14,    'Reports / Product Sales Report',   'product_sales',    0),
        (15,    'Reports / Membership Sales Report',    'membership_sales', 0),
        (16,    'Maintenance / Product',    'country',  0),
        (17,    'Maintenance / Deduction',  'deduction',    0),
        (18,    'Maintenance / membership', 'membership',   0),
        (19,    'Maintenance / Ranking',    'ranking',  0),
        (20,    'Content / News',   'news', 0),
        (21,    'Content / Earn',   'earn', 0),
        (22,    'Maintenance / Inventory',  'inventory',    0),
        (23,    'Utitlities / Computation Plan',    'complan',  0),
        (24,    'Maintenance / Slide',  'slide',    0),
        (25,    'Maintenance / Team',   'team', 0),
        (26,    'Maintenance / Testimonial',    'testimony',    0),
        (27,    'Maintenance / Partners',   'partner',  0),
        (28,    'Utilities / Binary',   'binary',   0),
        (29,    'Utilities / Direct Referral',  'direct',   0),
        (30,    'Utilities / Matching Bonus',   'matching', 0),
        (31,    'Utilities / Indirect Referral Bonus',  'indirect', 0),
        (32,    'Utilities / Unilevel Computation', 'unilevel', 0),
        (33,    'Content / Others', 'about',    0),
        (34,    'Content / Services',   'service',  0),
        (35,    'Maintenance / Product Category',   'product_category', 0),
        (36,    'Utilities / Rank Requirements',   'rank', 0),
        (37,    'Content / Stories',   'stories', 0);
        ");
    } 
}
class tbl_team extends Seeder
{
    public function run()
    {
        DB::table('tbl_team')->delete();
        DB::statement("INSERT INTO `tbl_team` (`team_id`, `team_title`, `team_role`, `team_description`, `team_image`, `created_at`, `updated_at`, `archived`) VALUES
        (1, 'Atty. Freddie Villamor',   'CEO/President',    '', '1438672528.jpg',   '2015-07-13 14:29:16',  '2015-08-04 07:15:17',  0),
        (2, 'Eric Melad',   'Vice President',   '', '1438672528.jpg',   '2015-07-13 14:29:49',  '2015-08-04 07:15:24',  0),
        (3, 'Lito Ferrer',  'Operations Manager',   '', '1438672528.jpg',   '2015-08-04 07:08:38',  '2015-08-04 07:15:31',  0),
        (4, 'Marlon Dizon', 'Marketing & Training Manager', '', '1438672528.jpg',   '2015-08-04 07:09:03',  '2015-08-04 07:15:40',  0),
        (5, 'Chet Angeline D. Portuguez',   'Finance Officer',  '', '1438672528.jpg',   '2015-08-04 07:09:27',  '2015-08-04 07:15:47',  0);
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
        (49,    1,  27),
        (50,    1,  28),
        (51,    1,  29),
        (52,    1,  30),
        (53,    1,  31),
        (54,    1,  32),
        (55,    1,  33),
        (56,    1,  34),
        (57,    1,  35),
        (58,    1,  36),
        (59,    1,  37);
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
        (1, '1',    '1433238019.jpg',   '2015-07-16 07:45:25',  '2015-08-03 07:58:01',  0),
        (2, '2',    '1434419871.png',   '2015-07-16 07:45:48',  '2015-08-03 07:58:06',  0),
        (3, '3',    '1433238048.jpg',   '2015-07-16 07:46:03',  '2015-08-03 07:58:12',  0),
        (4, '4',    '1434420026.jpg',   '2015-07-16 07:46:14',  '2015-08-04 07:40:29',  0),
        (5, '5',    '1434362721.png',   '2015-08-04 07:40:41',  '2015-08-04 07:41:19',  0),
        (6, '6',    '1434419853.png',   '2015-08-04 07:41:09',  '0000-00-00 00:00:00',  0);
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
        DB::statement("
            INSERT INTO `tbl_product` (`product_id`, `sku`, `product_name`, `product_info`, `slug`, `product_category_id`, `unilevel_pts`, `binary_pts`, `price`, `image_file`, `stock_qty`, `created_at`, `updated_at`, `archived`) VALUES
            (1, '0',    'Victorie La Belle Facial and Body Expoliating Kit',    'Victoria La Belle Facial and Body Exfoliating Kit is a skin care set formulated with the Filipino skin in mind. It contains ingredients that blend well with tropical climat, a mildness that does not irritate even the sensitive skin, and a very dramatic effect that can be seen and felt after the first use.',   'victorie-la-belle-facial-and-body-expoliating-kit',    7,  0,  0,  0,  'http://image.primiaworks.com/view?source=online.ultraproactive.net&filename=1434424400.jpg&size=250x250&mode=crop',    100,    '2015-07-16 23:58:38',  '2015-08-03 13:38:50',  0),
            (2, '1',    'Victoria La Belle All Natural Bleaching Soap', 'Contains Goat\'s milk, Olive oil, Squalene Oil, Sampaguita Oil, Papaya Extract and Natural Bleach Extracts. It effectively whitens, midly exfloates dead skin cells, minizes wrinkles and prevents premature aging. Best for sensitive skins.',    'victoria-la-belle-all-natural-bleaching-soap', 7,  1,  1,  1,  'http://image.primiaworks.com/view?source=online.ultraproactive.net&filename=1434424404.jpg&size=250x250&mode=crop',    100,    '2015-07-17 00:10:06',  '2015-08-03 13:39:35',  0),
            (3, '2',    ' Pomegranate Super Juice', 'A thick skinned super seedy fruit, with a brilliant red hue which is now touted as a wonder fruit by scientific reserachers. In comaprisoin to other health drinks, pomegranate is an exceptional source of vitamins A, C and E and minerals such as calcium, phosphorus, potassium, iron, folic acid, niacin, thiamin, floates and riboflavin and it contains approxiamtely 3 times more antioxidants than green tea, acai berry and oranges.',   'pomegranate-super-juice',  8,  2,  2,  2,  'http://image.primiaworks.com/view?source=online.ultraproactive.net&filename=1434424447.jpg&size=250x250&mode=crop',    100,    '2015-07-17 00:11:29',  '2015-08-03 13:40:05',  0),
            (4, '3',    'Turmeric Tablets', 'Moringa oleifera belongs to the Moringacea family. It is know by many names, such as horseradish tree, drumstick tree and kelor tree. It has an impressive range of medicinal uses with high nutritional value and medicinal benefits. Different parts of Moringa contain a profile of important minerals and are a good source of protein, vitamins, beta-carotene, amino acids and various pehnolics',   'turmeric-tablets', 9,  3,  3,  3,  'http://image.primiaworks.com/view?source=online.ultraproactive.net&filename=http://image.primiaworks.com/view?source=online.ultraproactive.net&filename=1434424450.jpg&size=250x250&mode=crop&size=250x250&mode=crop', 100,    '2015-07-17 00:12:30',  '2015-08-03 13:40:54',  0),
            (5, '4',    ' Moringa Tablets', 'Moringa oleifera belongs to the Moringacea family. It is known by many names, such as horseradish tree, drumstick tree and kelor tree. It has an impressive range of medicinal uses with high nutritional value and medicinal benefits. Different parts of Moringa contain a profile of important minerals and are a good source of protein, vitamins, beta-carotene, amino acids and various phenolics. ',    'moringa-tablets',  9,  4,  4,  4,  'http://image.primiaworks.com/view?source=online.ultraproactive.net&filename=1434424469.jpg&size=250x250&mode=crop',    100,    '2015-07-17 00:26:31',  '2015-08-03 13:41:27',  0),
            (6, '5',    'Dermcee',  'Derm Cee is an alkaline - buffered mineral salt - form of vitamin c and has a higher bioavailability than the more known ascorbic acid. It helps the body fight bacterial and viral infections and prevents a person from developing common illness such as colds and flu; It can stimulate the production and function of white blood cells which play a big role in the body\'s fight against diseases.',    'dermcee',  7,  5,  5,  5,  'http://image.primiaworks.com/view?source=online.ultraproactive.net&filename=1434424472.jpg&size=250x250&mode=crop',    100,    '2015-07-17 00:27:44',  '2015-08-03 13:41:46',  0),
            (7, '6',    '8 in 1 Premium Coffee',    'A delicious coffee blend with Non-fat skim milk, Cocosugar, Tongkat ali, Mangosteen, C-soy hydrolyzed protein, Hazelnut and Peppermint. A potent anti-oxidant mix in a world\'s favorite beverage.',   '8-in-1-premium-coffee',    8,  6,  6,  6,  'http://image.primiaworks.com/view?source=online.ultraproactive.net&filename=1434424474.jpg&size=250x250&mode=crop',    100,    '2015-07-17 00:29:55',  '2015-08-03 13:42:17',  0),
            (8, '7',    'EAU de Parfum',    'El Divo is the scent of a hero. The scent of this perfume is capable of sending a strong message of one \'s masculinity. It arouses self confidence. You would never go unnoticed after you have this perfume on. It will do well on a special hang out with your partner or perhaps your first date. La Diva is a lively fragrance that can make women irresistibly preey. La Diva can make you feel that there is nothing greater than being love.', 'eau-de-parfum',    7,  7,  7,  7,  'http://image.primiaworks.com/view?source=online.ultraproactive.net&filename=1434425612.jpg&size=250x250&mode=crop',    100,    '2015-07-17 00:30:44',  '2015-08-03 13:42:30',  0),
            (9, '8',    'Prolife Rose Essence Soap',    'This unique and refreshing soap has a combination of essential ingredients that create a feeling of complete, refreshing and detoxifying bath experience. \r\nThe gentle lather of PROLIFE ROSE ESSENCE SOAP removes impurities, smoothens and tones skin, leaving it soft, supple and looking younger. \r\n\r\nPROLIFE ROSE ESSENCE SOAP - for fresh and youthful glowing skin.\r\n', 'prolife-rose-essence-soap',    5,  8,  8,  8,  '1437119915.jpg',   100,    '2015-07-17 00:31:18',  '2015-07-29 05:39:38',  1),
            (10,    '9',    'Prolife Noni Soap',    'A unique soap noted for its moisturizing and cleansing abilities, leaves your skin clean, smoother and softer. Flavored with essences of vanilla and sunburst orange fragrance, it gives a sensual aroma that lingers in the skin.\r\nWith a blend of moisturizers and essential oils, PROLIFE NONI SOAP also contains premium ingredients such as coconut oil, morinda seed oil, alkali builders, dried noni fruits and leaves.\r\n\r\nPROLIFE NONI SOAP - cleanses, moisturizes and keeps skin free from harmful bacteria.\r\n', 'prolife-noni-soap',    5,  9,  9,  9,  '1434424400.jpg',   100,    '2015-07-17 00:32:11',  '2015-08-03 13:42:54',  1),
            (11,    '10',   'Prolife Green Kojic Soap', 'PROLIFE GREEN KOJIC SOAP is formulated with pure Kojic acid derived from mushrooms that has been successfully used to lighten pigment spots, removes blemishes and helps to whiten skin without the usual drying effect. It helps in removing pimples, freckles and other skin blemishes. \r\n  \r\nPROLIFE GREEN  KOJIC SOAP is primarily an exfoliating skincare product that  helps to break down the top layer of skin cells and peel away damaged skin.\r\n\r\nPROLIFE GREEN KOJIC SOAP - the safest herbal extract for fresh and healthier skin.\r\n',   'prolife-green-kojic-soap', 5,  10, 10, 10, '1437119814.jpg',   100,    '2015-07-17 00:32:59',  '2015-07-29 05:40:08',  1),
            (12,    '11',   'Prolife Gluta Plus Soap',  'PROLIFE GLUTA PLUS SOAP helps to remove toxins produced by the body, assists to inhibit the skin’s production of melanin, resulting in natural lightening of the skin.\r\n\r\nPROLIFE GLUTA PLUS SOAP contributes to remove free radicals and harmful toxins in the skin. It is also often used to treat hyper-pigmentation, freckles, melasma, age spots, blemishes and other uneven skin tones.  \r\n \r\nPROLIFE GLUTA PLUS SOAP - for a fairer and lovelier skin.\r\n\r\n',    'prolife-gluta-plus-soap',  5,  11, 11, 11, 'default.jpg',  100,    '2015-07-17 00:33:52',  '2015-07-29 05:40:05',  1),
            (13,    '12',   'Prolife Hand Sanitizer',   'Prolife Hand Sanitizer has 2 active ingredients:\r\n\r\nEthyl Alcohol - helps destroy transient germs. Monolaurin - a germicide that aids in moisturizing the skin. \r\n\r\nProlife Hand Sanitizer helps prevent dryness and itchiness making your hands smooth and germ-free. \r\n\r\n\r\n\r\n\r\n\r\n\r\n',  'prolife-hand-sanitizer',   6,  12, 12, 12, '1437119819.jpg',   100,    '2015-07-17 00:34:40',  '2015-07-29 05:40:01',  1),
            (14,    '13',   'Prolife Regime Oil',   '   Prolife Regime Oil is formulated from the combination of  specially selected oils. \r\n\r\n Prolife Regime Oil helps:\r\nNourishes the skin to promote cell turn-over\r\nCombat irritation and inflammation\r\nTo heal damaged tissues\r\nReduce unwanted fats effectively\r\nStimulate the production of Collagen and Elastin which can soften and hydrate the skin.\r\n', 'prolife-regime-oil',   6,  13, 13, 13, '1437119910.jpg',   100,    '2015-07-17 00:35:24',  '2015-07-29 05:39:58',  1);
        ");
    }
}

class tbl_news extends Seeder
{
    public function run()
    {
        DB::table('tbl_news')->delete();
        DB::statement("INSERT INTO `tbl_news` (`news_id`, `news_title`, `news_description`, `news_date`, `news_image`, `archived`) VALUES
        (1, 'Sample 1', 'A green coffee extract is an extract of unroasted, green coffee beans. Green coffee extract has been used as a weight-loss supplement and as an ingredient in other weight-loss products. Its efficacy and mechanism of action have been the subject of controversy.\r\n\r\nThere is tentative evidence of benefit; however, the quality of the evidence is poor.[1] In 2014 one of the primary trials showing benefit was retracted and the company that sponsored the study, Applied Food Sciences, was fined by the Federal Trade Commission for making baseless weight-loss claims using the flawed study.[2]\r\n\r\nGreen coffee extract is sold under various proprietary brand names including Svetol, and is included in weight-loss products such as CoffeeSlender.[1]',  '2015-08-03 12:00:35',  '1433328012.jpg',   0),
        (2, 'Sample 2', 'The cocoa bean, also cacao bean[1] or simply cocoa is the dried and fully fermented fatty seed of Theobroma cacao, from which cocoa solids and cocoa butter are extracted.[2] They are the basis of chocolate, as well as many Mesoamerican foods such as mole sauce and tejate.\r\n\r\nA cocoa pod (fruit) has a rough and leathery rind about 2 cm (0.79 in) to 3 cm (1.2 in) thick (this varies with the origin and variety of pod). It is filled with sweet, mucilaginous pulp (called baba de cacao in South America) with a lemonade like taste enclosing 30 to 50 large seeds that are fairly soft and a pale lavender to dark brownish purple color. Due to heat buildup in the fermentation process, cacao beans lose most of the purplish hue and become mostly brown in color, with an adhered skin which includes the dried remains of the fruity pulp. This skin is released easily after roasting by winnowing. White seeds are found in some rare varieties, usually mixed with purples, and are considered of higher value.[3][4][5] Historically, white cacao was cultivated by the Rama people of Nicaragua.',   '2015-08-03 12:00:46',  '1433328012.jpg',   0);
        ");
    }
}

class tbl_partner extends Seeder
{
    public function run()
    {
        DB::table('tbl_partner')->delete();
        DB::statement("INSERT INTO `tbl_partner` (`partner_id`, `partner_title`, `partner_link`, `partner_image`, `created_at`, `updated_at`, `archived`) VALUES
        (1, 'SMDC', 'http://www.smdc.com/', '1437461037.jpg',   '2015-07-21 05:52:29',  '2015-07-21 06:43:28',  0),
        (2, 'Marco Polo',   'http://www.marcopolohotels.com',   '1437460919.jpg',   '2015-07-21 05:54:41',  '2015-07-21 06:41:29',  0),
        (3, 'Vista Land',   'http://www.vistaland.com.ph',  '1437460828.jpg',   '2015-07-21 05:57:18',  '2015-07-21 06:40:27',  0),
        (4, 'E-Concept Business',   'http://www.econceptbusiness.com.ph/',  '1437460813.jpg',   '2015-07-21 06:02:08',  '2015-07-21 06:39:58',  0),
        (5, 'Al Zari & Al Fardan Exchange', 'http://www.alfardanexchange.com/', '1437461543.jpg',   '2015-07-21 06:51:53',  '0000-00-00 00:00:00',  0),
        (6, 'Philippine Medical Center',    'http://www.philippinemedicalcenter.ae/',   '1437462083.jpg',   '2015-07-21 07:00:53',  '0000-00-00 00:00:00',  0),
        (7, 'Dr. Sanjay Medical Center',    'http://drsanjaymedical.com',   '1437462306.jpg',   '2015-07-21 07:04:37',  '0000-00-00 00:00:00',  0),
        (8, 'Magic Trading Co.',    'http://www.mtc.ae',    '1437462510.jpg',   '2015-07-21 07:08:02',  '0000-00-00 00:00:00',  0);
        ");
    }
}

class tbl_about extends Seeder
{
    public function run()
    {
        DB::table('tbl_about')->delete();
        DB::statement("INSERT INTO `tbl_about` (`about_id`, `about_name`, `about_description`, `created_at`, `updated_at`, `archived`) VALUES
        (1, 'About',    'PROLIFE NWT is a company formed by Filipino professionals based in the United Arab Emirates. Bound together by a common goal, each with their own expertise, they have decided it’s about time that expatriates in the UAE will be given a free choice and be catered with all their needs. \r\n\r\nBy providing convenient e-services, the main aim is to help and alleviate the lives of expatriates around the globe. PROLIFE NWT envisions prosperity for all.\r\n\r\n PROLIFE NWT also promotes real estate investments, free entrepreneurships, encourages self development and offers a wide array of natural  skincare and healthcare products.',  '2015-07-24 03:33:54',  '2015-07-24 03:33:54',  0),
        (2, 'Vision',   'Through high quality products, service excellence, continuous improvement and team work, we will be the leading e-commerce business worldwide',    '2015-07-24 03:33:54',  '2015-07-24 03:33:54',  0),
        (3, 'Mission',  'To provide globally, the convenience of affordable on-line products and services, with the aim of encouraging free entrepreneurship for a better future of our members',   '2015-07-24 03:33:54',  '2015-07-24 03:33:54',  0),
        (4, 'Philosophy',   'We do not only aim to expand our business in a global perspective but we will work collectively as a team to contribute to our society”\r\n“It is our intention to prosper hand in hand with our members, encouraging and motivating them to bring out their full potential and to drive them towards boundless opportunities.”</br>\r\n“We are the PROLIFE Family!',  '2015-07-24 03:33:54',  '2015-07-24 03:33:54',  0),
        (5, 'Partners', 'Do you want to buy a house or a condo unit? Travel and relax in a city of your choice with airline discount? Or simply dine in a recommended restaurant? As a PROLIFE MEMBER, you are entitled for exclusive discounts and privileges. We have various partners from different industries like, real estate developers, medical centers, travel and tours, restaurants, hotels and many more. Just present your membership card and you can instantly avail from 10% to 50% discounts. Just click on our partner’s links for more details. \r\n\r\n*Subject to the terms and conditions of the affiliated partners',   '2015-07-24 03:33:54',  '2015-07-24 03:33:54',  0),
        (6, 'Contact',  'Dummy Text Text',  '2015-07-24 03:33:54',  '2015-07-24 03:33:54',  0);
        ");
    }
}

class tbl_service extends Seeder
{
    public function run()
    {
        DB::table('tbl_service')->delete();
        DB::statement("INSERT INTO `tbl_service` (`service_id`, `service_title`, `service_description`, `service_image`, `created_at`, `updated_at`, `archived`) VALUES
        (1, 'E-Learning',   'Do you want to earn a certified degree? Do you want to boost your career? Do you want to develop a skill? PROLIFE e-learning provides you with an up-to-date training system that includes modules complete with certificates. Simply by enrolling on our online learning programs, you can avail of the latest educational know-how to jump-start your career. It is a complete package designed for busy working individuals.   PROLIFE E-LEARNING is a computer and network-enabled transfer of skills and knowledge. It includes web-based learning, virtual education opportunities and digital collaboration. Content is delivered to your portal account. It can be self-paced or instructor-led and includes media in the form of text, image, animation, streaming video and audio.', '1437710882.jpg',   '2015-07-24 04:09:10',  '2015-07-24 04:10:32',  0),
        (2, 'E-Payment',    'The magic of technological advancements provides us comfort and ease of living. It’s what PROLIFE is offering with e-payments. Convenience! PROLIFE e-payment is the go-to service when it comes to on-line payments for your SSS, PAG-IBIG, Philhealth, Water and Electricity. Any time of the day.', '1437711080.jpg',   '2015-07-24 04:11:46',  '0000-00-00 00:00:00',  0),
        (3, 'E-Remit',  'How many hours have your wasted on traffic to get to an exchange house or to a bank? Have you ever experienced waiting on long queues when transferring money? PROLIFE introduces , E-REMIT service. Now, you can conveniently transfer money electronically from anywhere. You can use that extra time in doing something better or enjoyable. PROLIFE has partnered with secure, fast and reliable money transfer entities to deliver your cash right at the doorsteps of your beneficiary. With PROLIFE E-REMIT, simply log in to your portal account, fill up the details and authorize the transfer. It is as easy as One…Two…Three… ',   '1437711154.jpg',   '2015-07-24 04:12:43',  '0000-00-00 00:00:00',  0);
        ");
    }
}

class tbl_company extends Seeder
{
    public function run()
    {
        DB::table('tbl_company')->delete();
        DB::statement("INSERT INTO `tbl_company` (`company_name`, `company_email`, `company_mobile`, `company_telephone`, `company_address`) VALUES
        ('Prolife', 'admin@prolife.global', '', '', 'Office 107, Al Rigga Building, Port Said, Deira Dubai, UAE');
        ");
    }
}

class tbl_stories extends Seeder
{
    public function run()
    {
        DB::table('tbl_stories')->delete();
        DB::statement("INSERT INTO `tbl_stories` (`stories_id`, `stories_title`, `stories_link`, `stories_description`, `created_at`, `updated_at`, `archived`) VALUES
        (1, '', 'mjDVtsCQreE',  '', '2015-08-03 07:33:09',  '0000-00-00 00:00:00',  1),
        (2, 'Ms. Philippines Finalist 2014',    '1QRwW3JRDu0',  'Hello.. I am Cyra Guilalas 19 years old from Palawan, Beauty queen po ako, nag jojoin ako ng pageant, ms. world last year, ms. navotas, title holder po ako ng miss solaire, ms. palawan, ms. taytay, bikini open palawan. nag eextra po ko sa tv like home sweetie home, wonder , then meron po ako sa magazine apple soap ako po yung ambassador ngayon. so mga sinasalihan ko sobra po akong naging busy, kahit po yung mama ko nakakapansin na, yung kain ko wala na sa oras, so nung time na yun nag worry na din ako ksi nagkakaron ng mga fats di na ako yung gaya ng dati na halos rice nlang, then yung time na yon, lumapit ako sa isa kong handler, kay tita Ao, nagtanong ako sa kanya kung ano yung mas mabuting paraan para maging fit uli ako , kung ano yung pde kong maging maintenance na iinumin, so nung time na yun nirecommend nya saken itong Ultra Nutrifit Meal, so nung tinake ko ito kahit hindi ako kumain or uminom ng kahit vitamins, khit hindi ako kumain sa tamang oras, nagiging fit po ako , nagiging healthy ako, hindi kaya nung tinake ko na iba like biofit like that, nung ininom ko po yun meron pong side effects sken nag LBM po ako, hindi maganda sken. Merong time na nasa taping ako ng home sweetie home inabutan ako ng LBM dahil sa tinake ko na yun. So nung ito yung tinake ko Ultra Nutrifit Meal naging komportable ako saka lahat na all in one nandito na. Sa pagtake nito kelangan ng healthy lifestyle nandun pa din, go to gym. So i highly recommend Ultra Nutrifit Meal from the company of UltraProactive Marketing If you want to stay fit like me :)))))) Thank you po sa UltraProactive Marketing yung ganitong suplemment, sobrang nakatulong ito sa lahat ng nagttrabaho na gustong maging fit, lalo na sa beauty quenn na katulad ko na dapat maintain yung body ko, yung kasexihan ko :)))) thank you.',  '2015-08-03 07:34:22',  '2015-08-03 07:43:15',  0),
        (3, 'Retired Banker',   'Y9kWnjRsBlY',  'I\'m currently working out six seven times a week im supervise by my doctor but i realise na pwede na palang pumayat ng mabilis at the same time healthy I\'m surprise na ung satisfaction ko when I take foods in the middle of workout na provide ng \"ULTRA NUTRIFIT\" pala at the same time na iba ung feeling ko because fighting solid foods its like eating a soup even it is just a drink thats why i tend to use more .', '2015-08-03 07:43:36',  '0000-00-00 00:00:00',  0),
        (4, 'Freelance Model',  'Gp2eyvTHl8g',  'Hi I\'m Coleen I\'m 22 years old but now I have very busy schedule I have to work 6 days a week then ung one day ko rest I\'m supposed to have a excercise something to do for my fitness hindi ko siya magawa kasi minsan nasa party pa ako kaya natutulog lang ako pag ganon pero kahit ganon kahit pagod puyat ako magana akong kumain so ambilis kong tumaba ambilis kong maging chubby ampanget kasi as a dealer am also dealer model who wear sexy clothes there tapos ang hirap kasi nag kakadouble chin ako lumalaki ung braso ko I tried alot of dietary supplements and I learned na hindi siya safe kasi using the dietary like that a I ask my doctor its not safe for my kidney so I want to stop that I ask my friend and have a very sexy friend she\'s very slim I wonder why she\'s really slim but nagtratrabaho kami at the same graveyard schedule I ask her kung anong tinatake niya so inadvice niya ako she\'s taking something really safe and wala siyang side effect and all organic she give 3 bottles of \"ULTRA NUTRIFIT MEAL\" and I notice na hindi ako nagugutom na kagaya ng dati na sobrang gana ko while working na gusto ng burger and heavy meals and after that I have to go pizza parlors and eat alot and right after that matutulog na ako so after that when I woke up lagi akong akong bloated parang ang laki laki ng tiyan ko feeling ko hindi na bagay sakin ung rec ko kasi sexy siya sexy ung outfit ko kailangan maganda ung figure ko pero ang taba ko so sabi ko sa kanya bigyan niya pa ako ng konting bottles pa I bought some from her so I tried it for 2 weeks from now I got alot of changes feeling ko slim ako feeling ko ang gaan ko feeling ko sexy ako na nag gagain ako ng weight pero at the same time just the normal hindi ako malnourished hindi rin ako mataba I\'m maintaining my weight which is 45 kg. I like the result gusto ko siyang imaintain kahit mag takaw ako kahit kumain ako ng healthy foods kaya ko siyang imaintain ung weight feeling ko kasi na flaflashout ko siya agad na flaflashout ko agad ung unwatery fats ko and then ung mga toxins ko sa katawan so feeling ko healthy ako ung life style ko hindi siya maganda kasi because its a graveyard and ayon gusto ko siyang ipatry sa iba sa inyo kasi safe siya when you read the label everything is organic all are organic all are safe ingredients healthy and wala akong nakitang kahit anong side effects after using this im feeling very i\'m after the wall using this product.', '2015-08-03 07:43:53',  '0000-00-00 00:00:00',  0),
        (5, 'Physical Therapist',   '_VpMb-eZCF8',  'Hi Good Morning by the way ang pangalan ko nga pala is Marlon Dizon ang profession ko ay physical therapist and the same time invote ako sa pag mamarket ng different kinds of foods supplements when I\'m invited here in Ultra Proactive was very hesitant kasi kala its the same food supplements that i\'ve marketed and nagulat ako I was advised by friend the owner of Ultra NutraFit so sabi ko baka it just was another supplement that I\'ve been take kasi nag gygym ako tapos when I\'m taking way protein ang problema ko ung way protein nang galing pa sa ibang bansa nakakatigyawat so sabi ko baka mapasa sa katawan ko and then para mawala ung doubt ko I took one bottle nagulat ako naka skip ako ng two meals tinake ko siya ng gabi and then nung umaga tska nung lunch nag skip na ako ng meals noon tapos sabi ko very effective pala and then I continue taking it for week I lost 2kg sabi ko without workout iyon and without crash diet just taking this because its a complete replacement meal hindi ako nagugutom actually and then ang problema ko noon pag marami akong kinakausap hirap na hirap ako kasi nagugutom ako kagaad acidic nung tinake ko to nabalanse ung acidic ng tiyan ko very effective pala to and siguro ang mga matetestimony ko dito I have a long term patient ng stroke ung patient na iyon talaga hindi talaga nakakalakad hindi rin nakakapag salita binigyan ko ng three bottles nito eventually nakita ko ung improvement ngayon nagagalaw na niya ung shoulders niya nakakatayo siya which is very big improvement compared na nag tatake siya ng synthetic medication so I assure na itong product na ito napakaganda sa katawan because its corrects the immune system at the same time it function as complete nutrition meal so ang pinaka ngayong natutuwa ako kasi marami akong nakausap na athletes I\'m invote also in training of basketball team isang commercial basketball league instead of taking na vitamins ito nalang ang itatake nila kasi ang sinasabi ko sa kanila na maganda to and you will not lose muscle instead a it will act as your replacement meals sa basketball hindi ka kasing pwedeng mag pataba at yung energy mo ung sinasabi naming nating tuparin so I\'m very contented with this product',   '2015-08-03 07:44:15',  '0000-00-00 00:00:00',  0);"
        );
    }
}




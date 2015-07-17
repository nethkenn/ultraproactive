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
        DB::statement("INSERT INTO `tbl_product_category`   (`product_category_id`, `product_category_name`, `slug`, `created_at`, `updated_at`) VALUES
                                                            (1, 'test prod cat 1',  'test-prod-cat-1',  '0000-00-00 00:00:00',  '0000-00-00 00:00:00'),
                                                            (2, 'test prod cat  2', 'test-prod-cat-2',  '0000-00-00 00:00:00',  '0000-00-00 00:00:00'),
                                                            (3, 'test prod cat  3', 'test-prod-cat-3',  '0000-00-00 00:00:00',  '0000-00-00 00:00:00');"
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








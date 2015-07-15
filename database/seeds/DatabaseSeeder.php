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
        DB::statement("INSERT INTO `tbl_module` (`module_id`, `module_name`, `archived`, `url_segment`) VALUES
(1, 'Transaction / Process Sale',   0,  'sales'),
(2, 'Transaction / Process Payout', 0,  'payout'),
(3, 'Transaction / Process Claims', 0,  'claims'),
(4, 'Transaction / Unilevel Distribution',  0,  'unilevel'),
(5, 'Maintenance / Accounts',   0,  'accounts'),
(6, 'Maintenance / Membership Codes',   0,  'codes'),
(7, 'Maintenance / Package',    0,  'product_package'),
(8, 'Maintenance / Product',    0,  'product'),
(9, 'Maintenance / Slots',  0,  'slots'),
(10,    'Utitlities / Admin',   0,  'admin_maintenance'),
(11,    'Utitlities / Admin Levels',    0,  'position'),
(12,    'Utitlities / Company Settings',    0,  'setting'),
(14,    'Reports / Product Sales Report',   0,  'product_sales'),
(15,    'Reports / Membership Sales Report',    0,  'membership_sales'),
(16,    'Maintenance / Product',    0,  'country'),
(17,    'Maintenance / Deduction',  0,  'deduction'),
(18,    'Maintenance / membership', 0,  'membership'),
(19,    'Maintenance / Ranking',    0,  'ranking'),
(20,    'Maintenance / News',   0,  'news'),
(21,    'Maintenance / Earn',   0,  'earn'),
(22,    'Maintenance / Inventory',  0,  'inventory'),
(23,    'Utitlities / Computation Plan',    0,  'complan');"
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



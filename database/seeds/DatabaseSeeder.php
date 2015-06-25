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
        $this->call('tbl_country');
        $this->call('tbl_product_category');
    }
}


class tbl_country extends Seeder
{
    public function run()
    {
        DB::table('tbl_country')->delete();
        DB::statement("INSERT INTO `tbl_country` (`country_id`, `country_name`, `currency`, `rate`, `archived`) VALUES
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
        DB::statement("INSERT INTO `tbl_product_category` (`product_category_id`, `product_category_name`, `slug`, `created_at`, `updated_at`) VALUES
            (1, 'test prod cat 1',  'test-prod-cat-1',  '0000-00-00 00:00:00',  '0000-00-00 00:00:00'),
            (2, 'test prod cat  2', 'test-prod-cat-2',  '0000-00-00 00:00:00',  '0000-00-00 00:00:00'),
            (3, 'test prod cat  3', 'test-prod-cat-3',  '0000-00-00 00:00:00',  '0000-00-00 00:00:00');"
        );
    } 
}


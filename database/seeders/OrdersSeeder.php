<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            'order_id' => '202209065754',
            'customer_name' => 'Rahul Singh',
            'customer_email' => 'rahul.singh@weballures.com',
            'customer_phone' => '98674653457',
            'description' => 'Here is the Order Description',
            'user_id' => '4',
            'sub_total' => '30',
            'final_total' => '30',
            'payment_method' => 'COD',
        ]);
    }
}

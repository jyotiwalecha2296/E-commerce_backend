<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InquiriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inquiries')->insert([
            'name' => 'E-Commerce',
            'email' => 'john@gmail.com',
            'subject' => 'inquiry',
            'message' => 'I have inquiry about thus site',
            'status' => '1',
        ]);
    }
}

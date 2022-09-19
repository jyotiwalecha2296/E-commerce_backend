<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MenuType;

class MenuTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenuType::truncate();
        
        $menutypes = [
            ['title' => 'Header Menu'],
            ['title' => 'Footer Menu'],
            ['title' => 'Footer Menu Bottom'],
        ];
          
        foreach ($menutypes as $key => $value) {
            MenuType::create($value);
        }
    }
}

<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('settings')->insert([
            'application_title' => 'E-Commerce',
            'application_logo' => 'dummy-logo-white.png',
            'application_blue_logo' => 'dummy-logo-white.png',
            'footer_logo' => 'footer_logo/dummy-logo-white.png',
            'catalogue' => 'public/catalogue/images.jpeg',
            'application_favicon' => 'fav icon.png',
            'copyright' => '© E-Commerce - 2022 . All Rights Reserved.',
            'facebook_url' => 'https://www.facebook.com/',
            'instagram_url' => 'https://www.instagram.com/',
            'twitter_url' => 'https://twitter.com/',
            'youtube_url' => 'https://www.youtube.com/',
            'linkedin_url' => 'https://www.linkedin.com/company/',
            'pinterest_url' => 'https://www.pinterest.com/',
            'contact_email' => 'hello@weballures.com',
            'contact_phone' => '0097334348234',
            'admin_email' => 'admin@weballures.com',
            'meta_title' => 'E-Commerce',
            'meta_keywords' => 'Precision Time Instruments',
            'meta_description' => 'E-Commerce',
        ]);
    }
}

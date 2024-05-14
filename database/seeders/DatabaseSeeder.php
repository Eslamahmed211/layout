<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\setting;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        \App\Models\role::create([
            'name' => 'كل الصلاحيات',
            "permissions" => '["users","roles","home"]'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Eslam ahmed',
            'email' => 'admin@gmail.com',
            'password' => Hash::make("admin@gmail.com"),
            "active" => "1",
            "role" => "admin",
            "role_id" => 1,
        ]);




        Setting::insert([
            [
                "key" => "websiteName",
                "value" => "Target_Whatsapp"
            ],

            [
                "key" => "logo",
                "value" => ""
            ],

            [
                "key" => "facebook",
                "value" => ""
            ],
            [
                "key" => "instagram",
                "value" => ""
            ],
            [
                "key" => "twitter",
                "value" => ""
            ],
            [
                "key" => "tiktok",
                "value" => ""
            ],
            [
                "key" => "telegram",
                "value" => ""
            ]

        ]);
    }
}

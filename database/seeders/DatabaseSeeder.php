<?php

namespace Database\Seeders;

use App\Models\SocialNetwork;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        SocialNetwork::factory()->create([
            'name'=>'telegram',
            'url_pattern'=>'https://t.me/',
        ]);

        SocialNetwork::factory()->create([
            'name'=>'twitter',
            'url_pattern'=>'https://x.com/',
        ]);

        SocialNetwork::factory()->create([
            'name'=>'instagram',
            'url_pattern'=>'https://instagram.com/',
        ]);

        SocialNetwork::factory()->create([
            'name'=>'facebook',
            'url_pattern'=>'https://facebook.com/',
        ]);

        SocialNetwork::factory()->create([
            'name'=>'whatsapp',
            'url_pattern'=>'https://wa.me/',
        ]);
    }
}

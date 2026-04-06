<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Services\PlayerValidationService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $patterns = PlayerValidationService::getKnownPatterns();

        $categories = [
            [
                'name'            => 'Mobile Legends',
                'slug'            => 'mobile-legends',
                'publisher'       => 'Moonton',
                'description'     => 'Top up Diamond Mobile Legends: Bang Bang dengan mudah dan cepat.',
                'requires_zone_id'=> true,
                'user_id_label'   => 'User ID',
                'zone_id_label'   => 'Zone ID',
                'user_id_regex'   => $patterns['mobile-legends']['user_id_regex'],
                'zone_id_regex'   => $patterns['mobile-legends']['zone_id_regex'],
                'sort_order'      => 1,
                'is_active'       => true,
            ],
            [
                'name'            => 'Free Fire',
                'slug'            => 'free-fire',
                'publisher'       => 'Garena',
                'description'     => 'Top up Diamond Free Fire terpercaya, proses instan.',
                'requires_zone_id'=> false,
                'user_id_label'   => 'Player ID',
                'zone_id_label'   => 'Zone ID',
                'user_id_regex'   => $patterns['free-fire']['user_id_regex'],
                'zone_id_regex'   => null,
                'sort_order'      => 2,
                'is_active'       => true,
            ],
            [
                'name'            => 'PUBG Mobile',
                'slug'            => 'pubg-mobile',
                'publisher'       => 'Krafton',
                'description'     => 'Top up UC PUBG Mobile harga terbaik.',
                'requires_zone_id'=> false,
                'user_id_label'   => 'Player ID',
                'zone_id_label'   => 'Zone ID',
                'user_id_regex'   => $patterns['pubg-mobile']['user_id_regex'],
                'zone_id_regex'   => null,
                'sort_order'      => 3,
                'is_active'       => true,
            ],
            [
                'name'            => 'Genshin Impact',
                'slug'            => 'genshin-impact',
                'publisher'       => 'HoYoverse',
                'description'     => 'Top up Genesis Crystal Genshin Impact dengan aman.',
                'requires_zone_id'=> false,
                'user_id_label'   => 'UID',
                'zone_id_label'   => 'Zone ID',
                'user_id_regex'   => $patterns['genshin-impact']['user_id_regex'],
                'zone_id_regex'   => null,
                'sort_order'      => 4,
                'is_active'       => true,
            ],
            [
                'name'            => 'Valorant',
                'slug'            => 'valorant',
                'publisher'       => 'Riot Games',
                'description'     => 'Top up VP Valorant, satu-satunya mata uang premium.',
                'requires_zone_id'=> false,
                'user_id_label'   => 'Riot ID',
                'zone_id_label'   => 'Zone ID',
                'user_id_regex'   => '/^[a-zA-Z0-9 #]+$/',
                'zone_id_regex'   => null,
                'sort_order'      => 5,
                'is_active'       => true,
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}

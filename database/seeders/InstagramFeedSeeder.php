<?php

namespace Database\Seeders;

use App\Models\InstagramFeed;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class InstagramFeedSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure default settings exist
        Setting::set('instagram_section_label', 'Instagram', 'text', 'homepage');
        Setting::set('instagram_section_title', 'Follow Our Journey', 'text', 'homepage');
        Setting::set('site_instagram', '@momentsstudio', 'text', 'social');
        Setting::set('social_instagram', 'https://instagram.com/lovestudios', 'text', 'social');

        $initialPosts = [
            [
                'media_url'   => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=400&h=400&fit=crop',
                'caption'     => 'Capturing timeless wedding moments under golden light',
                'permalink'   => 'https://instagram.com/lovestudios',
                'sort_order'  => 1,
            ],
            [
                'media_url'   => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=400&h=400&fit=crop',
                'caption'     => 'Romantic couple portrait at sunset',
                'permalink'   => 'https://instagram.com/lovestudios',
                'sort_order'  => 2,
            ],
            [
                'media_url'   => 'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=400&h=400&fit=crop',
                'caption'     => 'Beautiful rings and details of love',
                'permalink'   => 'https://instagram.com/lovestudios',
                'sort_order'  => 3,
            ],
            [
                'media_url'   => 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=400&h=400&fit=crop',
                'caption'     => 'Ceremony magical vibes and outdoor setup',
                'permalink'   => 'https://instagram.com/lovestudios',
                'sort_order'  => 4,
            ],
            [
                'media_url'   => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=400&h=400&fit=crop',
                'caption'     => 'Royal Indian wedding celebration moments',
                'permalink'   => 'https://instagram.com/lovestudios',
                'sort_order'  => 5,
            ],
            [
                'media_url'   => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=400&fit=crop',
                'caption'     => 'Pre-wedding destination shoot memories',
                'permalink'   => 'https://instagram.com/lovestudios',
                'sort_order'  => 6,
            ],
        ];

        foreach ($initialPosts as $post) {
            InstagramFeed::firstOrCreate(
                ['media_url' => $post['media_url']],
                [
                    'thumbnail_url' => $post['media_url'],
                    'caption'       => $post['caption'],
                    'permalink'     => $post['permalink'],
                    'sort_order'    => $post['sort_order'],
                    'is_active'     => true,
                ]
            );
        }
    }
}

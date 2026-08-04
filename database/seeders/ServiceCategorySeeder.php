<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;

class ServiceCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Wedding Photography',
                'slug' => 'wedding-photography',
                'icon' => 'fas fa-ring',
                'description' => 'Comprehensive luxury wedding photography and cinematic films.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Pre Wedding Shoot',
                'slug' => 'pre-wedding-shoot',
                'icon' => 'fas fa-heart',
                'description' => 'Romantic and creative pre-wedding photo sessions in breathtaking locations.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Engagement',
                'slug' => 'engagement',
                'icon' => 'fas fa-gem',
                'description' => 'Capturing ring exchange ceremonies and engagement celebrations.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Maternity Shoot',
                'slug' => 'maternity-shoot',
                'icon' => 'fas fa-baby',
                'description' => 'Graceful and memorable pregnancy photography sessions.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Baby Shoot',
                'slug' => 'baby-shoot',
                'icon' => 'fas fa-baby-carriage',
                'description' => 'Newborn, infant, and kids portrait sessions.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Corporate Shoot',
                'slug' => 'corporate-shoot',
                'icon' => 'fas fa-building',
                'description' => 'Professional corporate events, executive headshots, and brand shoots.',
                'sort_order' => 6,
            ],
            [
                'name' => 'Candid Photography',
                'slug' => 'candid-photography',
                'icon' => 'fas fa-camera',
                'description' => 'Unscripted, natural, and spontaneous photo coverage.',
                'sort_order' => 7,
            ],
            [
                'name' => 'Drone Photography',
                'slug' => 'drone-photography',
                'icon' => 'fas fa-paper-plane',
                'description' => 'Aerial 4K drone videography and bird-eye venue coverage.',
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $cat) {
            ServiceCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}

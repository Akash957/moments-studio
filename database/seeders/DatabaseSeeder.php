<?php

namespace Database\Seeders;

use App\Models\Award;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Enquiry;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\Album;
use App\Models\AlbumImage;
use App\Models\HeroSlider;
use App\Models\Package;
use App\Models\PackageFeature;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Roles & Permissions ----
        if (class_exists(\Spatie\Permission\PermissionRegistrar::class)) {
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            $permissions = [
                'view_dashboard', 'manage_settings', 'manage_seo',
                'manage_sliders', 'manage_services', 'manage_gallery', 'manage_albums',
                'manage_videos', 'manage_packages', 'manage_testimonials', 'manage_awards',
                'manage_team', 'manage_blogs', 'manage_faqs',
                'manage_bookings', 'manage_quotes', 'manage_enquiries',
                'manage_newsletter', 'manage_customers', 'manage_media',
                'manage_email_templates', 'manage_roles', 'manage_users',
                'view_activity_logs', 'manage_cache',
            ];

            foreach ($permissions as $perm) {
                Permission::firstOrCreate(['name' => $perm]);
            }

            $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
            $admin = Role::firstOrCreate(['name' => 'admin']);
            $customer = Role::firstOrCreate(['name' => 'customer']);

            $superAdmin->givePermissionTo(Permission::all());
            $admin->givePermissionTo($permissions);
            $customer->givePermissionTo(['view_dashboard']);
        }

        // ---- Super Admin User ----
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@momentsstudio.in'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('Admin@123'),
                'phone'    => '+91 98765 43210',
                'role'     => 'super_admin',
                'is_active'=> true,
            ]
        );
        if (method_exists($adminUser, 'assignRole') && class_exists(\Spatie\Permission\Models\Role::class)) {
            $adminUser->assignRole('super_admin');
        }

        // Demo admin
        $admin2 = User::firstOrCreate(
            ['email' => 'manager@momentsstudio.in'],
            [
                'name'     => 'John Admin',
                'password' => Hash::make('Admin@123'),
                'role'     => 'admin',
                'is_active'=> true,
            ]
        );
        if (method_exists($admin2, 'assignRole') && class_exists(\Spatie\Permission\Models\Role::class)) {
            $admin2->assignRole('admin');
        }

        // ---- Settings ----
        $this->seedSettings();

        // ---- Hero Sliders ----
        $this->seedHeroSliders();

        // ---- Services ----
        $this->seedServices();

        // ---- Gallery ----
        $this->seedGallery();

        // ---- Albums ----
        $this->seedAlbums();

        // ---- Videos ----
        $this->seedVideos();

        // ---- Packages ----
        $this->seedPackages();

        // ---- Testimonials ----
        $this->seedTestimonials();

        // ---- Awards ----
        $this->seedAwards();

        // ---- Team ----
        $this->seedTeam();

        // ---- Blog ----
        $this->seedBlog($adminUser);

        // ---- FAQs ----
        $this->seedFaqs();

        // ---- Sample Enquiries ----
        $this->seedEnquiries();
    }

    private function seedSettings(): void
    {
        $settings = [
            // General
            ['key' => 'site_name',        'value' => 'Moments Studio',               'group' => 'general', 'label' => 'Site Name'],
            ['key' => 'site_tagline',     'value' => 'We Capture Timeless Moments',  'group' => 'general', 'label' => 'Site Tagline'],
            ['key' => 'site_description', 'value' => 'Premium wedding photography studio capturing your most precious moments with artistry and passion.', 'group' => 'general', 'label' => 'Site Description'],
            ['key' => 'site_logo',        'value' => '',                             'group' => 'general', 'label' => 'Site Logo'],
            ['key' => 'site_favicon',     'value' => '',                             'group' => 'general', 'label' => 'Site Favicon'],
            ['key' => 'site_email',       'value' => 'info@momentsstudio.in',        'group' => 'general', 'label' => 'Contact Email'],
            ['key' => 'site_phone',       'value' => '+91 98765 43210',              'group' => 'general', 'label' => 'Phone Number'],
            ['key' => 'site_whatsapp',    'value' => '919876543210',                 'group' => 'general', 'label' => 'WhatsApp Number'],
            ['key' => 'site_address',     'value' => '123, Diamond Street, New York, USA', 'group' => 'general', 'label' => 'Address'],
            ['key' => 'site_city',        'value' => 'New York',                     'group' => 'general', 'label' => 'City'],
            // Social
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/momentsstudio', 'group' => 'social', 'label' => 'Instagram'],
            ['key' => 'social_facebook',  'value' => 'https://facebook.com/momentsstudio',  'group' => 'social', 'label' => 'Facebook'],
            ['key' => 'social_youtube',   'value' => 'https://youtube.com/@momentsstudio',   'group' => 'social', 'label' => 'YouTube'],
            ['key' => 'social_pinterest', 'value' => 'https://pinterest.com/momentsstudio',  'group' => 'social', 'label' => 'Pinterest'],
            // Stats
            ['key' => 'stat_experience', 'value' => '12',  'group' => 'stats', 'label' => 'Years Experience'],
            ['key' => 'stat_weddings',   'value' => '850',  'group' => 'stats', 'label' => 'Weddings'],
            ['key' => 'stat_clients',    'value' => '1250', 'group' => 'stats', 'label' => 'Happy Clients'],
            ['key' => 'stat_awards',     'value' => '28',   'group' => 'stats', 'label' => 'Awards Won'],
            // SEO
            ['key' => 'seo_title',        'value' => 'Moments Studio — Premium Wedding Photography', 'group' => 'seo', 'label' => 'Default SEO Title'],
            ['key' => 'seo_description',  'value' => 'Moments Studio captures your most precious wedding moments with luxury photography and cinematic videography. Book your date today.',  'group' => 'seo', 'label' => 'Default Meta Description'],
            ['key' => 'seo_keywords',     'value' => 'wedding photography, wedding photographer, pre wedding photography, engagement photography, moments studio', 'group' => 'seo', 'label' => 'Default Keywords'],
            ['key' => 'google_analytics', 'value' => '',                           'group' => 'seo', 'label' => 'Google Analytics ID'],
            ['key' => 'google_maps_embed','value' => 'https://maps.google.com/maps?q=New+York&output=embed', 'group' => 'general', 'label' => 'Google Maps Embed URL'],
            // Home page
            ['key' => 'home_about_title',  'value' => "We Don't Just Take Photos,\nWe Create Masterpieces", 'group' => 'homepage', 'label' => 'About Section Title'],
            ['key' => 'home_about_text',   'value' => 'At Moments Studio, we believe every moment is unique and deserves to be remembered forever. Our passion is to turn your special moments into timeless stories.', 'group' => 'homepage', 'label' => 'About Section Text'],
            ['key' => 'home_about_image',  'value' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800', 'group' => 'homepage', 'label' => 'About Section Image'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }

    private function seedHeroSliders(): void
    {
        $sliders = [
            [
                'title'          => 'We Capture Timeless Moments',
                'subtitle'       => 'Premium Wedding Photography',
                'description'    => 'Preserving your best moments with creativity and perfection.',
                'image'          => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=1920&h=1080&fit=crop',
                'button_text'    => 'Explore Gallery',
                'button_url'     => '/gallery',
                'button_text_2'  => 'Book Now',
                'button_url_2'   => '/booking',
                'overlay_opacity'=> 0.55,
                'is_active'      => true,
                'sort_order'     => 1,
            ],
            [
                'title'          => 'Every Love Story Deserves A Perfect Frame',
                'subtitle'       => 'Cinematic Wedding Films',
                'description'    => 'Let us tell your love story through the art of photography.',
                'image'          => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=1920&h=1080&fit=crop',
                'button_text'    => 'View Packages',
                'button_url'     => '/packages',
                'button_text_2'  => 'Contact Us',
                'button_url_2'   => '/contact',
                'overlay_opacity'=> 0.5,
                'is_active'      => true,
                'sort_order'     => 2,
            ],
            [
                'title'          => 'Moments That Last Forever',
                'subtitle'       => 'Pre Wedding | Engagement | Maternity',
                'description'    => 'Creating memories that you will cherish for a lifetime.',
                'image'          => 'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=1920&h=1080&fit=crop',
                'button_text'    => 'Our Services',
                'button_url'     => '/services',
                'button_text_2'  => 'Get Quote',
                'button_url_2'   => '#quote-popup',
                'overlay_opacity'=> 0.5,
                'is_active'      => true,
                'sort_order'     => 3,
            ],
        ];

        foreach ($sliders as $slider) {
            HeroSlider::firstOrCreate(['title' => $slider['title']], $slider);
        }
    }

    private function seedServices(): void
    {
        $category = ServiceCategory::firstOrCreate(
            ['slug' => 'photography'],
            ['name' => 'Photography', 'icon' => 'fas fa-camera', 'is_active' => true, 'sort_order' => 1]
        );

        $services = [
            ['name' => 'Wedding Photography',  'slug' => 'wedding-photography',  'icon' => 'fas fa-rings-wedding', 'starting_price' => 50000, 'is_featured' => true,  'sort_order' => 1, 'tagline' => 'Capturing your perfect day', 'short_description' => 'Full-day wedding photography coverage with candid moments and posed portraits.', 'featured_image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800'],
            ['name' => 'Pre Wedding Shoot',    'slug' => 'pre-wedding-shoot',    'icon' => 'fas fa-heart',         'starting_price' => 20000, 'is_featured' => true,  'sort_order' => 2, 'tagline' => 'Your love story begins', 'short_description' => 'Romantic pre-wedding shoots at beautiful outdoor and studio locations.', 'featured_image' => 'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=800'],
            ['name' => 'Engagement',           'slug' => 'engagement',           'icon' => 'fas fa-gem',           'starting_price' => 15000, 'is_featured' => false, 'sort_order' => 3, 'tagline' => 'The promise of forever', 'short_description' => 'Beautiful engagement session capturing the joy of your new chapter.', 'featured_image' => 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=800'],
            ['name' => 'Maternity Shoot',      'slug' => 'maternity-shoot',      'icon' => 'fas fa-baby',          'starting_price' => 10000, 'is_featured' => false, 'sort_order' => 4, 'tagline' => 'Celebrating new life', 'short_description' => 'Elegant maternity photography celebrating the beauty of motherhood.', 'featured_image' => 'https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?w=800'],
            ['name' => 'Baby Shoot',           'slug' => 'baby-shoot',           'icon' => 'fas fa-baby-carriage', 'starting_price' => 8000,  'is_featured' => false, 'sort_order' => 5, 'tagline' => 'Tiny feet, big moments', 'short_description' => 'Adorable newborn and baby photography in a safe, comfortable studio environment.', 'featured_image' => 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?w=800'],
            ['name' => 'Corporate Shoot',      'slug' => 'corporate-shoot',      'icon' => 'fas fa-building',      'starting_price' => 25000, 'is_featured' => false, 'sort_order' => 6, 'tagline' => 'Professional brand imagery', 'short_description' => 'Professional corporate photography for events, profiles, and brand campaigns.', 'featured_image' => 'https://images.unsplash.com/photo-1556761175-b413da4baf72?w=800'],
            ['name' => 'Candid Photography',   'slug' => 'candid-photography',   'icon' => 'fas fa-eye',           'starting_price' => 30000, 'is_featured' => true,  'sort_order' => 7, 'tagline' => 'Unscripted, natural moments', 'short_description' => 'Authentic candid photography capturing real emotions and spontaneous moments.', 'featured_image' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=800'],
            ['name' => 'Drone Photography',    'slug' => 'drone-photography',    'icon' => 'fas fa-drone',         'starting_price' => 15000, 'is_featured' => false, 'sort_order' => 8, 'tagline' => 'A bird\'s eye perspective', 'short_description' => 'Stunning aerial photography and videography using professional drones.', 'featured_image' => 'https://images.unsplash.com/photo-1473968512647-3e447244af8f?w=800'],
        ];

        foreach ($services as $service) {
            $service['category_id'] = $category->id;
            $service['long_description'] = $service['short_description'] . ' Our experienced team ensures every shot is perfect, using state-of-the-art equipment to deliver cinematic quality results that will last a lifetime.';
            Service::firstOrCreate(['slug' => $service['slug']], $service);
        }
    }

    private function seedGallery(): void
    {
        $categories = [
            ['name' => 'Wedding',     'slug' => 'wedding',     'sort_order' => 1],
            ['name' => 'Pre Wedding', 'slug' => 'pre-wedding', 'sort_order' => 2],
            ['name' => 'Engagement',  'slug' => 'engagement',  'sort_order' => 3],
            ['name' => 'Maternity',   'slug' => 'maternity',   'sort_order' => 4],
            ['name' => 'Baby',        'slug' => 'baby',        'sort_order' => 5],
            ['name' => 'Candid',      'slug' => 'candid',      'sort_order' => 6],
        ];

        $unsplashImages = [
            'wedding' => [
                'https://images.unsplash.com/photo-1519741497674-611481863552?w=800',
                'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800',
                'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=800',
                'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=800',
                'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=800',
                'https://images.unsplash.com/photo-1513279922550-250c2129b13a?w=800',
            ],
            'pre-wedding' => [
                'https://images.unsplash.com/photo-1516589178581-6cd7833ae3b2?w=800',
                'https://images.unsplash.com/photo-1529258283598-8d6fe60b27f4?w=800',
                'https://images.unsplash.com/photo-1520854221256-17451cc331bf?w=800',
                'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=800',
            ],
            'engagement' => [
                'https://images.unsplash.com/photo-1538890369645-31b4d84890e1?w=800',
                'https://images.unsplash.com/photo-1596178065887-1198b6148b2b?w=800',
                'https://images.unsplash.com/photo-1603614015994-06e5b2a95f71?w=800',
            ],
            'maternity' => [
                'https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?w=800',
                'https://images.unsplash.com/photo-1559056961-1f4f4e7e1ccc?w=800',
            ],
            'baby' => [
                'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?w=800',
                'https://images.unsplash.com/photo-1471286174890-9c112ac6fd3a?w=800',
            ],
            'candid' => [
                'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=800',
                'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=800',
                'https://images.unsplash.com/photo-1550005809-91ad75fb315f?w=800',
            ],
        ];

        foreach ($categories as $cat) {
            $category = GalleryCategory::firstOrCreate(['slug' => $cat['slug']], array_merge($cat, ['is_active' => true]));
            $images = $unsplashImages[$cat['slug']] ?? [];
            foreach ($images as $i => $img) {
                Gallery::firstOrCreate(['image' => $img], [
                    'category_id' => $category->id,
                    'title'       => $cat['name'] . ' Photo ' . ($i + 1),
                    'image'       => $img,
                    'is_featured' => $i === 0,
                    'is_active'   => true,
                    'sort_order'  => $i,
                ]);
            }
        }
    }

    private function seedAlbums(): void
    {
        $weddingCat = GalleryCategory::where('slug', 'wedding')->first();
        $preCat = GalleryCategory::where('slug', 'pre-wedding')->first();

        $albums = [
            [
                'category_id'  => $weddingCat?->id,
                'title'        => 'Priya & Rahul — A Royal Wedding',
                'slug'         => 'priya-rahul-royal-wedding',
                'description'  => 'A magnificent royal wedding celebration filled with love and grandeur.',
                'cover_image'  => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800',
                'location'     => 'The Leela Palace, Mumbai',
                'event_date'   => '2024-02-14',
                'couple_names' => 'Priya & Rahul',
                'photographer' => 'Arjun Sharma',
                'is_featured'  => true,
                'is_active'    => true,
                'sort_order'   => 1,
            ],
            [
                'category_id'  => $weddingCat?->id,
                'title'        => 'Sneha & Vikram — Destination Wedding',
                'slug'         => 'sneha-vikram-destination-wedding',
                'description'  => 'A breathtaking destination wedding at the beautiful beaches of Goa.',
                'cover_image'  => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800',
                'location'     => 'Taj Exotica Resort, Goa',
                'event_date'   => '2024-01-20',
                'couple_names' => 'Sneha & Vikram',
                'photographer' => 'Meera Kapoor',
                'is_featured'  => true,
                'is_active'    => true,
                'sort_order'   => 2,
            ],
            [
                'category_id'  => $preCat?->id,
                'title'        => 'Ananya & Dev — Mysore Pre Wedding',
                'slug'         => 'ananya-dev-mysore-pre-wedding',
                'description'  => 'A romantic pre-wedding session in the heritage city of Mysore.',
                'cover_image'  => 'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=800',
                'location'     => 'Mysore Palace, Karnataka',
                'event_date'   => '2024-03-10',
                'couple_names' => 'Ananya & Dev',
                'photographer' => 'Arjun Sharma',
                'is_featured'  => false,
                'is_active'    => true,
                'sort_order'   => 3,
            ],
        ];

        $albumImages = [
            'https://images.unsplash.com/photo-1519741497674-611481863552?w=1200',
            'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=1200',
            'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=1200',
            'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=1200',
            'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=1200',
            'https://images.unsplash.com/photo-1513279922550-250c2129b13a?w=1200',
        ];

        foreach ($albums as $albumData) {
            $album = Album::firstOrCreate(['slug' => $albumData['slug']], $albumData);
            if ($album->images()->count() === 0) {
                foreach ($albumImages as $i => $img) {
                    AlbumImage::create([
                        'album_id'   => $album->id,
                        'image'      => $img,
                        'sort_order' => $i,
                    ]);
                }
            }
        }
    }

    private function seedVideos(): void
    {
        $videos = [
            ['title' => 'Priya & Rahul Wedding Highlights', 'slug' => 'priya-rahul-highlights', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'video_type' => 'youtube', 'duration' => '5:32', 'is_featured' => true, 'sort_order' => 1],
            ['title' => 'Sneha & Vikram Goa Wedding Film',   'slug' => 'sneha-vikram-goa',       'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'video_type' => 'youtube', 'duration' => '8:15', 'is_featured' => true, 'sort_order' => 2],
            ['title' => 'Moments Studio Showreel 2024',      'slug' => 'showreel-2024',           'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'video_type' => 'youtube', 'duration' => '3:45', 'is_featured' => false,'sort_order' => 3],
        ];

        foreach ($videos as $video) {
            $video['is_active'] = true;
            Video::firstOrCreate(['slug' => $video['slug']], $video);
        }
    }

    private function seedPackages(): void
    {
        $packages = [
            [
                'name'        => 'Basic Package',
                'slug'        => 'basic-package',
                'tagline'     => 'Perfect for intimate ceremonies',
                'description' => 'A complete photography package for small, intimate weddings.',
                'price'       => 49999,
                'currency'    => 'INR',
                'price_label' => 'Starting from',
                'badge'       => null,
                'hours'       => 4,
                'edited_photos'  => 100,
                'photographers'  => 1,
                'includes_video' => false,
                'includes_drone' => false,
                'includes_album' => false,
                'is_featured'    => false,
                'is_popular'     => false,
                'is_active'      => true,
                'sort_order'     => 1,
                'features'       => [
                    ['feature' => '4 Hours Coverage',    'is_included' => true],
                    ['feature' => '100+ Edited Photos',  'is_included' => true],
                    ['feature' => '1 Photographer',      'is_included' => true],
                    ['feature' => 'Online Gallery',       'is_included' => true],
                    ['feature' => 'Cinematic Video',      'is_included' => false],
                    ['feature' => 'Drone Shoot',          'is_included' => false],
                    ['feature' => 'Premium Album',        'is_included' => false],
                ],
            ],
            [
                'name'        => 'Premium Package',
                'slug'        => 'premium-package',
                'tagline'     => 'Most popular choice',
                'description' => 'Comprehensive coverage for your special day with cinematic film.',
                'price'       => 99999,
                'currency'    => 'INR',
                'price_label' => 'Starting from',
                'badge'       => 'Most Popular',
                'hours'       => 8,
                'edited_photos'  => 500,
                'photographers'  => 2,
                'includes_video' => true,
                'includes_drone' => false,
                'includes_album' => false,
                'is_featured'    => true,
                'is_popular'     => true,
                'is_active'      => true,
                'sort_order'     => 2,
                'features'       => [
                    ['feature' => '8 Hours Coverage',    'is_included' => true],
                    ['feature' => '500+ Edited Photos',  'is_included' => true],
                    ['feature' => '2 Photographers',     'is_included' => true],
                    ['feature' => 'Cinematic Video',     'is_included' => true],
                    ['feature' => 'Online Gallery',      'is_included' => true],
                    ['feature' => '7 Photographers',     'is_included' => false],
                    ['feature' => 'Drone Shoot',         'is_included' => false],
                ],
            ],
            [
                'name'        => 'Deluxe Package',
                'slug'        => 'deluxe-package',
                'tagline'     => 'The ultimate experience',
                'description' => 'The complete luxury wedding photography and videography experience.',
                'price'       => 199999,
                'currency'    => 'INR',
                'price_label' => 'Starting from',
                'badge'       => 'Best Value',
                'hours'       => 12,
                'edited_photos'  => 800,
                'photographers'  => 3,
                'includes_video' => true,
                'includes_drone' => true,
                'includes_album' => true,
                'is_featured'    => false,
                'is_popular'     => false,
                'is_active'      => true,
                'sort_order'     => 3,
                'features'       => [
                    ['feature' => '12 Hours Coverage',    'is_included' => true],
                    ['feature' => '800+ Edited Photos',   'is_included' => true],
                    ['feature' => '3 Photographers',      'is_included' => true],
                    ['feature' => 'Cinematic Video',      'is_included' => true],
                    ['feature' => 'Online Gallery',       'is_included' => true],
                    ['feature' => 'Drone Shoot',          'is_included' => true],
                    ['feature' => 'Premium Album',        'is_included' => true],
                    ['feature' => 'Support',              'is_included' => true],
                ],
            ],
        ];

        foreach ($packages as $pkgData) {
            $features = $pkgData['features'];
            unset($pkgData['features']);
            $package = Package::firstOrCreate(['slug' => $pkgData['slug']], $pkgData);
            if ($package->features()->count() === 0) {
                foreach ($features as $i => $feat) {
                    $package->features()->create(array_merge($feat, ['sort_order' => $i]));
                }
            }
        }
    }

    private function seedTestimonials(): void
    {
        $testimonials = [
            ['client_name' => 'Priya & Rahul Mehta',   'wedding_location' => 'Mumbai',    'review' => 'Moments Studio captured our wedding beautifully! Every photo tells a story. The photographers were professional, creative, and made us feel so comfortable.', 'rating' => 5.0, 'is_featured' => true, 'is_approved' => true, 'sort_order' => 1],
            ['client_name' => 'Ananya & Dev Sharma',    'wedding_location' => 'Delhi',     'review' => 'The best wedding photographers we have ever seen! They captured every single emotion perfectly. Our wedding album is absolutely stunning!', 'rating' => 5.0, 'is_featured' => true, 'is_approved' => true, 'sort_order' => 2],
            ['client_name' => 'Sneha & Vikram Patel',   'wedding_location' => 'Goa',       'review' => 'We are so happy with our destination wedding photos! Moments Studio went above and beyond our expectations. Highly recommend to every couple!', 'rating' => 5.0, 'is_featured' => true, 'is_approved' => true, 'sort_order' => 3],
            ['client_name' => 'Kavita & Rohan Joshi',   'wedding_location' => 'Bangalore', 'review' => 'Exceptional work! The candid shots are breathtaking and the edited photos are magazine-quality. Could not have asked for better photographers.', 'rating' => 4.5, 'is_featured' => false,'is_approved' => true, 'sort_order' => 4],
            ['client_name' => 'Divya & Karan Gupta',    'wedding_location' => 'Jaipur',    'review' => 'Simply outstanding! They captured the essence of our royal Rajasthani wedding perfectly. Every detail, every smile, every tear — preserved forever.', 'rating' => 5.0, 'is_featured' => false,'is_approved' => true, 'sort_order' => 5],
            ['client_name' => 'Meera & Aditya Singh',   'wedding_location' => 'Udaipur',   'review' => 'Our lake palace wedding photos are absolutely magical! Moments Studio has a unique eye for beauty and composition. Worth every penny!', 'rating' => 5.0, 'is_featured' => false,'is_approved' => true, 'sort_order' => 6],
        ];

        foreach ($testimonials as $t) {
            $t['is_active'] = true;
            Testimonial::firstOrCreate(['client_name' => $t['client_name']], $t);
        }
    }

    private function seedAwards(): void
    {
        $awards = [
            ['title' => 'Best Wedding Photographer of the Year',   'organization' => 'India Wedding Awards', 'year' => 2024, 'is_featured' => true,  'sort_order' => 1],
            ['title' => 'Excellence in Candid Photography',        'organization' => 'Photography Guild India','year' => 2023, 'is_featured' => true,  'sort_order' => 2],
            ['title' => 'Top 10 Wedding Photographers in India',   'organization' => 'WedMeGood Awards',      'year' => 2023, 'is_featured' => true,  'sort_order' => 3],
            ['title' => 'Best Cinematography Award',               'organization' => 'Wedding Film Festival',  'year' => 2022, 'is_featured' => false, 'sort_order' => 4],
            ['title' => 'Creative Photography Excellence Award',   'organization' => 'National Photo Awards',  'year' => 2022, 'is_featured' => false, 'sort_order' => 5],
            ['title' => 'Best Pre-Wedding Photography Studio',     'organization' => 'WeddingWire India',      'year' => 2021, 'is_featured' => false, 'sort_order' => 6],
        ];

        foreach ($awards as $award) {
            $award['is_active'] = true;
            Award::firstOrCreate(['title' => $award['title'], 'year' => $award['year']], $award);
        }
    }

    private function seedTeam(): void
    {
        $team = [
            ['name' => 'Arjun Sharma',    'designation' => 'Lead Photographer & Founder',  'experience_years' => 12, 'specializations' => ['Wedding Photography', 'Candid Photography', 'Portrait Photography'], 'instagram' => '@arjunsharma_lens', 'sort_order' => 1, 'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400'],
            ['name' => 'Meera Kapoor',    'designation' => 'Senior Cinematographer',        'experience_years' => 8,  'specializations' => ['Wedding Films', 'Drone Videography', 'Cinematic Editing'], 'instagram' => '@meera_films', 'sort_order' => 2, 'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400'],
            ['name' => 'Rohan Verma',     'designation' => 'Pre-Wedding Specialist',        'experience_years' => 6,  'specializations' => ['Pre-Wedding', 'Engagement', 'Fashion Photography'], 'instagram' => '@rohan.moments', 'sort_order' => 3, 'image' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400'],
            ['name' => 'Priya Malhotra',  'designation' => 'Creative Director & Editor',   'experience_years' => 9,  'specializations' => ['Photo Editing', 'Album Design', 'Art Direction'], 'instagram' => '@priya_creates', 'sort_order' => 4, 'image' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=400'],
        ];

        foreach ($team as $member) {
            $member['is_active'] = true;
            $member['bio'] = 'A passionate photographer with ' . $member['experience_years'] . ' years of experience in capturing beautiful moments and turning them into timeless memories.';
            TeamMember::firstOrCreate(['name' => $member['name']], $member);
        }
    }

    private function seedBlog(User $author): void
    {
        $categories = [
            ['name' => 'Wedding Tips',         'slug' => 'wedding-tips',         'color' => '#c9a96e', 'sort_order' => 1],
            ['name' => 'Photography Tips',     'slug' => 'photography-tips',     'color' => '#8b5e3c', 'sort_order' => 2],
            ['name' => 'Real Weddings',        'slug' => 'real-weddings',        'color' => '#d4a574', 'sort_order' => 3],
            ['name' => 'Behind The Scenes',    'slug' => 'behind-the-scenes',    'color' => '#c9a96e', 'sort_order' => 4],
        ];

        foreach ($categories as $cat) {
            $cat['is_active'] = true;
            BlogCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        $weddingCat = BlogCategory::where('slug', 'wedding-tips')->first();
        $photoCat = BlogCategory::where('slug', 'photography-tips')->first();

        $blogs = [
            [
                'title'         => 'How to Choose the Perfect Wedding Photographer for Your Big Day',
                'slug'          => 'how-to-choose-perfect-wedding-photographer',
                'excerpt'       => 'Choosing your wedding photographer is one of the most important decisions you will make. Here is our expert guide to finding the perfect match.',
                'content'       => '<p>Your wedding photographs are the memories that will last a lifetime. Choosing the right photographer is crucial. Here is what you need to look for...</p><h2>1. Portfolio Review</h2><p>Always review a photographer\'s full portfolio, not just their highlight reel. Look for consistency in quality, editing style, and ability to capture emotions.</p><h2>2. Meeting in Person</h2><p>Schedule a consultation to ensure you connect with your photographer. You will spend your entire wedding day with them, so personal chemistry matters.</p><h2>3. Understanding Their Style</h2><p>Are you looking for traditional posed portraits or authentic candid moments? Make sure their style aligns with your vision.</p><h2>4. Checking Reviews</h2><p>Read testimonials from previous couples to understand their experience and satisfaction levels.</p>',
                'category_id'   => $weddingCat?->id,
                'author_id'     => $author->id,
                'status'        => 'published',
                'published_at'  => now()->subDays(5),
                'is_featured'   => true,
                'featured_image'=> 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800',
                'reading_time'  => 5,
            ],
            [
                'title'         => 'Top 10 Wedding Venue Locations in India for 2024',
                'slug'          => 'top-10-wedding-venues-india-2024',
                'excerpt'       => 'Discover the most stunning wedding venues across India that will make your special day absolutely unforgettable.',
                'content'       => '<p>India is home to some of the world\'s most breathtaking wedding venues. From royal palaces to beach resorts, here are our top picks...</p><h2>1. Udaipur — The City of Lakes</h2><p>Udaipur offers stunning lake palace venues that create magical wedding photographs. The reflection of the palace in the lake creates an ethereal backdrop.</p><h2>2. Jaipur — The Pink City</h2><p>Royal forts and palaces in Jaipur provide a regal setting for destination weddings with rich cultural heritage.</p><h2>3. Goa — Beach Paradise</h2><p>Goa\'s pristine beaches offer a relaxed, romantic atmosphere perfect for destination weddings with a coastal feel.</p>',
                'category_id'   => $weddingCat?->id,
                'author_id'     => $author->id,
                'status'        => 'published',
                'published_at'  => now()->subDays(12),
                'is_featured'   => false,
                'featured_image'=> 'https://images.unsplash.com/photo-1545156521-77bd85671d30?w=800',
                'reading_time'  => 7,
            ],
            [
                'title'         => 'Tips for Perfect Candid Wedding Photography',
                'slug'          => 'tips-perfect-candid-wedding-photography',
                'excerpt'       => 'Candid photography captures the real, unscripted moments that make your wedding memories truly special.',
                'content'       => '<p>Candid photography is an art form that captures the authentic emotions of your wedding day. Here are our professional tips...</p><h2>Be Natural</h2><p>The best candid shots happen when people forget the camera is there. Trust your photographer and don\'t be afraid to be yourself.</p><h2>Lighting is Key</h2><p>Natural light creates the most beautiful candid portraits. Work with your venue to maximize natural light opportunities.</p><h2>Timing Matters</h2><p>The golden hour — shortly after sunrise or before sunset — provides magical lighting for outdoor candid shots.</p>',
                'category_id'   => $photoCat?->id,
                'author_id'     => $author->id,
                'status'        => 'published',
                'published_at'  => now()->subDays(20),
                'is_featured'   => false,
                'featured_image'=> 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=800',
                'reading_time'  => 4,
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::firstOrCreate(['slug' => $blog['slug']], $blog);
        }

        // Tags
        $tags = ['Wedding', 'Photography', 'Tips', 'Candid', 'Pre-Wedding', 'India', 'Venues', 'Love'];
        foreach ($tags as $tag) {
            BlogTag::firstOrCreate(['slug' => \Illuminate\Support\Str::slug($tag)], ['name' => $tag]);
        }
    }

    private function seedFaqs(): void
    {
        $category = FaqCategory::firstOrCreate(
            ['slug' => 'general'],
            ['name' => 'General Questions', 'icon' => 'fas fa-question-circle', 'is_active' => true, 'sort_order' => 1]
        );

        $bookingCat = FaqCategory::firstOrCreate(
            ['slug' => 'booking'],
            ['name' => 'Booking & Pricing', 'icon' => 'fas fa-calendar-check', 'is_active' => true, 'sort_order' => 2]
        );

        $faqs = [
            ['category_id' => $category->id,  'question' => 'What areas do you serve?', 'answer' => 'We serve clients across India and also accept destination wedding projects internationally. Our team has photographed weddings in Mumbai, Delhi, Goa, Rajasthan, Kerala, and many other beautiful locations.', 'sort_order' => 1],
            ['category_id' => $category->id,  'question' => 'How long have you been photographing weddings?', 'answer' => 'Moments Studio has been capturing weddings for over 12 years. Our lead photographer, Arjun Sharma, has personally covered 850+ weddings across India with consistent excellence.', 'sort_order' => 2],
            ['category_id' => $category->id,  'question' => 'What equipment do you use?', 'answer' => 'We use professional-grade Canon and Sony mirrorless cameras with premium L-series lenses. We always carry backup equipment to ensure no moments are missed.', 'sort_order' => 3],
            ['category_id' => $bookingCat->id,'question' => 'How do I book Moments Studio?', 'answer' => 'You can book us through our online booking form, WhatsApp, or by calling us directly. We recommend booking at least 6-12 months in advance for wedding dates.', 'sort_order' => 4],
            ['category_id' => $bookingCat->id,'question' => 'How much does wedding photography cost?', 'answer' => 'Our packages start from ₹49,999 for our Basic Package. Pricing depends on the duration, number of photographers, and services required. We offer customized packages to fit your needs and budget.', 'sort_order' => 5],
            ['category_id' => $bookingCat->id,'question' => 'How long does it take to receive the final photos?', 'answer' => 'We typically deliver your edited photos within 4-6 weeks after the wedding day. Rush delivery is available upon request. You will receive a private online gallery to download and share your images.', 'sort_order' => 6],
            ['category_id' => $bookingCat->id,'question' => 'Do you provide raw/unedited photos?', 'answer' => 'We do not provide raw files as our post-processing is an integral part of our artistic service. Every delivered photo is carefully edited to our signature style.', 'sort_order' => 7],
            ['category_id' => $category->id,  'question' => 'What if it rains on my wedding day?', 'answer' => 'We are prepared for all weather conditions! Rain can actually create some of the most beautiful and romantic wedding photos. We always have backup plans and equipment to handle unexpected weather.', 'sort_order' => 8],
        ];

        foreach ($faqs as $faq) {
            $faq['is_active'] = true;
            Faq::firstOrCreate(['question' => $faq['question']], $faq);
        }
    }

    private function seedEnquiries(): void
    {
        $enquiries = [
            ['name' => 'David Lee',     'email' => 'david@example.com',   'phone' => '+91 98123 45678', 'subject' => 'Wedding Photography Enquiry', 'message' => 'Hi, I am interested in your premium wedding photography package for my wedding in March 2025.', 'event_type' => 'wedding',     'status' => 'new'],
            ['name' => 'Sophia Martinez','email' => 'sophia@example.com',  'phone' => '+91 97234 56789', 'subject' => 'Pre Wedding Shoot',           'message' => 'Looking for a pre-wedding photographer for outdoor shoot in Udaipur. Please share details.', 'event_type' => 'pre-wedding', 'status' => 'read'],
            ['name' => 'James Taylor',  'email' => 'james@example.com',   'phone' => '+91 96345 67890', 'subject' => 'Candid Photography',          'message' => 'Want to book candid photography for my sister\'s engagement ceremony next month.', 'event_type' => 'engagement',  'status' => 'replied'],
            ['name' => 'Olivia Anderson','email' => 'olivia@example.com', 'phone' => '+91 95456 78901', 'subject' => 'Maternity Shoot',             'message' => 'I am expecting in 2 months and would love a beautiful maternity photoshoot session.', 'event_type' => 'maternity',   'status' => 'new'],
        ];

        foreach ($enquiries as $e) {
            $e['source'] = 'contact_form';
            Enquiry::firstOrCreate(['email' => $e['email']], $e);
        }
    }
}

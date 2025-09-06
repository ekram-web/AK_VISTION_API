<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- IMPORTANT
use Illuminate\Support\Facades\Hash; // <-- IMPORTANT

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This will wipe and re-populate the tables with sample data.
     *
     * @return void
     */
    public function run(): void
    {
        // --- 1. ADMIN USER ---
        DB::table('users')->insert([
            'name' => 'AK Vistion Admin',
            'email' => 'admin@akvistion.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // --- 2. PRODUCTS ---
        DB::table('products')->insert([
            // Cameras
            ['name' => "Analog Bullet Camera", 'main_category' => "Cameras", 'sub_category' => "Analog Cameras", 'use_case' => "Outdoor", 'description' => "Reliable and cost-effective...", 'created_at' => now(), 'updated_at' => now()],
            ['name' => "IP Dome Camera", 'main_category' => "Cameras", 'sub_category' => "IP Cameras", 'use_case' => "Indoor", 'description' => "Superior image clarity...", 'created_at' => now(), 'updated_at' => now()],
            // Recorders
            ['name' => "8-Channel NVR", 'main_category' => "Recorders", 'sub_category' => "NVR", 'channels' => 8, 'description' => "High-performance recording...", 'created_at' => now(), 'updated_at' => now()],
            // Switches
            ['name' => "8-Port PoE Switch", 'main_category' => "Switches", 'sub_category' => "PoE Switches", 'ports' => 8, 'description' => "Power up to 8 devices...", 'created_at' => now(), 'updated_at' => now()],
            // Systems
            ['name' => "Biometric Access Control", 'main_category' => "Systems", 'sub_category' => "Access Control", 'application' => "Corporate", 'description' => "Secure your premises...", 'created_at' => now(), 'updated_at' => now()],
        ]);

        // --- 3. HOMEPAGE CONTENT ---
        DB::table('homepage_data')->insert([
            ['section' => 'hero', 'content' => json_encode(['title' => 'Empowering Vision For A Safer World', 'subtitle' => 'Innovative IoT solutions with video as the core competency']), 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('featured_items')->insert([
            ['title' => 'AI Network Cameras', 'description' => 'High-performance cameras with AI analytics.', 'image_url' => 'samples/feature1.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Intelligent NVRs', 'description' => 'Reliable storage with smart search capabilities.', 'image_url' => 'samples/feature2.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('technologies')->insert([
            ['name' => 'AcuSense', 'short_desc' => 'Pinpoints human and vehicle targets.', 'long_desc' => 'Our advanced AI distinguishes between genuine threats and irrelevant movements.', 'image_url' => 'samples/tech1.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ColorVu', 'short_desc' => 'Captures vivid, full-color video 24/7.', 'long_desc' => 'Say goodbye to grainy black-and-white footage.', 'image_url' => 'samples/tech2.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('newsroom_videos')->insert([
            ['video_url' => 'samples/news1.mp4', 'created_at' => now(), 'updated_at' => now()],
            ['video_url' => 'samples/news2.mp4', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // --- 4. ABOUT PAGE CONTENT ---
        DB::table('about_page_data')->insert([
            ['section' => 'inspiring', 'content' => json_encode(['preTitle' => 'About Company', 'title' => 'Creating Inspiring Security Solutions', 'description' => 'AK VISTION is a term used to refer to an organized collection of technology...']), 'created_at' => now(), 'updated_at' => now()],
            ['section' => 'process', 'content' => json_encode(['visionTitle' => 'Our Vision', 'visionDesc' => 'To be the global leader in security...', 'missionTitle' => 'Our Mission', 'missionDesc' => 'To provide state-of-the-art systems...']), 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('statistics')->insert([
            ['label' => 'Years Of Experience', 'value' => '15', 'created_at' => now(), 'updated_at' => now()],
            ['label' => 'Success Projects', 'value' => '600', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('team_members')->insert([
            ['name' => 'William Lucas', 'title' => 'Co Founder', 'image_url' => 'samples/team1.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('partners')->insert([
            ['name' => 'Intazphp ar', 'logo_url' => 'samples/partner1.png', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // --- 5. BLOG POSTS ---
        DB::table('blog_posts')->insert([
            [
                'title' => 'The Future of AI in Video Surveillance', 'excerpt' => 'Explore how AI is revolutionizing the industry...',
                'category' => 'Technology', 'author' => 'John Smith', 'date' => 'March 15, 2024',
                'read_time' => '5 min read', 'image_url' => 'samples/blog1.jpg', 'created_at' => now(), 'updated_at' => now()
            ],
        ]);

        // --- (You can add more seeders for other tables like FAQs, Services, etc., following this same pattern) ---
    }
}

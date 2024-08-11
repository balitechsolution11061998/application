<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('posts')->insert([
            [
                'title' => 'How to Use Facial Expressions in Public Speaking',
                'image_url' => 'https://example.com/assets/img/blog-img-1.jpg',
                'description' => 'Learn how to use facial expressions to enhance your public speaking skills.',
                'publish_date' => '2030-12-11',
                'comments_count' => 383,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The Ultimate Guide to Public Speaking',
                'image_url' => 'https://example.com/assets/img/blog-img-2.jpg',
                'description' => 'A comprehensive guide to mastering the art of public speaking.',
                'publish_date' => '2031-01-15',
                'comments_count' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more sample data as needed
        ]);
    }
}

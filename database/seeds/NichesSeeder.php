<?php

use Illuminate\Database\Seeder;
use App\Niche;

class NichesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Niche::create(['name' => 'News']);
        Niche::create(['name' => 'Technology/Computer']);
        Niche::create(['name' => 'Business']);
        Niche::create(['name' => 'Finance']);
        Niche::create(['name' => 'Health & Wellnes & Fitness']);
        Niche::create(['name' => 'Art & Photography']);
        Niche::create(['name' => 'Family and Children']);
        Niche::create(['name' => 'Animals & Pets/Pests']);
        Niche::create(['name' => 'Home Improvement/Gardening']);
        Niche::create(['name' => 'Fashion/Wedding']);
        Niche::create(['name' => 'Automotive']);
        Niche::create(['name' => 'Law']);
        Niche::create(['name' => 'Education / Training']);
        Niche::create(['name' => 'Music']);
        Niche::create(['name' => 'Dating/Relationship']);
        Niche::create(['name' => 'Environmental/Eco Friendly']);
        Niche::create(['name' => 'Sports']);
        Niche::create(['name' => 'Real Estate']);
        Niche::create(['name' => 'Hospitality & Tourism']);
        Niche::create(['name' => 'Entertainment']);
        Niche::create(['name' => 'Poetry']);
        Niche::create(['name' => 'Books']);
    }
}

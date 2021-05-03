<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
                "Science, Engineering & Technology",
                "Arts, Social Science & Humanities",
                "Physical Sciences & Environment",
                "Management & Commerce",
                "Agriculture & Veterinary Science",
                "Biological & Medical Science"
        ];
        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }

    }
}

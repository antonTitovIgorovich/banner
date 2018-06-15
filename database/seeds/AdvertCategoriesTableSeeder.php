<?php

use Illuminate\Database\Seeder;
use App\Entity\Advert\Category;

class AdvertCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        factory(Category::class, 10)->create()->each(
            function (Category $category) {

                $counts = [0, random_int(3, 7)];
                $category->children()->saveMany(

                    factory(Category::class, $counts[array_rand($counts)])->create()->each(
                        function (Category $category) {

                            $counts = [0, random_int(3, 7)];
                            $category->children()->saveMany(factory(Category::class, $counts[array_rand($counts)])->create());
                        }));
            });
    }
}

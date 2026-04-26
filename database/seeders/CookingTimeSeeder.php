<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Seeder;

class CookingTimeSeeder extends Seeder
{
    public function run(): void
    {
        $cookingTimes = [
            'Asado' => 120,
            'kabse' => 60,
            'Sushi' => 45,
            'Migas' => 35,
            'Bistek' => 40,
            'Borsch' => 90,
            'Hummus' => 10,
            'Ezme' => 15,
            'Tamiya' => 30,
            'Kumpir' => 50,
            'Timbits' => 20,
            'Big Mac' => 25,
        ];

        foreach ($cookingTimes as $name => $time) {
            Meal::where('strMeal', $name)->update(['cooking_time' => $time]);
        }
    }
}
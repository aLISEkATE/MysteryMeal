<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index()
    {
        return response()->json(Meal::all());
    }

    private function formatIngredients($meal): array
    {
        $ingredients = [];

        for ($i = 1; $i <= 20; $i++) {
            $ingredient = $meal->{'strIngredient' . $i};
            $measure = $meal->{'strMeasure' . $i};

            if (!empty(trim($ingredient))) {
                $name = trim($ingredient);

                $ingredients[] = [
                    'ingredient' => $name,
                    'measure' => trim($measure),
                    'image' => "https://www.themealdb.com/images/ingredients/" . urlencode(strtolower($name)) . ".png"
                ];
            }
        }

        return $ingredients;
    }

    public function show($id)
    {
        $meal = Meal::find($id);
        
        if (!$meal) {
            return response()->json(['message' => 'Not found'], 404);
        }
        
        return response()->json($meal);
    }

    public function recipes(Request $request)
    {
        $ingredientsInput = $request->input('ingredients', '');
        $maxTime = $request->input('max_time');
        
        $requestedIngredients = collect(explode(',', $ingredientsInput))
            ->map(fn($item) => trim(strtolower($item)))
            ->filter()
            ->values()
            ->all();

        // Get API meals
        $meals = Meal::all();

        // Get user-created recipes
        $userRecipes = \App\Models\UserRecipe::where('user_id', auth()->id())->get();

        // Convert user recipes to same format as API meals
        $formattedUserRecipes = $userRecipes->map(function ($userRecipe) {
            $ingredientsList = is_array($userRecipe->ingredients) 
                ? $userRecipe->ingredients 
                : json_decode($userRecipe->ingredients, true);
            
            return (object)[
                'id' => 'user_' . $userRecipe->id,
                'idMeal' => 'user_' . $userRecipe->id,
                'strMeal' => $userRecipe->title,
                'strMealAlternate' => null,
                'strCategory' => $userRecipe->category,
                'strArea' => 'User Recipe',
                'strInstructions' => $userRecipe->instructions,
                'strMealThumb' => $userRecipe->image ?? 'https://via.placeholder.com/300x300?text=My+Recipe',
                'strTags' => null,
                'strYoutube' => null,
                'strIngredient1' => $ingredientsList[0] ?? '',
                'strIngredient2' => $ingredientsList[1] ?? '',
                'strIngredient3' => $ingredientsList[2] ?? '',
                'strIngredient4' => $ingredientsList[3] ?? '',
                'strIngredient5' => $ingredientsList[4] ?? '',
                'strMeasure1' => '',
                'strMeasure2' => '',
                'strMeasure3' => '',
                'strMeasure4' => '',
                'strMeasure5' => '',
                'strSource' => null,
                'is_user_recipe' => true,
                'user_recipe_id' => $userRecipe->id,
                'cooking_time' => $userRecipe->cooking_time,
            ];
        });

        // Merge API meals with user recipes
        $allRecipes = $meals->concat($formattedUserRecipes);

        // Filter by ingredients
        if (!empty($requestedIngredients)) {
            $allRecipes = $allRecipes->filter(function ($meal) use ($requestedIngredients) {
                if (property_exists($meal, 'is_user_recipe') && $meal->is_user_recipe) {
                    $mealIngredients = [];
                    for ($i = 1; $i <= 20; $i++) {
                        $ingredient = property_exists($meal, 'strIngredient' . $i) 
                            ? strtolower($meal->{'strIngredient' . $i}) 
                            : '';
                        if (!empty($ingredient)) {
                            $mealIngredients[] = $ingredient;
                        }
                    }
                } else {
                    $mealIngredients = collect(range(1, 20))
                        ->map(fn($i) => trim(strtolower($meal->{'strIngredient' . $i})))
                        ->filter()
                        ->all();
                }

                foreach ($requestedIngredients as $requested) {
                    $found = false;
                    foreach ($mealIngredients as $mealIngredient) {
                        if (str_contains($mealIngredient, $requested)) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        return false;
                    }
                }
                return true;
            })->values();
        }

        // Filter by cooking time
        if (!empty($maxTime)) {
            $allRecipes = $allRecipes->filter(function ($meal) use ($maxTime) {
                $cookingTime = $meal->cooking_time ?? null;
                if ($cookingTime === null) {
                    return true;
                }
                return $cookingTime <= intval($maxTime);
            })->values();
        }

        // Calculate AI match percentages
        foreach ($allRecipes as $meal) {
            if (property_exists($meal, 'is_user_recipe') && $meal->is_user_recipe) {
                $mealIngredients = [];
                for ($i = 1; $i <= 20; $i++) {
                    $ingredient = property_exists($meal, 'strIngredient' . $i) 
                        ? strtolower($meal->{'strIngredient' . $i}) 
                        : '';
                    if (!empty($ingredient)) {
                        $mealIngredients[] = $ingredient;
                    }
                }
            } else {
                $mealIngredients = collect(range(1, 20))
                    ->map(fn($i) => trim(strtolower($meal->{'strIngredient' . $i})))
                    ->filter()
                    ->values()
                    ->all();
            }
            
            if (empty($requestedIngredients)) {
                $meal->missing_percentage = 100;
                $meal->missing_count = count($mealIngredients);
                $meal->matched_percentage = 0;
            } else {
                $matchedCount = 0;
                foreach ($mealIngredients as $mealIngredient) {
                    foreach ($requestedIngredients as $userIngredient) {
                        if (str_contains($mealIngredient, $userIngredient)) {
                            $matchedCount++;
                            break;
                        }
                    }
                }
                
                $totalIngredients = count($mealIngredients);
                $percentage = $totalIngredients > 0 ? ($matchedCount / $totalIngredients) * 100 : 0;
                
                $meal->missing_percentage = round(100 - $percentage, 1);
                $meal->missing_count = $totalIngredients - $matchedCount;
                $meal->matched_percentage = round($percentage, 1);
            }
        }

        return view('recipes', [
            'meals' => $allRecipes,
            'searchIngredients' => $ingredientsInput,
            'requestedIngredients' => $requestedIngredients,
        ]);
    }

    public function viewRecipe($id)
    {
        // Check if it's a user recipe (starts with 'user_')
        if (str_starts_with($id, 'user_')) {
            $userRecipeId = str_replace('user_', '', $id);
            $userRecipe = \App\Models\UserRecipe::where('user_id', auth()->id())
                                               ->findOrFail($userRecipeId);
            
            // Format user recipe for the view
            $ingredientsList = is_array($userRecipe->ingredients) 
                ? $userRecipe->ingredients 
                : json_decode($userRecipe->ingredients, true);
            $measuresList = is_array($userRecipe->measures) 
                ? $userRecipe->measures 
                : json_decode($userRecipe->measures, true);
            
            $ingredients = [];
            foreach ($ingredientsList as $index => $ingredient) {
                $ingredients[] = [
                    'name' => $ingredient,
                    'measure' => $measuresList[$index] ?? ''
                ];
            }
            
            $meal = (object)[
                'id' => 'user_' . $userRecipe->id,
                'strMeal' => $userRecipe->title,
                'strCategory' => $userRecipe->category,
                'strArea' => 'Your Recipe',
                'strInstructions' => $userRecipe->instructions,
                'strMealThumb' => $userRecipe->image ?? 'https://via.placeholder.com/400x400?text=My+Recipe',
                'strYoutube' => null,
                'strSource' => null,
                'strTags' => null,
                'is_user_recipe' => true,
                'cooking_time' => $userRecipe->cooking_time,
            ];
            
            return view('recipe', ['meal' => $meal, 'ingredients' => $ingredients]);
        }
        
        // Original code for API recipes
        $meal = Meal::find($id);
        
        if (!$meal) {
            abort(404, 'Recipe not found');
        }

        // Get all ingredients and measures for this meal
        $ingredients = [];
        for ($i = 1; $i <= 20; $i++) {
            $ingredient = $meal->{'strIngredient' . $i};
            $measure = $meal->{'strMeasure' . $i};
            
            if (!empty(trim($ingredient))) {
                $ingredients[] = [
                    'name' => trim($ingredient),
                    'measure' => trim($measure)
                ];
            }
        }
        
        return view('recipe', ['meal' => $meal, 'ingredients' => $ingredients]);
    }

    public function getMissingIngredients($meal, $userIngredients)
    {
        $mealIngredients = collect(range(1, 20))
            ->map(fn($i) => trim(strtolower($meal->{'strIngredient' . $i})))
            ->filter()
            ->values()
            ->all();
        
        $missing = array_diff($mealIngredients, $userIngredients);
        
        $totalIngredients = count($mealIngredients);
        $matchedIngredients = $totalIngredients - count($missing);
        $percentage = ($matchedIngredients / $totalIngredients) * 100;
        
        return [
            'missing' => $missing,
            'percentage' => round($percentage, 1),
            'hasEnough' => $percentage >= 50
        ];
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(Meal $meal)
    {
        //
    }

    public function update(Request $request, Meal $meal)
    {
        //
    }

    public function destroy(Meal $meal)
    {
        //
    }
}
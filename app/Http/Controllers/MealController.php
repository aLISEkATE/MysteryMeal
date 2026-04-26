<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        return response()->json(Meal::all());
        return view('recipes', compact('meals'));

    $meals = Meal::all();

    foreach ($meals as $meal) {
        $meal->ingredients_list = $this->formatIngredients($meal);
    }
  
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
        $requestedIngredients = collect(explode(',', $ingredientsInput))
            ->map(fn($item) => trim(strtolower($item)))
            ->filter()
            ->values()
            ->all();

        $apiMeals = null;
        $meals = Meal::all();

        if (!empty($requestedIngredients)) {
            $apiMeals = $this->searchTheMealDb($requestedIngredients);
            $meals = collect();
        }

        return view('recipes', [
            'meals' => $meals,
            'apiMeals' => $apiMeals,
            'searchIngredients' => $ingredientsInput,
            'requestedIngredients' => $requestedIngredients,
        ]);
    }

    public function viewApiRecipe($id)
    {
        $meal = $this->lookupTheMealDb($id);

        if (!$meal) {
            abort(404, 'Recipe not found');
        }

        return view('recipe', ['meal' => $meal, 'ingredients' => $meal['ingredients'] ?? []]);
    }

    private function searchTheMealDb(array $ingredients)
    {
        $apiKey = env('THEMEALDB_API_KEY', '1');
        $commonIds = null;

        foreach ($ingredients as $ingredient) {
            $response = Http::get("https://www.themealdb.com/api/json/v1/{$apiKey}/filter.php", [
                'i' => $ingredient,
            ]);

            if (!$response->ok()) {
                return collect();
            }

            $meals = collect($response->json('meals') ?: []);
            if ($meals->isEmpty()) {
                return collect();
            }

            $ids = $meals->pluck('idMeal');
            $commonIds = $commonIds === null ? $ids : $commonIds->intersect($ids);

            if ($commonIds->isEmpty()) {
                return collect();
            }
        }

        return $commonIds->map(fn($id) => $this->lookupTheMealDb($id))->filter()->values();
    }

    private function lookupTheMealDb(string $id)
    {
        $apiKey = env('THEMEALDB_API_KEY', '1');
        $response = Http::get("https://www.themealdb.com/api/json/v1/{$apiKey}/lookup.php", [
            'i' => $id,
        ]);

        if (!$response->ok()) {
            return null;
        }

        $meal = $response->json('meals.0');
        if (!$meal) {
            return null;
        }

        $meal['ingredients'] = collect(range(1, 20))
            ->map(fn($i) => [
                'name' => trim(data_get($meal, "strIngredient{$i}")) ?? '',
                'measure' => trim(data_get($meal, "strMeasure{$i}")) ?? '',
            ])
            ->filter(fn($item) => !empty($item['name']))
            ->values()
            ->all();

        return $meal;
    }

    public function viewRecipe($id)
    {
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meal $meal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meal $meal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        //
    }
}

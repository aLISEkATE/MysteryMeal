<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

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

        $meals = Meal::all();

        if (!empty($requestedIngredients)) {
            $meals = $meals->filter(function ($meal) use ($requestedIngredients) {
                $mealIngredients = collect(range(1, 20))
                    ->map(fn($i) => trim(strtolower($meal->{'strIngredient' . $i})))
                    ->filter()
                    ->all();

                foreach ($requestedIngredients as $requested) {
                    if (!collect($mealIngredients)->contains(fn($ingredient) => str_contains($ingredient, $requested))) {
                        return false;
                    }
                }

                return true;
            })->values();
        }

        return view('recipes', [
            'meals' => $meals,
            'searchIngredients' => $ingredientsInput,
            'requestedIngredients' => $requestedIngredients,
        ]);
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

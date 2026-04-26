<?php

namespace App\Http\Controllers;

use App\Models\UserRecipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRecipeController extends Controller
{
    public function index()
    {
        $recipes = UserRecipe::where('user_id', Auth::id())
                            ->latest()
                            ->get();
        return view('my-recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('my-recipes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'instructions' => 'required|string',
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'required|string',
            'measures' => 'nullable|array',
            'measures.*' => 'nullable|string',
            'cooking_time' => 'nullable|integer|min:1',
            'image' => 'nullable|url'
        ]);

        // Prepare ingredients and measures
        $ingredients = $request->ingredients;
        $measures = $request->measures ?? array_fill(0, count($ingredients), '');
        
        // Remove empty ingredients
        $filtered = [];
        $filteredMeasures = [];
        foreach ($ingredients as $key => $ingredient) {
            if (!empty(trim($ingredient))) {
                $filtered[] = trim($ingredient);
                $filteredMeasures[] = trim($measures[$key] ?? '');
            }
        }

        $userRecipe = new UserRecipe();
        $userRecipe->user_id = Auth::id();
        $userRecipe->title = $validated['title'];
        $userRecipe->category = $validated['category'] ?? 'Uncategorized';
        $userRecipe->instructions = $validated['instructions'];
        $userRecipe->ingredients = json_encode($filtered);
        $userRecipe->measures = json_encode($filteredMeasures);
        $userRecipe->cooking_time = $validated['cooking_time'] ?? null;
        $userRecipe->image = $validated['image'] ?? null;
        $userRecipe->save();

        return redirect()->route('my-recipes.index')
                        ->with('success', 'Recipe added successfully!');
    }

    public function show($id)
    {
        $recipe = UserRecipe::where('user_id', Auth::id())
                           ->findOrFail($id);
        return view('my-recipes.show', compact('recipe'));
    }

    public function edit($id)
    {
        $recipe = UserRecipe::where('user_id', Auth::id())
                           ->findOrFail($id);
        return view('my-recipes.edit', compact('recipe'));
    }

    public function update(Request $request, $id)
    {
        $recipe = UserRecipe::where('user_id', Auth::id())
                           ->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'instructions' => 'required|string',
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'required|string',
            'measures' => 'nullable|array',
            'measures.*' => 'nullable|string',
            'cooking_time' => 'nullable|integer|min:1',
            'image' => 'nullable|url'
        ]);

        $ingredients = $request->ingredients;
        $measures = $request->measures ?? array_fill(0, count($ingredients), '');
        
        $filtered = [];
        $filteredMeasures = [];
        foreach ($ingredients as $key => $ingredient) {
            if (!empty(trim($ingredient))) {
                $filtered[] = trim($ingredient);
                $filteredMeasures[] = trim($measures[$key] ?? '');
            }
        }

        $recipe->title = $validated['title'];
        $recipe->category = $validated['category'] ?? 'Uncategorized';
        $recipe->instructions = $validated['instructions'];
        $recipe->ingredients = json_encode($filtered);
        $recipe->measures = json_encode($filteredMeasures);
        $recipe->cooking_time = $validated['cooking_time'] ?? null;
        $recipe->image = $validated['image'] ?? null;
        $recipe->save();

        return redirect()->route('my-recipes.index')
                        ->with('success', 'Recipe updated successfully!');
    }

    public function destroy($id)
    {
        $recipe = UserRecipe::where('user_id', Auth::id())
                           ->findOrFail($id);
        $recipe->delete();

        return redirect()->route('my-recipes.index')
                        ->with('success', 'Recipe deleted successfully!');
    }
}
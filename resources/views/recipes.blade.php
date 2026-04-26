<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">
            Recipes
        </h2>
    </x-slot>

    <div class="page">
        <div class="search-panel" style="margin-bottom: 24px;">
            <form method="GET" action="{{ route('recipes') }}" style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
                <label for="ingredients" style="font-weight:600;">Available ingredients:</label>
                <input id="ingredients" name="ingredients" type="text" value="{{ old('ingredients', $searchIngredients ?? '') }}" placeholder="Milk, cheese, pasta" style="flex:1; min-width:240px; padding:12px 14px; border:1px solid #d1d5db; border-radius:8px;" />
                <button type="submit" class="btn btn-blue" style="padding: 12px 20px;">Find recipes</button>
            </form>

            @if(!empty($requestedIngredients))
                <p style="margin-top:12px; color:#4b5563;">Searching for recipes with: <strong>{{ implode(', ', $requestedIngredients) }}</strong></p>
            @endif
        </div>

        @php
            $results = $apiMeals ?? $meals;
        @endphp

        @if($results->count())
            <div class="recipes">
                @foreach($results as $meal)
                    @php
                        $isApi = isset($apiMeals);
                        $detailUrl = $isApi
                            ? route('recipe.api.view', ['id' => data_get($meal, 'idMeal')])
                            : route('recipe.view', ['id' => data_get($meal, 'id')]);
                        $ingredients = data_get($meal, 'ingredients', []);
                        if (empty($ingredients)) {
                            $ingredients = collect(range(1, 20))
                                ->map(function ($i) use ($meal) {
                                    return [
                                        'ingredient' => trim(data_get($meal, "strIngredient{$i}")) ?? '',
                                        'measure' => trim(data_get($meal, "strMeasure{$i}")) ?? '',
                                    ];
                                })
                                ->filter(fn($item) => !empty($item['ingredient']))
                                ->values()
                                ->all();
                        }
                    @endphp

                    <a href="{{ $detailUrl }}" class="recipe-card" style="text-decoration: none; color: inherit; cursor: pointer;">
                        @if(data_get($meal, 'strMealThumb'))
                            <div class="recipe-image">
                                <img src="{{ data_get($meal, 'strMealThumb') }}" alt="{{ data_get($meal, 'strMeal') }}">
                            </div>
                        @endif

                        <div class="recipe-body">
                            <h2 class="recipe-name">
                                {{ data_get($meal, 'strMeal') }}
                            </h2>

                            <div class="meta">
                                @if(data_get($meal, 'strCategory'))
                                    <span class="badge badge-blue">
                                        {{ data_get($meal, 'strCategory') }}
                                    </span>
                                @endif

                                @if(data_get($meal, 'strArea'))
                                    <span class="badge badge-green">
                                        {{ data_get($meal, 'strArea') }}
                                    </span>
                                @endif
                            </div>

                            @if(data_get($meal, 'strTags'))
                                <div class="tags">
                                    @foreach(explode(',', data_get($meal, 'strTags')) as $tag)
                                        <span class="tag">{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            @endif

                            @if(data_get($meal, 'strInstructions'))
                                <div class="instructions">
                                    <h3>Instructions</h3>
                                    <p>{{ data_get($meal, 'strInstructions') }}</p>
                                </div>
                            @endif

                            @if(count($ingredients))
                                <div class="ingredients">
                                    <h3>Ingredients</h3>

                                    @foreach($ingredients as $item)
                                       <div class="ingredient-row" style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">

                                            <span style="flex:1;">
                                                {{ data_get($item, 'ingredient', data_get($item, 'name', '')) }}
                                            </span>

                                            <span style="font-weight:600;">
                                                {{ data_get($item, 'measure', '') }}
                                            </span>

                                        </div>
                                    @endforeach

                                </div>
                            @endif

                            <div class="links">
                                @if(data_get($meal, 'strYoutube'))
                                    <a href="{{ data_get($meal, 'strYoutube') }}" target="_blank" class="btn btn-red">
                                        Watch on YouTube
                                    </a>
                                @endif

                                @if(data_get($meal, 'strSource'))
                                    <a href="{{ data_get($meal, 'strSource') }}" target="_blank" class="btn btn-blue">
                                        View Source
                                    </a>
                                @endif
                            </div>

                            <div class="extra">
                                @if(data_get($meal, 'idMeal'))
                                    <p>Meal ID: {{ data_get($meal, 'idMeal') }}</p>
                                @endif

                                @if(data_get($meal, 'dateModified'))
                                    <p>Updated: {{ data_get($meal, 'dateModified') }}</p>
                                @endif
                            </div>

                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="warning">
                @if(!empty($requestedIngredients))
                    No recipes match your available ingredients.
                @else
                    No recipes found.
                @endif
            </div>
        @endif

    </div>
</x-app-layout>
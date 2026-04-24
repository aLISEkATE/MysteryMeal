<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">
            Recipes
        </h2>
    </x-slot>

    <div class="page">
        @if($meals->count())
            <div class="recipes">

                @foreach($meals as $meal)
                    <a href="{{ route('recipe.view', $meal->id) }}" class="recipe-card" style="text-decoration: none; color: inherit; cursor: pointer;">


                        @if($meal->strMealThumb)
                            <div class="recipe-image">
                                <img src="{{ $meal->strMealThumb }}" alt="{{ $meal->strMeal }}">
                            </div>
                        @endif

                        <div class="recipe-body">

                            <h2 class="recipe-name">
                                {{ $meal->strMeal }}
                            </h2>

                            <div class="meta">
                                @if($meal->strCategory)
                                    <span class="badge badge-blue">
                                        {{ $meal->strCategory }}
                                    </span>
                                @endif

                                @if($meal->strArea)
                                    <span class="badge badge-green">
                                        {{ $meal->strArea }}
                                    </span>
                                @endif
                            </div>

                            @if($meal->strTags)
                                <div class="tags">
                                    @foreach(explode(',', $meal->strTags) as $tag)
                                        <span class="tag">{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            @endif

                            @if($meal->strInstructions)
                                <div class="instructions">
                                    <h3>Instructions</h3>
                                    <p>{{ $meal->strInstructions }}</p>
                            </div>
                        @endif

                        @php
                            $ingredients = [];
                            for ($i = 1; $i <= 20; $i++) {
                                $ingredient = $meal->{'strIngredient' . $i};
                                $measure = $meal->{'strMeasure' . $i};

                                if (!empty(trim($ingredient)) || !empty(trim($measure))) {
                                    $ingredients[] = [
                                        'ingredient' => trim($ingredient),
                                        'measure' => trim($measure)
                                    ];
                                }
                            }
                        @endphp

                        @if(count($ingredients))
                            <div class="ingredients">
                                <h3>Ingredients</h3>

                                @foreach($ingredients as $item)
                                   <div class="ingredient-row" style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">

                                        <img 
                                            src="{{ $item['image'] }}" 
                                            alt="{{ $item['ingredient'] }}"
                                            style="width:40px; height:40px; object-fit:contain;"
                                            onerror="this.style.display='none'"
                                        >

                                        <span style="flex:1;">
                                            {{ $item['ingredient'] }}
                                        </span>

                                        <span style="font-weight:600;">
                                            {{ $item['measure'] }}
                                        </span>

                                    </div>
                                @endforeach

                            </div>
                        @endif

                        <div class="links">
                            @if($meal->strYoutube)
                                <a href="{{ $meal->strYoutube }}" target="_blank" class="btn btn-red">
                                    Watch on YouTube
                                </a>
                            @endif

                            @if($meal->strSource)
                                <a href="{{ $meal->strSource }}" target="_blank" class="btn btn-blue">
                                    View Source
                                </a>
                            @endif
                        </div>

                        <div class="extra">
                            @if($meal->idMeal)
                                <p>Meal ID: {{ $meal->idMeal }}</p>
                            @endif

                            @if($meal->dateModified)
                                <p>Updated: {{ $meal->dateModified }}</p>
                            @endif
                        </div>

                    </div>
                </a>
            @endforeach

        </div>
    @else
        <div class="warning">
            No recipes found.
        </div>
    @endif

    </div>
</x-app-layout>
<x-app-layout>


    <style>
        .page.recipe-page {
            padding: 32px 18px;
        }
        .search-panel {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
            border-radius: 24px;
            padding: 24px;
            margin-bottom: 28px;
        }
        .search-panel form {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 14px;
            align-items: center;
        }
        .search-panel label {
            font-weight: 700;
            color: #111827;
            margin: 0;
        }
        .search-panel input {
            width: 100%;
            min-width: 0;
            padding: 14px 16px;
            border: 1px solid #d1d5db;
            border-radius: 14px;
            background: #f8fafc;
            color: #111827;
        }
        .search-panel button {
            padding: 12px 20px;
        }
        .search-note {
            margin-top: 12px;
            color: #4b5563;
        }
        .recipes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            align-items: stretch;
            grid-auto-rows: 1fr;
        }
        .recipes-grid > a.recipe-card {
            display: flex !important;
            flex-direction: column !important;
            height: 100% !important;
            min-height: 0 !important;
            width: 100%;
            background: #fff;
            border: 1px solid #ffe3ec;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 24px 48px rgba(0, 0, 0, 0.08);
            transition: transform 180ms ease, box-shadow 180ms ease;
            text-decoration: none;
            color: inherit;
            margin: 0;
        }
        .recipes-grid > a.recipe-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 28px 56px rgba(0, 0, 0, 0.12);
        }
        .recipes-grid > a.recipe-card .recipe-content {
            display: flex;
            flex-direction: column;
            gap: 28px;
            padding: 32px;
            flex: 1;
            min-height: 0;
        }
        .recipes-grid > a.recipe-card .recipe-image {
            width: 100%;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            background: #f8fafc;
            min-height: 200px;
            max-height: 300px;
        }
        .recipes-grid > a.recipe-card .recipe-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .recipes-grid > a.recipe-card .recipe-body {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 18px;
            flex: 1;
        }
        .recipe-name {
            margin: 0;
            font-size: 1.2rem;
            line-height: 1.3;
            color: #111827;
        }
        .meta,
        .recipe-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 20px;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 13px;
            border-radius: 9999px;
            font-size: 0.82rem;
            font-weight: 700;
            border: 1px solid transparent;
        }
        .badge-blue {
            background: #eff6ff;
            color: #1d4ed8;
        }
        .badge-green {
            background: #dcfce7;
            color: #166534;
        }
        .tags,
        .recipe-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .tag {
            background: #fff1f5;
            color: #d63384;
            padding: 5px 12px;
            border-radius: 9999px;
            font-size: 0.85rem;
        }
        .recipe-excerpt {
            color: #475569;
            line-height: 1.75;
            max-height: 5.4rem;
            overflow: hidden;
        }
        .ingredients {
            display: grid;
            gap: 10px;
        }
        .ingredient-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 15px;
            border-bottom: 1px solid #ffd6a5;
        }
        .recipes-grid > a.recipe-card .links {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: auto;
        }
        .btn-mini {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            border-radius: 9999px;
            border: 1px solid transparent;
            font-weight: 700;
            font-size: 0.9rem;
            transition: background-color 180ms ease, color 180ms ease, border-color 180ms ease;
            cursor: pointer;
        }
        .btn-small-blue {
            color: #1d4ed8;
            border-color: #bfdbfe;
            background: #eff6ff;
        }
        .btn-small-red {
            color: #b91c1c;
            border-color: #fecaca;
            background: #fff1f2;
        }
        .warning {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 24px;
            border-radius: 18px;
            max-width: 720px;
            margin-top: 16px;
        }
        .ai-insight {
            margin-top: 12px;
            padding: 12px;
            background: #f0f9ff;
            border-radius: 12px;
        }
        .favorite-btn {
            margin-top: 16px;
        }
        @media (max-width: 900px) {
            .recipes-grid > a.recipe-card .recipe-content {
                padding: 22px;
            }
        }
        @media (max-width: 640px) {
            .recipes-grid > a.recipe-card {
                border-radius: 18px;
            }
            .search-panel form {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="page recipe-page">
        <div class="search-panel">
    <form method="GET" action="{{ route('recipes') }}">
        <div style="display: flex; flex-direction: column; gap: 16px;">
            <div style="display: grid; grid-template-columns: 1fr auto; gap: 14px; align-items: center;">
                <label for="ingredients">Available ingredients:</label><br>
                <input id="ingredients" name="ingredients" type="text" value="{{ old('ingredients', $searchIngredients ?? '') }}" placeholder="Milk, cheese, pasta" />
                    <br>
                    @if(!empty($requestedIngredients)) 
            <p class="search-note">Searching for recipes with: <strong>{{ implode(', ', $requestedIngredients) }}</strong></p>
                  @endif
            </div>
            
            <!-- Cooking Time Filter -->
            <div style="display: flex; align-items: center; gap: 12px; padding-top: 12px; border-top: 1px solid #e5e7eb;">
                <label for="max_time" style="margin: 0; white-space: nowrap;">⏱️ Max Cooking Time:</label>
                <select name="max_time" id="max_time" style="padding: 10px 16px; border-radius: 14px; border: 1px solid #d1d5db; background: #f8fafc;">
                    <option value="">Any time</option>
                    <option value="30" {{ request('max_time') == '30' ? 'selected' : '' }}>Under 30 minutes</option>
                    <option value="60" {{ request('max_time') == '60' ? 'selected' : '' }}>Under 1 hour</option>
                    <option value="90" {{ request('max_time') == '90' ? 'selected' : '' }}>Under 1.5 hours</option>
                    <option value="120" {{ request('max_time') == '120' ? 'selected' : '' }}>Under 2 hours</option>
                </select>
            </div>
            <button type="submit" class="btn btn-blue">Find recipes</button>
        </div>
    </form>


</div>

        @if($meals->count())
            <div class="recipes-grid">
                @foreach($meals as $meal)
                    @php
                        $detailUrl = route('recipe.view', ['id' => data_get($meal, 'id')]);
                        $ingredients = collect(range(1, 20))
                            ->map(function ($i) use ($meal) {
                                return [
                                    'name' => trim(data_get($meal, "strIngredient{$i}")) ?? '',
                                    'measure' => trim(data_get($meal, "strMeasure{$i}")) ?? '',
                                ];
                            })
                            ->filter(fn($item) => !empty($item['name']))
                            ->values()
                            ->all();
                    @endphp

                    <a href="{{ $detailUrl }}" class="recipe-card">
                        <div class="recipe-content">
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

                                        @if(property_exists($meal, 'is_user_recipe') && $meal->is_user_recipe)
                                            <span class="badge" style="background: #fef3c7; color: #92400e;">
                                                📝 Your Recipe
                                            </span>
                                        @endif

                                        @php
                                            $cookingTime = null;
                                            if (property_exists($meal, 'is_user_recipe') && $meal->is_user_recipe) {
                                                $cookingTime = $meal->cooking_time ?? null;
                                            } else {
                                                $cookingTime = $meal->cooking_time ?? null;
                                            }
                                        @endphp
                                        @if($cookingTime)
                                            <span class="badge" style="background: #fef3c7; color: #92400e;">
                                                ⏱️ {{ $cookingTime }} min
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

                                <!-- AI Analysis - INSIDE recipe-body but BEFORE favorite button -->
                                @if(!empty($requestedIngredients))
                                <div class="ai-insight" style="margin-top: 12px; padding: 12px; background: #f0f9ff; border-radius: 12px;">
                                    <div style="font-size: 0.85rem; color: #0369a1;">
                                        🤖 AI Analysis: 
                                        @if(isset($meal->missing_count) && $meal->missing_count == 0)
                                            ✅ You have ALL ingredients! You can make this recipe right now!
                                        @elseif(isset($meal->matched_percentage))
                                            🍽️ You have {{ $meal->matched_percentage }}% of the ingredients needed
                                            <div style="background: #e2e8f0; border-radius: 10px; height: 6px; margin-top: 6px;">
                                                <div style="background: #10b981; width: {{ $meal->matched_percentage }}%; height: 6px; border-radius: 10px;"></div>
                                            </div>
                                            <small>Missing {{ $meal->missing_count }} ingredient(s) to make {{ $meal->strMeal }}</small>
                                            
                                            @if(isset($meal->missing_list) && count($meal->missing_list) > 0 && $meal->missing_count <= 3)
                                                <div style="margin-top: 8px;">
                                                    <strong>You need:</strong> 
                                                    {{ implode(', ', array_slice($meal->missing_list, 0, 3)) }}
                                                    @if($meal->missing_count > 3)
                                                        and {{ $meal->missing_count - 3 }} more
                                                    @endif
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endif

                                <!-- Favorite Button -->
                                @auth
                                <div class="favorite-btn" style="margin-top: 16px;">
                                    @php
                                        $isFavorite = Auth::user()->favorites()->where('meal_id', $meal->id)->exists();
                                    @endphp
                                    @if($isFavorite)
                                        <form action="{{ route('favorites.destroy', $meal->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-mini btn-small-red">❤️ Remove</button>
                                        </form>
                                    @else
                                        <form action="{{ route('favorites.store', $meal->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-mini btn-small-blue">🤍 Save to Favorites</button>
                                        </form>
                                    @endif
                                </div>
                            @endauth
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
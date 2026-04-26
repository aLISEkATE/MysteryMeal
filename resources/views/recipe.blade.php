<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">
            {{ data_get($meal, 'strMeal') }}
        </h2>
    </x-slot>

    <div class="page">
        <div class="recipe-card" style="display: block;">

            @if(data_get($meal, 'strMealThumb'))
                <div class="recipe-image">
                    <img src="{{ data_get($meal, 'strMealThumb') }}" alt="{{ data_get($meal, 'strMeal') }}" style="width: 100%; max-height: 400px; object-fit: cover;">
                </div>
            @endif

            <div class="recipe-body">

                <!-- Recipe Meta Info -->
                <div class="meta" style="margin-bottom: 20px;">
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
                    <div class="tags" style="margin-bottom: 20px;">
                        @foreach(explode(',', data_get($meal, 'strTags')) as $tag)
                            <span class="tag">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                @endif

                <!-- Instructions -->
                @if(data_get($meal, 'strInstructions'))
                    <div class="instructions" style="margin-bottom: 30px;">
                        <h3 style="margin-bottom: 15px; color: #ff8fb1;">Instructions</h3>
                        <p style="white-space: pre-wrap; line-height: 1.6;">{{ data_get($meal, 'strInstructions') }}</p>
                    </div>
                @endif

                @php
                    $ingredients = $ingredients ?? [];
                    if (empty($ingredients)) {
                        $ingredients = [];
                        for ($i = 1; $i <= 20; $i++) {
                            $ingredientName = trim(data_get($meal, "strIngredient{$i}"));
                            $measure = trim(data_get($meal, "strMeasure{$i}"));

                            if ($ingredientName !== '') {
                                $ingredients[] = [
                                    'name' => $ingredientName,
                                    'measure' => $measure,
                                ];
                            }
                        }
                    }
                @endphp

                <!-- Ingredients & Measures -->
                @if(count($ingredients) > 0)
                    <div class="ingredients" style="margin-bottom: 30px;">
                        <h3 style="margin-bottom: 15px; color: #ff8fb1;">Ingredients</h3>

                        <div style="border: 2px solid #ffd6a5; padding: 0;">
                            @foreach($ingredients as $index => $item)
                                <div class="ingredient-row" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 15px; border-bottom: 1px solid #ffd6a5;">
                                    <span style="font-weight: bold; color: #ff7aa2;">{{ $item['name'] }}</span>
                                    <span style="color: #6b6b8f; font-weight: bold;">
                                        @if(!empty($item['measure']))
                                            {{ $item['measure'] }}
                                        @else
                                            —
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Links -->
                <div class="links" style="display: flex; gap: 15px; margin-top: 30px; flex-wrap: wrap;">
                    <a href="{{ route('recipes') }}" class="btn" style="padding: 10px 20px;">
                        ← Back to Recipes
                    </a>

                    @if(data_get($meal, 'strYoutube'))
                        <a href="{{ data_get($meal, 'strYoutube') }}" target="_blank" class="btn" style="padding: 10px 20px; border-color: #ff6b6b; color: #ff6b6b;">
                            📺 Watch on YouTube
                        </a>
                    @endif

                    @if(data_get($meal, 'strSource'))
                        <a href="{{ data_get($meal, 'strSource') }}" target="_blank" class="btn" style="padding: 10px 20px; border-color: #6aa9ff; color: #6aa9ff;">
                            🔗 View Source
                        </a>
                    @endif
                </div>

                <!-- Extra Info -->
                <div class="extra" style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd;">
                    @if(data_get($meal, 'idMeal'))
                        <p><strong>Meal ID:</strong> {{ data_get($meal, 'idMeal') }}</p>
                    @endif
                    @if(data_get($meal, 'dateModified'))
                        <p><strong>Last Updated:</strong> {{ data_get($meal, 'dateModified') }}</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

</x-app-layout>

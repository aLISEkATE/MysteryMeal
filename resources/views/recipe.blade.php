<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">
            {{ $meal->strMeal }}
        </h2>
    </x-slot>

    <div class="page">
        <div class="recipe-card" style="display: block;">
            
            @if($meal->strMealThumb)
                <div class="recipe-image">
                    <img src="{{ $meal->strMealThumb }}" alt="{{ $meal->strMeal }}" style="width: 100%; max-height: 400px; object-fit: cover;">
                </div>
            @endif

            <div class="recipe-body">
                
                <!-- Recipe Meta Info -->
                <div class="meta" style="margin-bottom: 20px;">
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
                    <div class="tags" style="margin-bottom: 20px;">
                        @foreach(explode(',', $meal->strTags) as $tag)
                            <span class="tag">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                @endif

                <!-- Instructions -->
                @if($meal->strInstructions)
                    <div class="instructions" style="margin-bottom: 30px;">
                        <h3 style="margin-bottom: 15px; color: #ff8fb1;">Instructions</h3>
                        <p style="white-space: pre-wrap; line-height: 1.6;">{{ $meal->strInstructions }}</p>
                    </div>
                @endif

                <!-- Ingredients & Measures -->
                @if(count($ingredients) > 0)
                    <div class="ingredients" style="margin-bottom: 30px;">
                        <h3 style="margin-bottom: 15px; color: #ff8fb1;">Ingredients</h3>
                        
                        <div style="border: 2px solid #ffd6a5; padding: 0;">
                            @foreach($ingredients as $index => $item)
                                <div class="ingredient-row" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 15px; @if($index % 2 == 0) background: #fffaf0; @endif border-bottom: 1px solid #ffd6a5;">
                                    <span style="font-weight: bold; color: #ff7aa2;">{{ $item['name'] }}</span>
                                    <span style="color: #6b6b8f; font-weight: bold;">
                                        @if($item['measure'])
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

                    @if($meal->strYoutube)
                        <a href="{{ $meal->strYoutube }}" target="_blank" class="btn" style="padding: 10px 20px; border-color: #ff6b6b; color: #ff6b6b;">
                            📺 Watch on YouTube
                        </a>
                    @endif

                    @if($meal->strSource)
                        <a href="{{ $meal->strSource }}" target="_blank" class="btn" style="padding: 10px 20px; border-color: #6aa9ff; color: #6aa9ff;">
                            🔗 View Source
                        </a>
                    @endif
                </div>

                <!-- Extra Info -->
                <div class="extra" style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd;">
                    @if($meal->idMeal)
                        <p><strong>Meal ID:</strong> {{ $meal->idMeal }}</p>
                    @endif
                    @if($meal->dateModified)
                        <p><strong>Last Updated:</strong> {{ $meal->dateModified }}</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

</x-app-layout>

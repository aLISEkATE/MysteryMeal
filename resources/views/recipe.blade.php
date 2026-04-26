<x-app-layout>


    <style>
        .recipe-page {
            padding: 32px 18px;
        }
        .recipe-card {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #ffe3ec;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 24px 48px rgba(0,0,0,0.08);
        }
        .recipe-content {
            display: flex;
            flex-direction: column;
            gap: 28px;
            padding: 32px;
        }
        .recipe-image {
                width: 50%;
                aspect-ratio: 1 / 1;
                border-radius: 20px;
                overflow: hidden;
                background: #f8fafc;
                align-self: anchor-center;
        }
        .recipe-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .recipe-body {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .links {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: auto;
        }
        .recipe-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 20px;
        }
        .recipe-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .recipe-tags .tag {
            background: #fff1f5;
            color: #d63384;
            padding: 5px 12px;
            border-radius: 9999px;
            font-size: 0.85rem;
        }
        .instructions h3,
        .ingredients h3 {
            margin-bottom: 15px;
        }
        .ingredient-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 15px;
            border-bottom: 1px solid #ffd6a5;
        }
        .extra {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .extra p {
            margin: 0.35rem 0;
            color: #575757;
        }
        @media (max-width: 900px) {
            .recipe-content {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 640px) {
            .recipe-card {
                border-radius: 18px;
            }
            .recipe-content {
                padding: 22px;
            }
        }
    </style>



    <div class="page recipe-page">
        <div class="recipe-card">
            <div class="recipe-content" style="display:flex; flex-direction:column; gap:28px; padding:32px;">
                @if(data_get($meal, 'strMealThumb'))
                    <div class="recipe-image">
                        <img src="{{ data_get($meal, 'strMealThumb') }}" alt="{{ data_get($meal, 'strMeal') }}">
                    </div>
                @endif




                <div class="recipe-body" style="display:flex; flex-direction:column; gap:18px; flex:1; min-height:0;">

        <h2 class="dashboard-title">
            {{ data_get($meal, 'strMeal') }} <br><br>
        </h2> 

                <!-- Recipe Meta Info -->
                <div class="meta recipe-meta">


        

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
                    <div class="tags recipe-tags">
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
                <div class="links">
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
    </div>
</x-app-layout>

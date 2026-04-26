<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">{{ $recipe->title }}</h2>
    </x-slot>

    <div style="max-width: 800px; margin: 0 auto; padding: 32px 24px;">
        <div style="background: white; border-radius: 24px; padding: 32px;">
            @if($recipe->image)
                <img src="{{ $recipe->image }}" style="width: 100%; border-radius: 16px; margin-bottom: 24px;">
            @endif

            <div style="display: flex; gap: 12px; margin-bottom: 24px;">
                <span style="background: #eff6ff; padding: 6px 12px; border-radius: 9999px;">{{ $recipe->category }}</span>
                @if($recipe->cooking_time)
                    <span style="background: #dcfce7; padding: 6px 12px; border-radius: 9999px;">⏱️ {{ $recipe->cooking_time }} min</span>
                @endif
            </div>

            <h3 style="margin-bottom: 12px;">Ingredients</h3>
            <ul style="margin-bottom: 24px;">
                @php
                    // Ensure ingredients is an array
                    $ingredients = is_array($recipe->ingredients) 
                        ? $recipe->ingredients 
                        : json_decode($recipe->ingredients, true);
                    $measures = is_array($recipe->measures) 
                        ? $recipe->measures 
                        : json_decode($recipe->measures, true);
                @endphp
                
                @foreach($ingredients as $index => $ingredient)
                    <li style="padding: 8px 0;">
                        <strong>{{ $ingredient }}</strong> 
                        @if(isset($measures[$index]) && $measures[$index])
                            - {{ $measures[$index] }}
                        @endif
                    </li>
                @endforeach
            </ul>

            <h3 style="margin-bottom: 12px;">Instructions</h3>
            <p style="white-space: pre-wrap; line-height: 1.6;">{{ $recipe->instructions }}</p>

            <div style="margin-top: 32px;">
                <a href="{{ route('my-recipes.edit', $recipe->id) }}" style="background: #3b82f6; color: white; padding: 10px 20px; border-radius: 9999px; text-decoration: none;">Edit Recipe</a>
                <a href="{{ route('my-recipes.index') }}" style="background: #f3f4f6; color: #374151; padding: 10px 20px; border-radius: 9999px; text-decoration: none; margin-left: 12px;">Back</a>
            </div>
        </div>
    </div>
</x-app-layout>
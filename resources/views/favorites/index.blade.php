<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">My Favorite Recipes ❤️</h2>
    </x-slot>

    <style>
        .favorites-container { padding: 32px 18px; }
        .favorites-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-top: 24px;
        }
        .favorite-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid #ffe3ec;
            box-shadow: 0 24px 48px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }
        .favorite-card:hover { transform: translateY(-3px); }
        .favorite-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .favorite-info { padding: 20px; }
        .remove-fav {
            background: #fff1f2;
            color: #b91c1c;
            padding: 8px 16px;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            margin-top: 12px;
        }
        .empty-favorites {
            text-align: center;
            padding: 60px;
            background: #f8fafc;
            border-radius: 24px;
        }
    </style>

    <div class="favorites-container">
        <div class="search-panel">
        </div>

        @if($favorites->count())
            <div class="favorites-grid">
                @foreach($favorites as $favorite)
                    <div class="favorite-card">
                        <a href="{{ route('recipe.view', $favorite->meal_id) }}">
                            <img src="{{ $favorite->meal->strMealThumb }}" alt="{{ $favorite->meal->strMeal }}">
                        </a>
                        <div class="favorite-info">
                            <h3>{{ $favorite->meal->strMeal }}</h3>
                            <p>{{ $favorite->meal->strCategory }} • {{ $favorite->meal->strArea }}</p>
                            <form action="{{ route('favorites.destroy', $favorite->meal_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-fav">❤️ Remove from Favorites</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-favorites">
                <h3>No favorites yet!</h3>
                <p>Browse recipes and click the heart icon to save your favorites.</p>
                <a href="{{ route('recipes') }}" class="btn btn-blue" style="display: inline-block; margin-top: 20px;">Browse Recipes</a>
            </div>
        @endif
    </div>
</x-app-layout>
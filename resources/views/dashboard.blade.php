<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">
            MysteryMeal
        </h2>
    </x-slot>

    <div class="dashboard-container">

        <div class="dashboard-grid">

            <a href="{{ route('recipes') }}" class="card link-card">
                <h3>🍲 Recipes</h3>
                <p>Search recipes by ingredients</p>
            </a>

            <a href="/minigame" class="card link-card">
                <h3>🎮 Play Game</h3>
                <p>Catch falling food items!</p>
            </a>

            <a href="{{ route('favorites.index') }}" class="card link-card">
                <h3>⭐ Favorites</h3>
                <p>View your saved recipes</p>
            </a>

            <a href="{{ route('my-recipes.index') }}" class="card link-card">
                <h3>📝 My Recipes</h3>
                <p>Add and manage your own recipes</p>
            </a>

        </div>

    </div>
</x-app-layout>
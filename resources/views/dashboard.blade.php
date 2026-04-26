<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">
            MysteryMeal
        </h2>
    </x-slot>

    <div class="dashboard-container">


        <!-- -->
        <div class="dashboard-grid">

            <a href="{{ route('recipes') }}" class="card link-card">
                <h3>🍲 Recipes</h3>
            </a>
            <a href="/minigame" class="card link-card">
                <h3>🍲 Play Game</h3>
            </a>

             <!-- href= route('favorites.index') }} -->
            <div class="card link-card" style="opacity: 0.6; cursor: not-allowed;">
                <h3>⭐ Favorites</h3>
                <p>View your saved items.</p>
            </div>

        </div>

    </div>
</x-app-layout>
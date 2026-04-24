<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">
            Dashboard
        </h2>
    </x-slot>

    <div class="dashboard-container">

        <!-- Welcome Box -->
        <div class="card">
            <p>You're logged in!</p>
        </div>

        <!-- -->
        <div class="dashboard-grid">

            <a href="{{ route('recipes') }}" class="card link-card">
                <h3>🍲 Recipes</h3>
                <p>Browse and manage recipes.</p>
            </a>
 <!--   href= route('game.play') }}-->
            <div class="card link-card" style="opacity: 0.6; cursor: not-allowed;">
                <h3>🎮 Play Game</h3>
                <p>Start playing and earn points.</p>
            </div>


             <!-- href= route('favorites.index') }} -->
            <div class="card link-card" style="opacity: 0.6; cursor: not-allowed;">
                <h3>⭐ Favorites</h3>
                <p>View your saved items.</p>
            </div>

        </div>

        <!-- Highscores -->
        <div class="card">
            <h3>🏆 Highscores</h3>

            <p class="muted">Top players will appear here.</p>

            <table class="score-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Score</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ExampleUser</td>
                        <td>1200</td>
                        <td>2026-04-24</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
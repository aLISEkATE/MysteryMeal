<nav class="main-nav">
    <div class="nav-container">
        
<div class="current-page">
@php
    $pageName = '';
    if (request()->routeIs('dashboard')) {
        $pageName = 'MysteryMeal';
    } elseif (request()->routeIs('recipes')) {
        $pageName = '🍲 Recipes';
    } elseif (request()->is('minigame')) {
        $pageName = '🎮 Catch & Cook - Minigame';
    } elseif (request()->routeIs('favorites.*')) {
        $pageName = '⭐ Favorites';
    } elseif (request()->routeIs('my-recipes.*')) {
        $pageName = '📝 My Recipes';
    } elseif (request()->routeIs('recipe.view')) {
        // Get the recipe name from the route parameter
        $recipeId = request()->route('id');
        
        // Check if it's a user recipe
        if (str_starts_with($recipeId, 'user_')) {
            $userRecipeId = str_replace('user_', '', $recipeId);
            $userRecipe = \App\Models\UserRecipe::find($userRecipeId);
            $pageName = $userRecipe ? '🍽️ ' . $userRecipe->title : '🍽️ Recipe Details';
        } else {
            // API recipe
            $meal = \App\Models\Meal::find($recipeId);
            $pageName = $meal ? '🍽️ ' . $meal->strMeal : '🍽️ Recipe Details';
        }
    } elseif (request()->routeIs('profile.edit')) {
        $pageName = '👤 Profile';
    } else {
        $pageName = '🍽️ MysteryMeal';
    }
@endphp
    <span class="current-page-name">{{ $pageName }}</span>
</div>
        
        <div class="nav-links">
            <a href="/dashboard" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                📊 Dashboard
            </a>
            <a href="{{ route('recipes') }}" class="nav-link {{ request()->routeIs('recipes') ? 'active' : '' }}">
                🍲 Recipes
            </a>
            <a href="/minigame" class="nav-link {{ request()->is('minigame') ? 'active' : '' }}">
                🎮 Game
            </a>
            <a href="{{ route('favorites.index') }}" class="nav-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}">
                ⭐ Favorites
            </a>
            <a href="{{ route('my-recipes.index') }}" class="nav-link {{ request()->routeIs('my-recipes.*') ? 'active' : '' }}">
                📝 My Recipes
            </a>
        </div>
        
        <div class="nav-user">
            @auth
                <div class="user-dropdown">
                    <button class="user-btn">
                        {{ Auth::user()->name }}
                    </button>
                    <div class="dropdown-content">
                        <a href="{{ route('profile.edit') }}">👤 Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="logout-btn">🚪 Logout</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>

<style>
    .main-nav {
        background: white;
        border-bottom: 2px solid #ffe3ec;
        padding: 0 24px;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .nav-container {
        max-width: 1400px;
        max-height: 100px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 32px;
        padding: 12px 0;
    }
    
    .nav-logo-img {
        height: 40px;
        width: auto;
    }
    
    .nav-links {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .nav-link {
        padding: 8px 16px;
        text-decoration: none;
        color: #4b5563;
        border-radius: 9999px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .nav-link:hover {
        background: #fef3c7;
        color: #d97706;
    }
    
    .nav-link.active {
        background: #ff8fb1;
        color: white;
    }
    
    .user-btn {
        background: #f3f4f6;
        border: none;
        padding: 8px 16px;
        border-radius: 9999px;
        cursor: pointer;
        font-weight: 500;
    }
    
    .user-dropdown {
        position: relative;
        display: inline-block;
    }
    
    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background: white;
        min-width: 160px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        border-radius: 12px;
        z-index: 1;
    }
    
    .user-dropdown:hover .dropdown-content {
        display: block;
    }
    
    .dropdown-content a, .logout-btn {
        display: block;
        padding: 12px 16px;
        text-decoration: none;
        color: #374151;
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }
    
    .dropdown-content a:hover, .logout-btn:hover {
        background: #f3f4f6;
    }
    
    @media (max-width: 768px) {
        .nav-container {
            flex-direction: column;
            gap: 12px;
        }
        .nav-links {
            justify-content: center;
        }
    }






</style>
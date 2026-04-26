<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">My Recipes</h2>
    </x-slot>

    <style>
        .recipes-container {
            padding: 32px 18px;
        }
        .btn-add {
            background: #3b82f6;
            color: white;
            padding: 12px 24px;
            border-radius: 9999px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 24px;
        }
        .recipes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
        }
        .recipe-card {
            background: white;
            border-radius: 24px;
            border: 1px solid #ffe3ec;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .recipe-image {
            width: 100%;
            height: 180px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
        }
        .recipe-info {
            padding: 20px;
        }
        .recipe-title {
            font-size: 1.2rem;
            margin-bottom: 8px;
        }
        .recipe-meta {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 12px;
        }
        .recipe-actions {
            display: flex;
            gap: 12px;
            margin-top: 16px;
        }
        .btn-edit {
            background: #eff6ff;
            color: #1d4ed8;
            padding: 6px 12px;
            border-radius: 9999px;
            text-decoration: none;
            font-size: 0.85rem;
        }
        .btn-delete {
            background: #fff1f2;
            color: #b91c1c;
            padding: 6px 12px;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            font-size: 0.85rem;
        }
        .empty-state {
            text-align: center;
            padding: 60px;
            background: #f8fafc;
            border-radius: 24px;
        }
    </style>

    <div class="recipes-container">
        <a href="{{ route('my-recipes.create') }}" class="btn-add">+ Add New Recipe</a>

        @if(session('success'))
            <div style="background: #dcfce7; color: #166534; padding: 12px; border-radius: 12px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if($recipes->count())
            <div class="recipes-grid">
                @foreach($recipes as $recipe)
                    <div class="recipe-card">
                        @if($recipe->image)
                            <img src="{{ $recipe->image }}" class="recipe-image" style="object-fit: cover;">
                        @else
                            <div class="recipe-image">📝 No Image</div>
                        @endif
                        <div class="recipe-info">
                            <h3 class="recipe-title">{{ $recipe->title }}</h3>
                            <div class="recipe-meta">
                                {{ $recipe->category }} 
                                @if($recipe->cooking_time) • {{ $recipe->cooking_time }} min @endif
                            </div>
                            <p style="color: #666; font-size: 0.9rem;">
                                {{ Str::limit($recipe->instructions, 100) }}
                            </p>
                            <div class="recipe-actions">
                                <a href="{{ route('my-recipes.show', $recipe->id) }}" class="btn-edit">View</a>
                                <a href="{{ route('my-recipes.edit', $recipe->id) }}" class="btn-edit">Edit</a>
                                <form action="{{ route('my-recipes.destroy', $recipe->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Delete this recipe?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <h3>No recipes yet!</h3>
                <p style="margin: 16px 0;">Click the "Add New Recipe" button to create your first recipe.</p>
            </div>
        @endif
    </div>
</x-app-layout>
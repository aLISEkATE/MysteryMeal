<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">Edit Recipe: {{ $recipe->title }}</h2>
    </x-slot>

    <div style="max-width: 800px; margin: 0 auto; padding: 32px 24px;">
        <form action="{{ route('my-recipes.update', $recipe->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 700; margin-bottom: 8px;">Recipe Title *</label>
                <input type="text" name="title" required value="{{ $recipe->title }}" style="width: 100%; padding: 12px; border-radius: 14px; border: 1px solid #d1d5db;">
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 700; margin-bottom: 8px;">Category</label>
                <select name="category" style="width: 100%; padding: 12px; border-radius: 14px;">
                    <option value="">Select Category</option>
                    <option value="Breakfast" {{ $recipe->category == 'Breakfast' ? 'selected' : '' }}>Breakfast</option>
                    <option value="Lunch" {{ $recipe->category == 'Lunch' ? 'selected' : '' }}>Lunch</option>
                    <option value="Dinner" {{ $recipe->category == 'Dinner' ? 'selected' : '' }}>Dinner</option>
                    <option value="Dessert" {{ $recipe->category == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 700; margin-bottom: 8px;">Ingredients *</label>
                <div id="ingredients-container">
                    @foreach($recipe->ingredients as $index => $ingredient)
                        <div class="ingredient-row" style="display: flex; gap: 12px; margin-bottom: 12px;">
                            <input type="text" name="ingredients[]" value="{{ $ingredient }}" style="flex: 2; padding: 12px; border-radius: 14px;" required>
                            <input type="text" name="measures[]" value="{{ $recipe->measures[$index] ?? '' }}" style="flex: 1; padding: 12px; border-radius: 14px;" placeholder="Amount">
                            <button type="button" onclick="this.parentElement.remove()" style="background: #fee2e2; border: none; border-radius: 8px; cursor: pointer;">❌</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" onclick="addIngredient()" style="background: #eff6ff; padding: 8px 16px; border-radius: 9999px; border: none; cursor: pointer;">+ Add Another Ingredient</button>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 700; margin-bottom: 8px;">Instructions *</label>
                <textarea name="instructions" required style="width: 100%; padding: 12px; border-radius: 14px; min-height: 150px;">{{ $recipe->instructions }}</textarea>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 700; margin-bottom: 8px;">Cooking Time (minutes)</label>
                <input type="number" name="cooking_time" value="{{ $recipe->cooking_time }}" style="width: 100%; padding: 12px; border-radius: 14px;">
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 700; margin-bottom: 8px;">Image URL</label>
                <input type="url" name="image" value="{{ $recipe->image }}" style="width: 100%; padding: 12px; border-radius: 14px;">
            </div>

            <button type="submit" style="background: #3b82f6; color: white; padding: 14px 28px; border-radius: 9999px; border: none; cursor: pointer;">Update Recipe</button>
            <a href="{{ route('my-recipes.index') }}" style="background: #f3f4f6; color: #374151; padding: 14px 28px; border-radius: 9999px; text-decoration: none; margin-left: 12px;">Cancel</a>
        </form>
    </div>

    <script>
        function addIngredient() {
            const container = document.getElementById('ingredients-container');
            const newRow = document.createElement('div');
            newRow.className = 'ingredient-row';
            newRow.style.display = 'flex';
            newRow.style.gap = '12px';
            newRow.style.marginBottom = '12px';
            newRow.innerHTML = `
                <input type="text" name="ingredients[]" placeholder="Ingredient name" style="flex: 2; padding: 12px; border-radius: 14px;" required>
                <input type="text" name="measures[]" placeholder="Amount" style="flex: 1; padding: 12px; border-radius: 14px;">
                <button type="button" onclick="this.parentElement.remove()" style="background: #fee2e2; border: none; border-radius: 8px; cursor: pointer;">❌</button>
            `;
            container.appendChild(newRow);
        }
    </script>
</x-app-layout>
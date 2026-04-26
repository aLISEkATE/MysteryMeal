<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">Add New Recipe</h2>
    </x-slot>

    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 32px 24px;
        }
        .form-group {
            margin-bottom: 24px;
        }
        label {
            display: block;
            font-weight: 700;
            margin-bottom: 8px;
            color: #111827;
        }
        input, textarea, select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 14px;
            font-size: 1rem;
        }
        textarea {
            min-height: 150px;
        }
        .ingredient-row {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
        }
        .ingredient-row input:first-child {
            flex: 2;
        }
        .ingredient-row input:last-child {
            flex: 1;
        }
        .btn-add-ingredient {
            background: #eff6ff;
            color: #1d4ed8;
            padding: 8px 16px;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            margin-top: 8px;
        }
        .btn-submit {
            background: #3b82f6;
            color: white;
            padding: 14px 28px;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 700;
        }
        .btn-cancel {
            background: #f3f4f6;
            color: #374151;
            padding: 14px 28px;
            border-radius: 9999px;
            text-decoration: none;
            margin-left: 12px;
        }
    </style>

    <div class="form-container">
        <form action="{{ route('my-recipes.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Recipe Title *</label>
                <input type="text" name="title" required value="{{ old('title') }}">
            </div>

            <div class="form-group">
                <label>Category</label>
                <select name="category">
                    <option value="">Select Category</option>
                    <option value="Breakfast">Breakfast</option>
                    <option value="Lunch">Lunch</option>
                    <option value="Dinner">Dinner</option>
                    <option value="Dessert">Dessert</option>
                    <option value="Snack">Snack</option>
                    <option value="Vegetarian">Vegetarian</option>
                    <option value="Vegan">Vegan</option>
                </select>
            </div>

            <div class="form-group">
                <label>Ingredients *</label>
                <div id="ingredients-container">
                    <div class="ingredient-row">
                        <input type="text" name="ingredients[]" placeholder="Ingredient name" required>
                        <input type="text" name="measures[]" placeholder="Amount (e.g., 2 cups)">
                    </div>
                </div>
                <button type="button" class="btn-add-ingredient" onclick="addIngredient()">+ Add Another Ingredient</button>
            </div>

            <div class="form-group">
                <label>Instructions *</label>
                <textarea name="instructions" required>{{ old('instructions') }}</textarea>
            </div>

            <div class="form-group">
                <label>Cooking Time (minutes)</label>
                <input type="number" name="cooking_time" value="{{ old('cooking_time') }}" placeholder="e.g., 30">
            </div>

            <div class="form-group">
                <label>Image URL (optional)</label>
                <input type="url" name="image" value="{{ old('image') }}" placeholder="https://example.com/image.jpg">
            </div>

            <div class="form-group">
                <button type="submit" class="btn-submit">Save Recipe</button>
                <a href="{{ route('my-recipes.index') }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        function addIngredient() {
            const container = document.getElementById('ingredients-container');
            const newRow = document.createElement('div');
            newRow.className = 'ingredient-row';
            newRow.innerHTML = `
                <input type="text" name="ingredients[]" placeholder="Ingredient name" required>
                <input type="text" name="measures[]" placeholder="Amount (e.g., 2 cups)">
                <button type="button" onclick="this.parentElement.remove()" style="background: #fee2e2; border: none; border-radius: 8px; cursor: pointer;">❌</button>
            `;
            container.appendChild(newRow);
        }
    </script>
</x-app-layout>
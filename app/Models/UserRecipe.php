<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRecipe extends Model
{
    protected $table = 'user_recipes';
    
    protected $fillable = [
        'user_id', 'title', 'category', 'instructions', 
        'ingredients', 'measures', 'cooking_time', 'image'
    ];

    protected $casts = [
        'ingredients' => 'array',
        'measures' => 'array'
    ];

    // Alternative: Accessors if casts don't work
    public function getIngredientsAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function getMeasuresAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
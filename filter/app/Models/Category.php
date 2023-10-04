<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function objects()
    {
        return $this->belongsToMany(App::class, 'objects_subcategories', 'category_id', 'object_id');
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}

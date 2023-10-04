<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'subcategories';
    protected $fillable = [
        'name',
        'category_id',
        'button_category',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function objects()
    {
        return $this->belongsToMany(App::class, 'objects_subcategories', 'subcategory_id', 'object_id');
    }
}

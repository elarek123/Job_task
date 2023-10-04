<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use HasFactory;

    protected $table = 'objects';
    protected $fillable = [
        'name',
    ];

    public function subcategories()
    {
        return $this->belongsToMany(Category::class, 'objects_subcategories', 'object_id', 'subcategory_id');
    }
}

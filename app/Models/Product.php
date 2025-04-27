<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    //

    protected $fillable = [
        'name',
        'price',
        'image',
        'category_id',
        'available',
    ];
    
    protected $casts = [
        'available' => 'boolean',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $guraded = [];

    public function category()
    {
        return $this->belongsto(Category::class)->select('id','name');
    }
}

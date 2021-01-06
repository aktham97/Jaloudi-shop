<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
      'name','price','description','rating','rating_number','image','category_id','men','women','children','men','women','children'
    ];
}

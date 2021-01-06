<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shirt extends Model
{

    protected $table = 'products';
    protected $fillable = [
        'name' ,'price','description','rating','rating_number','image','men','women','children'
    ];
    public function newQuery()
    {
        return parent::newQuery()->where('category_id','=',1);
    }
}

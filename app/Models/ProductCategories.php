<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    protected $table        = 'product_categories';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'name',
    ];
    public $timestamps      = false;

    public function products()
    {
        return $this->hasMany(Products::class, 'product_categories_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table        = 'products';
    protected $primaryKey   = 'id';
    protected $fillable     = [
        'product_categories_id',
        'name',
        'description',
        'image',
        'price',
        'stock',
        'click',
    ];
    public $timestamps      = false;

    public function category()
    {
        return $this->belongsTo(ProductCategories::class, 'product_categories_id');
    }

    // public function orders()
    // {
    //     return $this->hasMany(Orders::class, 'product_id');
    // }
}

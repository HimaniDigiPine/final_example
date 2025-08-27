<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'product_name',
        'product_short_description',
        'product_description',
        'product_status',
        'price',
        'sale_price',
        'feature_image',
    ];


    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }
}

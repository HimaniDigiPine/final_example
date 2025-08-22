<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThemeOptionFront extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'theme_option_front'; 

    protected $fillable = [
        'option_name', 
        'option_value', 
        'option_image'
    ];
}

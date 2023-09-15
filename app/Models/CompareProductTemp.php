<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductUom;
use App\Models\Product;

class CompareProductTemp extends Model
{
    use HasFactory;
    protected $table = 'compare_product_temp';
    protected $guarded = [];  

   
}
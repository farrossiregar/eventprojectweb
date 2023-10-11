<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductUom;
use App\Models\SupplierProduct;
use App\Models\Buyer;
use App\Models\Supplier;

class RefundProduct extends Model
{
    use HasFactory;
    protected $table = 'refund_product';
    protected $guarded = [];  

    public function supplier()
    {
        return $this->hasOne(Supplier::class,'id','id_supplier');
    }

    public function buyer()
    {
        return $this->hasOne(Buyer::class,'id','id_buyer');
    }

    public function product()
    {
        return $this->hasOne(SupplierProduct::class,'id','product_id');
    }

}
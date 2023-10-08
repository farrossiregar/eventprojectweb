<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ProductUom;
use App\Models\RefundProduct;

class PurchaseOrderDetail extends Model
{
    use HasFactory;
    protected $table = 'purchase_order_detail';
    protected $guarded = [];  
    
    public function product()
    {
        return $this->hasOne(SupplierProduct::class,'id','product_id');
    }

    public function uom()
    {
        return $this->hasOne(ProductUom::class,'id','product_uom_id');
    }

    // public function refund()
    // {
    //     return $this->hasOne(RefundProduct::class,'id','id_po_detail');
    //     // return $this->hasOne(RefundProduct::class,'id','product_uom_id');
    // }
}

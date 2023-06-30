<?php

namespace App\Http\Livewire\PurchaseOrder;

use Livewire\Component;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\SupplierProduct;
use App\Models\SettingHarga;

class Editable extends Component
{
    public $data,$field,$is_edit=false,$value, $qty, $po_detail;
    protected $listeners = ['reload'=>'$refresh'];

    public function render()
    {
        return view('livewire.purchase-order.editable');
    }

    public function mount($field,$data,$id)
    {
        $this->field = $field;
        $this->value = $data;
        $this->data = $id;
        $this->po_detail    = PurchaseOrderDetail::where('id', $id)->first();
        $this->po           = PurchaseOrder::where('id', PurchaseOrderDetail::where('id', $id)->first()->id_po)->first();

        
    }

    

    public function save()
    {

        $field = $this->field;
        $data = PurchaseOrderDetail::find($this->data);


        if(SettingHarga::where('supplier_id', $this->po->id_supplier)->where('product_id', $this->po->id_supplier)->get()){
            $qty_max = SettingHarga::where('product_id', $this->po_detail->product_id)->max('qty');
            if($this->value > $qty_max){
                $price_level_disc = @SettingHarga::where('supplier_id',$this->po->id_supplier)->where('product_id', $this->po_detail->product_id)->orderBy('qty', 'desc')->first()->disc;
                
            }else{
                $qty_min = SettingHarga::where('product_id', $this->po_detail->product_id)->orderBy('qty', 'asc')->first()->qty;
                if(SettingHarga::where('product_id', $this->po_detail->product_id)->where('qty', $this->value)->first()){
                    
                    $price_level_disc = SettingHarga::where('product_id', $this->po_detail->product_id)
                                                    ->where('qty', $this->value)
                                                    ->first()->disc;
                }else{

                    if($this->value < $qty_min){
                        $price_level_disc = 0;
                    }else{
                        
                        $qty_abv = SettingHarga::where('product_id', $this->po_detail->product_id)
                                            ->where('qty', '>', $this->value)
                                            ->first()->qty;

                        $qty_curr = SettingHarga::where('product_id', $this->po_detail->product_id)
                                                ->where('qty', '<', $qty_abv)
                                                ->orderBy('qty', 'desc')
                                                ->first()->qty;

                        $price_level_disc   = @SettingHarga::where('product_id', $this->po_detail->product_id)
                                                            ->where('qty', '=', $qty_curr)
                                                            ->first()->disc;
                    }
                }
            }

            $prod_price = SupplierProduct::where('id',$this->po_detail->product_id)->first()->price;

            $data->disc         = $price_level_disc; 
            $data->disc_harga   = ($prod_price*$price_level_disc)/100; 
            $data->price        = $prod_price;
            $data->total_price  = ceil($prod_price - (($prod_price*$price_level_disc)/100));
        }else{
            $data->disc         = 0; 
            $data->disc_harga   = 0; 
            $data->price        = $prod_price;
            $data->total_price  = $prod_price;
        }


        $data->$field = $this->value;
        $data->save();

        $this->is_edit = false;
        $this->emit('reload');
    }
}

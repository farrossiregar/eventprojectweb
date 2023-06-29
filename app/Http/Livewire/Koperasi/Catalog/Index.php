<?php

namespace App\Http\Livewire\Koperasi\Catalog;

use Livewire\Component;
use App\Models\SupplierProduct;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use Livewire\WithPagination;
use Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $keyword,$insert=0,$qty;
    public $viewscatalog = 'list';
    public function render()
    {
        $user = Auth::user();
        $data = SupplierProduct::orderBy('id','DESC');

        // $this->viewscatalog = 'list';
        

        if($this->keyword){
            $data->where('nama_product','LIKE',"%{$this->keyword}%")
                ->orWhere('barcode','LIKE',"%{$this->keyword}%");
        }
        
        return view('livewire.koperasi.catalog.index')->with(['data'=>$data->paginate(200)]);
    }

    // public function viewcatalog($type){
    //     if($type == '1'){
    //         $this->viewscatalog = 'list';
    //         dd($this->viewscatalog);
    //     }else{
    //         $this->viewscatalog = 'card';
    //         dd($this->viewscatalog);
    //     }

    // }

    public function addproductpo($id)
    {
        $idsupplier = SupplierProduct::where('id', $id)->first()->id_supplier;
        $check = PurchaseOrder::where('id_buyer', Auth::user()->id)
                                ->where('status', '0')
                                ->where('id_supplier', $idsupplier)
                                ->first();

        // dd($check, $idsupplier, $id);

        if($check){
            $checkproduct = PurchaseOrderDetail::where('product_id', $id)->where('id_po', $check->id)->first();
            if($checkproduct){
                $updateproduct = PurchaseOrderDetail::where('product_id', $id)->where('id_po', $check->id)->first();
                $updateproduct->qty = $checkproduct->qty + $this->qty;
                $updateproduct->save();
            }else{
                $addproduct = new PurchaseOrderDetail();
                $addproduct->id_po = $check->id;
                $addproduct->product_id = $id;
                $addproduct->qty = $this->qty;
                $addproduct->save();
            }
        }else{
            $addpo = new PurchaseOrder();
            $addpo->id_supplier = $idsupplier;
            $addpo->id_buyer = Auth::user()->id;
            $addpo->save();
        }

        $this->insert = 0;
        // $add = new PurchaseOrderDetail();
        // $add = new PurchaseOrderDetail();
        // $this->emit('reload');
    }

   
}

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
    public $keyword;
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

    public function viewcatalog($type){
        if($type == '1'){
            $this->viewscatalog = 'list';
            dd($this->viewscatalog);
        }else{
            $this->viewscatalog = 'card';
            dd($this->viewscatalog);
        }

    }

    public function addproductpo($id)
    {
        // $check = PurchaseOrder::where('id_buyer', Auth::user()->id)
        //                         ->where('status', '0')
        //                         ->get();
        // $add = new PurchaseOrderDetail();
        // $add = new PurchaseOrderDetail();
        // $this->emit('reload');
    }

   
}

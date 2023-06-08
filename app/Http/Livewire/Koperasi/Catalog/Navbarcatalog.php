<?php

namespace App\Http\Livewire\Supplier\Catalog;

use Livewire\Component;
use App\Models\SupplierProduct;
use Livewire\WithPagination;
use Auth;

class Navbarcatalog extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $keyword;
    public function render()
    {
        $user = Auth::user();
        $data = SupplierProduct::where('id_supplier', $user->id)->orderBy('id','DESC');

        if($this->keyword){
            $data->where('nama_product','LIKE',"%{$this->keyword}%")
                ->orWhere('barcode','LIKE',"%{$this->keyword}%");
        }

        return view('livewire.supplier.catalog.navbarcatalog')->with(['data'=>$data->paginate(200)]);
    }
}

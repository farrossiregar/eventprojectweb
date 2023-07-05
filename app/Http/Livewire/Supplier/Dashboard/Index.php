<?php

namespace App\Http\Livewire\Supplier\Dashboard;

use Livewire\Component;
use App\Models\SupplierProduct;
use Livewire\WithPagination;
use Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $keyword;
    public function render()
    {
        $user = Auth::user();
        $data = SupplierProduct::orderBy('id','DESC');

        if($this->keyword){
            $data->where('nama_product','LIKE',"%{$this->keyword}%")
                ->orWhere('barcode','LIKE',"%{$this->keyword}%");
        }

        return view('livewire.supplier.dashboard.index')->with(['data'=>$data->paginate(200)]);
    }
}

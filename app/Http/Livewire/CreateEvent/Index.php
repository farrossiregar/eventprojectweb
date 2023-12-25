<?php

namespace App\Http\Livewire\CreateEvent;

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
        $data = SupplierProduct::where('id_supplier', $user->id)->orderBy('id','DESC');

        if($this->keyword){
            $data->where('nama_product','LIKE',"%{$this->keyword}%")
                ->orWhere('barcode','LIKE',"%{$this->keyword}%");
        }

        return view('livewire.create-event.index')->with(['data'=>$data->paginate(200)]);
    }


    public function delete($id){
        $delete = SupplierProduct::where('id', $id)->first();
        $delete->delete();
    }
}

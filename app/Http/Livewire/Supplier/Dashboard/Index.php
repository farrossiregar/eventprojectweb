<?php

namespace App\Http\Livewire\Supplier\Dashboard;

use Livewire\Component;
use App\Models\SupplierProduct;
use App\Models\PurchaseOrder;
use Livewire\WithPagination;
use Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $keyword, $data;
    public function render()
    {
        $user = Auth::user();
        $this->data = PurchaseOrder::where('id_supplier', $user->id)->where('status', '<>', '0')->orderBy('id','DESC')->take(5)->get();

        return view('livewire.supplier.dashboard.index');
    }
}

<?php

namespace App\Http\Livewire\RefundProduct;

use Livewire\Component;
use App\Models\PurchaseOrder;
use App\Models\RefundProduct;
use Livewire\WithPagination;
use Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $keyword,$filter=[],$total_po=0,$total_lunas=0,$total_belum_lunas=0;
    protected $listeners = ['refresh'=>'$refresh'];
    public function render()
    {
        $data = $this->getData();

        return view('livewire.refund-product.index')->with(['data'=>$data->paginate(200)]);
    }

    public function mount()
    {
        // $this->total_po = PurchaseOrder::whereYear('created_at',date('Y'))->sum('total_pembayaran');
        // $this->total_belum_lunas = PurchaseOrder::whereYear('created_at',date('Y'))->where('status_invoice',0)->sum('total_pembayaran');
        // $this->total_lunas = PurchaseOrder::whereYear('created_at',date('Y'))->where('status_invoice',1)->sum('total_pembayaran');

        \LogActivity::add('Refund Product');
    } 

    public function getData()
    {
        $user = Auth::user();
        if($user->user_access_id == 8){ // Buyer
            $data = RefundProduct::select(['refund_product.*','purchase_order.status as status_po'])
                                    ->join('purchase_order','refund_product.no_po','=','purchase_order.no_po')
                                    ->where('purchase_order.id_buyer', $user->id)
                                    ->orderBy('refund_product.id','DESC');
        }elseif($user->user_access_id == 7){ // Supplier
            $data = RefundProduct::select(['refund_product.*','purchase_order.status as status_po'])
                                    ->join('purchase_order','refund_product.no_po','=','purchase_order.no_po')
                                    ->where('purchase_order.id_supplier', $user->id)
                                    ->orderBy('refund_product.id','DESC');

        }else{
            $data = RefundProduct::select(['refund_product.*','purchase_order.status as status_po'])
                                    ->join('purchase_order','refund_product.no_po','=','purchase_order.no_po')
                                    ->orderBy('refund_product.id','DESC');
        }
        
        return $data;
    }

    public function insert()
    {
        $data = new PurchaseOrder();
        $data->no_po = "PO/".date('ymd')."/".str_pad((PurchaseOrder::count()+1),4, '0', STR_PAD_LEFT);
        $data->status = 0;
        $data->save();

        \LogActivity::add('Purchase Order Insert');

        return redirect()->route('purchase-order.detail',$data->id);
    }
}

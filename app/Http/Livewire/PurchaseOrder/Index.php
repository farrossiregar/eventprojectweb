<?php

namespace App\Http\Livewire\PurchaseOrder;

use Livewire\Component;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use Livewire\WithPagination;
use Auth;

class Index extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $keyword,$filter=[],$total_po=0,$total_lunas=0,$total_belum_lunas=0;
    protected $listeners = [
        'modal_upload_refund'=>'modalUploadRefund'
    ];
    public function render()
    {
        $data = $this->getData();

        return view('livewire.purchase-order.index')->with(['data'=>$data->paginate(200)]);
    }

    public function mount()
    {
        $this->total_po = PurchaseOrder::whereYear('created_at',date('Y'))->sum('total_pembayaran');
        $this->total_belum_lunas = PurchaseOrder::whereYear('created_at',date('Y'))->where('status_invoice',0)->sum('total_pembayaran');
        $this->total_lunas = PurchaseOrder::whereYear('created_at',date('Y'))->where('status_invoice',1)->sum('total_pembayaran');

        \LogActivity::add('Purchase Order');
    } 

    public function getData()
    {
        $user = Auth::user();
        if($user->user_access_id == 8){ // Buyer
            $data = PurchaseOrder::where('id_buyer', $user->id)->orderBy('id','DESC');
        }elseif($user->user_access_id == 7){ // Supplier
            $data = PurchaseOrder::where('id_supplier', $user->id)->where('status', '<>', '0')->orderBy('id','DESC');
        }else{
            $data = PurchaseOrder::orderBy('id','DESC');
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

    public function modalUploadRefund($id)
    {
        $data = PurchaseOrderDetail::where('id', $id)->first();
        

        // \LogActivity::add('Purchase Order Insert');

        // return redirect()->route('purchase-order.detail',$data->id);
    }

    // public function kirimUploadRefund($id)
    // {
    //     $data = PurchaseOrderDetail::where('id', $id)->first();
    // }
}

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
    protected $listeners = [
        'modal_detail_product'=>'modalDetailProduct',
    ];

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $keyword,$insert=0,$qty;
    public $price, $name, $date, $sortetc;

    public $selected_id, $title_detail, $supplier_detail, $stock_detail, $deskripsi_detail, $image_detail, $price_detail;

    public $viewscatalog = 'list', $card=FALSE, $optview, $sort_by, $sort_val, $sort_val_opt=true;
    public function render()
    {
        $user = Auth::user();
        $data = SupplierProduct::whereNotNull('id');
        // dd($data->get());

        
        // if($this->optview == 'list'){
        //     $this->card = false;
        // }else{
        //     $this->card = true;
        // }
        

        if($this->keyword){
            $data->where('nama_product','LIKE',"%{$this->keyword}%")
                ->orWhere('barcode','LIKE',"%{$this->keyword}%");
        }

        if($this->sort_by){
            if($this->sort_by != 'popular'){
                $this->sort_val_opt = true;
    
                if($this->sort_val == 'asc'){
                    $data->orderBy($this->sort_by, 'ASC'); 
                }else{
                    $data->orderBy($this->sort_by, 'DESC'); 
                }
            }else{
                $this->sort_val_opt = false;
                $data->orderBy($this->sort_by, 'DESC'); 
            }
        }else{
            $this->sort_by = 'created_at';
            $this->sort_val = 'desc';
            $data->orderBy($this->sort_by, $this->sort_val); 
        }
        

        // if($this->price){
        //     if($this->price == 'lo'){
        //         $dataprice = $data->orderBy('price', 'ASC');    
        //     }else{
        //         $dataprice = $data->orderBy('price', 'DESC'); 
        //     }
        // }else{
        //     $dataprice = $data->orderBy('price', 'ASC');    
        // }

        // if($this->date){
        //     if($this->date == 'old'){
        //         $datadate = $data->orderBy('id', 'ASC');    
        //     }else{
        //         $datadate = $data->orderBy('id', 'DESC');   
        //     }
        // }else{
        //     $datadate = '';   
        // }
        
        // $data->$dataprice;
        // $data = $data->where('id', 'ASC');
        
        return view('livewire.koperasi.catalog.index')->with(['data'=>$data->paginate(200)]);
    }

    public function modalDetailProduct($id)
    {
        $this->selected_id = $id;
        

        $data_detail                 = SupplierProduct::where('id', $this->selected_id)->first();
        $this->title_detail          = $data_detail->nama_product;
        $this->supplier_detail       = $data_detail->id_supplier;
        $this->stock_detail          = $data_detail->qty;
        $this->deskripsi_detail      = $data_detail->desc_product;
        $this->image_detail          = $data_detail->image_source;
        $this->price_detail          = $data_detail->price;
    }

  

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

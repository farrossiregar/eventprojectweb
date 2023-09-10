<?php

namespace App\Http\Livewire\Koperasi\Compare;

use Livewire\Component;
use App\Models\SupplierProduct;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\SettingHarga;
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

    public $selected_id, $title_detail, $supplier_detail, $stock_detail, $deskripsi_detail, $image_detail, $price_detail, $setting_harga, $price_akhir, $uom;

    public $viewscatalog = 'list', $card=FALSE, $optview, $sort_by, $sort_val, $sort_val_opt=true;
    public function render()
    {
        $user = Auth::user();
        $data = SupplierProduct::whereNotNull('id');
       

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
        
        
        return view('livewire.koperasi.compare.index')->with(['data'=>$data->paginate(200)]);
    }


    public function updated($propertyName)
    {
        if($propertyName=='qty'){
            // dd(get_disc_price($this->supplier_detail, $this->selected_id, $this->qty));
            $this->price_akhir = get_disc_price($this->supplier_detail, $this->selected_id, $this->qty)['price_akhir'];
        } 

        if($propertyName=='optview'){
            if($this->optview == 'list'){
                $this->card = false;
            }else{
                $this->card = true;
            }
        }

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
        $this->uom                   = \App\Models\ProductUom::where('id', $data_detail->product_uom_id)->first()->name;

        $this->price_akhir           = $data_detail->price;

        
    }

  

    public function addproductpo($id)
    {
        $qty = $this->qty;
        $this->insertproductpo($id, $qty);
    }

    public function beliproduct()
    {
        $id = $this->selected_id;
        $qty = $this->qty;
        $this->insertproductpo($id, $qty);
    }


    public function insertproductpo($id, $qty)
    {
        $idsupplier = SupplierProduct::where('id', $id)->first()->id_supplier;
        $check = PurchaseOrder::where('id_buyer', Auth::user()->id)
                                ->where('status', '0')
                                ->where('id_supplier', $idsupplier)
                                ->first();

        // dd($check, $idsupplier, $id);
        // dd(get_disc_price($idsupplier, $id, $this->qty)['price_akhir'] * $this->qty);

        $check_data_product = SupplierProduct::where('id', $id)->first();
        // $check_data_settingprice = SettingHarga::where()->get();
        if($check){
            
            $checkproduct = PurchaseOrderDetail::where('product_id', $id)->where('id_po', $check->id)->first();
            if($checkproduct){
                $updateproduct = PurchaseOrderDetail::where('product_id', $id)->where('id_po', $check->id)->first();
                $updateproduct->price = $check_data_product->price;
                $updateproduct->qty = $checkproduct->qty + $this->qty;
                $updateproduct->disc = get_disc_price($idsupplier, $id, ($checkproduct->qty + $this->qty))['disc_p'];
                $updateproduct->disc_harga = get_disc_price($idsupplier, $id, ($checkproduct->qty + $this->qty))['disc'];
                $updateproduct->total_price = get_disc_price($idsupplier, $id, ($checkproduct->qty + $this->qty))['price_akhir'] * ($checkproduct->qty + $this->qty);
                $updateproduct->save();
            }else{
                $addproduct = new PurchaseOrderDetail();
                $addproduct->id_po = $check->id;
                $addproduct->product_id = $id;
                $addproduct->price = $check_data_product->price;
                $addproduct->qty = $this->qty;
                $addproduct->disc = get_disc_price($idsupplier, $id, $this->qty)['disc_p'];
                $addproduct->disc_harga = get_disc_price($idsupplier, $id, $this->qty)['disc'];
                $addproduct->total_price = get_disc_price($idsupplier, $id, $this->qty)['price_akhir'] * $this->qty;
                $addproduct->product_uom_id = $check_data_product->product_uom_id;
                $addproduct->save();
            }
        }else{
            $addpo = new PurchaseOrder();
            $addpo->no_po = 'PO'.date('ymd').'0001';
            $addpo->id_supplier = $idsupplier;
            $addpo->id_buyer = Auth::user()->id;
            $addpo->status = 0;
            $addpo->save();

            $addproduct = new PurchaseOrderDetail();
            $addproduct->id_po = $addpo->id;
            $addproduct->product_id = $id;
            $addproduct->price = $check_data_product->price;
            $addproduct->qty = $this->qty;
            $addproduct->disc = get_disc_price($idsupplier, $id, $this->qty)['disc_p'];
            $addproduct->disc_harga = get_disc_price($idsupplier, $id, $this->qty)['disc'];
            $addproduct->total_price = get_disc_price($idsupplier, $id, $this->qty)['price_akhir'] * $this->qty;
            $addproduct->product_uom_id = $check_data_product->product_uom_id;
            $addproduct->save();
        }

        $this->insert = 0;
        // $add = new PurchaseOrderDetail();
        // $add = new PurchaseOrderDetail();
        // $this->emit('reload');

        session()->flash('message', 'Produk Berhasil Ditambahkan.');
    }

    

   
}

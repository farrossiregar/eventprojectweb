<?php

namespace App\Http\Livewire\UserSupplier;

use Livewire\Component;
use App\Models\UserMember;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Product;
use Livewire\WithPagination;
use Auth;

class ListProduk extends Component
{
    public $supplier_id,$insert=false,$insert_product=false,$data_product=[], $keyword, $price;
    protected $listeners = ['reload'=>'$refresh'];
    // public $product_id,$qty,$desc_product,$price,$product_uom_id, $keyword;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $user = Auth::user();
        $data = SupplierProduct::where('id_supplier', $this->data->id);

        dd($data->get());
        // $this->viewscatalog = 'list';
        

        if($this->keyword){
            $data->where('nama_product','LIKE',"%{$this->keyword}%")
                ->orWhere('barcode','LIKE',"%{$this->keyword}%");
        }

        if($this->price){
            if($this->price == 'lo'){
                $dataprice = $data->orderBy('price', 'ASC');    
            }else{
                $dataprice = $data->orderBy('price', 'DESC'); 
            }
        }else{
            $dataprice = $data->orderBy('price', 'ASC');    
        }

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

    public function updated($propertyName)
    {
        if($this->insert_product==true){
            $this->emit('insert-product');
        }
    }

    public function saveProduct()
    {
        $this->validate([
            'product_id' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'product_uom_id' => 'required'
        ],[
            'product_id.required' => 'Produk harus diisi',
            'qty.required' => 'QTY Produk harus diisi',
            'price.required' => 'Harga jual harus diisi',
        ]);

        $data = new SupplierProduct();
        $data->product_id = $this->product_id;
        $data->desc_product = $this->desc_product;
        $data->qty = $this->qty;
        $data->price = $this->price;
        $data->product_uom_id = $this->product_uom_id;
        $data->id_supplier = $this->data->id;
        $data->save();

        $this->insert_product = false;$this->reset('product_id','desc_product','qty','price','product_uom_id');
        $this->emit('message-success','Data produk berhasil ditambahkan');
        $this->emit('reload');
    }

    public function mount(Supplier $data)
    {
        $this->data = $data;
        // $this->data_product = Product::select('id',\DB::raw("CONCAT(kode_produksi,' / ', keterangan) as text"))->get()->toArray();
        // $this->data_product = SupplierProduct::select('id',\DB::raw("CONCAT(kode_produksi,' / ', keterangan) as text"))->get()->toArray();
        $this->data_product = SupplierProduct::where('id_supplier', $this->data->id)->get();
    }

    public function save()
    {
        $this->reset(['nama_supplier','email','no_telp','alamat_supplier']);
        $this->insert = false;
    }
}

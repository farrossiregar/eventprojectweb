<?php

namespace App\Http\Livewire\PurchaseOrder;

use Livewire\Component;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\SupplierProduct;
use App\Models\SettingHarga;

class Detail extends Component
{
    public $data,$pembelian = [],$no_po,$id_supplier,$supplier=[],$suppliers=[],$product_supplier=[],$product_po=[];
    public $data_product = [],$price,$qty,$product_uom_id,$product_id,$tab_active='tab-supplier',$biaya_pengiriman=0,$total_pembayaran=0;
    public $alamat_penagihan,$purchase_order_date,$delivery_order_number,$delivery_order_date,$disc=0,$pajak=0,$catatan;
    protected $listeners = ['reload'=>'$refresh'];
    public $nama_product;
    public function render()
    {
        return view('livewire.purchase-order.detail');
    }

    public function mount(PurchaseOrder $data)
    {
        $this->data = $data;
        $this->id_supplier = $data->id_supplier;
        if($this->id_supplier) $this->supplier = Supplier::find($this->id_supplier);
        $this->no_po = $data->no_po;
        $this->catatan = $data->catatan;
        $this->pajak = $data->ppn;
        $this->biaya_pengiriman = $data->biaya_pengiriman;
        $this->alamat_penagihan = $data->alamat_penagihan?$data->alamat_penagihan:get_setting('address');
        $this->purchase_order_date = $data->purchase_order_date;
        $this->delivery_order_number = $data->delivery_order_number;
        $this->delivery_order_date = $data->delivery_order_date;
        $this->suppliers = Supplier::orderBy('id','DESC')->get(); 
        $data_product = [];
        foreach(Product::get() as $k => $item){
            $data_product[$k]['id'] = $item->id;
            $data_product[$k]['text'] = $item->kode_produksi;
            $data_product[$k]['text'] .= $item->kode_produksi ? ' / '.$item->keterangan : $item->keterangan;
        }
        $this->data_product = $data_product;// Product::select('id',\DB::raw("CONCAT(kode_produksi,' - ', keterangan) as text"))->get()->toArray();
    }

    public function updated($propertyName)
    {
        if($propertyName=='id_supplier'){
            $this->data->id_supplier = $this->id_supplier;
            $this->data->save();
        }
        if($this->id_supplier){
            $this->product_supplier = SupplierProduct::where('id_supplier', $this->id_supplier)->orderBy('id','DESC')->get();
            $this->supplier = Supplier::find($this->id_supplier);
        }

        if($this->qty){
            $qty_abv = SettingHarga::where('supplier_id', $this->id_supplier)->where('qty', '>', $this->qty)->first();
            if($qty_abv){
                $price_level_disc = SettingHarga::where('supplier_id', $this->id_supplier)->where('qty', $qty_abv->qty)->first()->disc;
                
            }else{
                $max_qty            = SettingHarga::where('supplier_id', $this->id_supplier)->orderBy('disc', 'asc')->first();
                $price_level_disc   = SettingHarga::where('supplier_id', $this->id_supplier)->orderBy('disc', 'desc')->first()->disc;
                
            }
            
            // dd($price_level_disc);
            // dd($this->id_supplier.' = '.$this->qty);
            // if($this->qty < 10){
            //     $this->disc = 0;
            // }elseif($this->qty < 50){
            //     $this->disc = 10;
            // }else{
            //     $this->disc = 20;
            // }
            $this->price = $this->price - (($this->price*$price_level_disc)/100);

            
        }

        foreach($this->data->details as $item){
            $this->total_pembayaran += $item->price * $item->qty;
        }

        if($propertyName=='product_id'){
            $product = SupplierProduct::where(['id_supplier'=>$this->id_supplier,'product_id'=>$this->product_id])->first();
            if($product) $this->price = $product->price;
        }
    }

    public function addProductSupplier(SupplierProduct $data)
    {
        $detail = PurchaseOrderDetail::where(['id_po'=>$this->data->id,'product_id'=>$data->product_id])->first();
        if(!$detail){
            $detail = new PurchaseOrderDetail();
            $detail->qty = 1;
            $detail->id_po = $this->data->id;
            $detail->item = $this->nama_product;
            $detail->product_id = $data->product_id;
            $detail->product_uom_id = $data->product_uom_id;
            $detail->price = $data->price;
            $detail->save();
        }else{
            $detailupdate = PurchaseOrderDetail::where(['id_po'=>$this->data->id,'product_id'=>$data->product_id])->first();
            $detailupdate->qty = $detailupdate->qty+1;
            $detailupdate->total_price = $detailupdate->qty * $data->price;
            $detailupdate->save();
        }

        $this->emit('reload');
    }

    public function addProduct()
    {
        $this->validate([
            'id_supplier' => 'required',
            'product_id' => 'required',
            'qty' => 'required',
            'price' => 'required'
        ],[
            'id_supplier.required' => 'Supplier harus dipilih',
            'product_id.required' => 'Produk harus dipilih',
            'qty.required' => 'Produk harus diisi',
            'price.required' => 'Harga Produk harus diisi'
        ]);

        $detail = PurchaseOrderDetail::where(['id_po'=>$this->data->id,'product_uom_id'=>$this->product_uom_id,'product_id'=>$this->product_id])->first();
        if(!$detail){
            $detail = new PurchaseOrderDetail();
            $detail->id_po = $this->data->id;
            $detail->product_id = $this->product_id;
            $detail->product_uom_id = $this->product_uom_id;
            $detail->qty = $this->qty;
            $detail->price = $this->price;
            $detail->disc = $this->disc;
            $detail->save();
        }else{
            $detail->qty = $detail->qty + $this->qty;
            $detail->save();
        }

        $this->emit('reload');
    }

    public function deleteProduct($id)
    {
        PurchaseOrderDetail::find($id)->delete();
        $this->emit('reload');
    }

    public function save()
    {
        $this->total_pembayaran = 0;$total_qty = 0;$total_product = 0;
        foreach($this->data->details as $item){
            $this->total_pembayaran += ($item->price - $item->disc) * $item->qty;
            $total_qty += $item->qty;$total_product++; 
        }
        
        $this->data->total_qty = $total_qty;
        $this->data->total_product = $total_product;
        $this->data->ppn = $this->pajak;
        $this->data->biaya_pengiriman = $this->biaya_pengiriman;
        $this->data->total_pembayaran = $this->total_pembayaran + $this->biaya_pengiriman + $this->pajak;
        $this->data->alamat_penagihan = $this->alamat_penagihan;
        $this->data->purchase_order_date = $this->purchase_order_date;
        $this->data->delivery_order_number = $this->delivery_order_number;
        $this->data->delivery_order_date = $this->delivery_order_date;
        $this->data->catatan = $this->catatan;
        $this->data->save();
    }

    public function sendpayment()
    {
        $this->data->status = 3;
        $this->data->save();
        
        session()->flash('message-success',"Pembayaran dikirimkan ke Supplier");

        return redirect()->route('purchase-order.detail',$this->data->id);
    }


    public function saveAsDraft()
    {
        $this->save();

        session()->flash('message-success',"Purchase Order berhasil di simpan");

        \LogActivity::add('Purchase Order Save as Draft #'. $this->data->id);

        return redirect()->route('purchase-order.detail',$this->data->id);
    }

    public function submit()
    {
        $this->save();

        $this->data->status = 1;
        $this->data->save();

        foreach($this->data->details as $item){
            $product_supplier = SupplierProduct::where(['id_supplier'=>$this->id_supplier,
                                                        'product_uom_id'=>$item->product_uom_id,
                                                        'product_id'=>$item->product_id
                                                        ])->first();
            if(!$product_supplier){
                $product_supplier = new SupplierProduct();
                $product_supplier->id_supplier = $this->id_supplier;
                $product_supplier->product_uom_id = $item->product_uom_id;
                $product_supplier->product_id = $item->product_id;
                $product_supplier->price = $item->price;
                $product_supplier->disc = $item->disc;
            }else{
                $product_supplier->product_uom_id = $item->product_uom_id;
                $product_supplier->product_id = $item->product_id;
                $product_supplier->price = $item->price;
                $product_supplier->disc = $item->disc;
            }

            $product_supplier->save();
        }

        session()->flash('message-success',"Purchase Order berhasil di submit");

        return redirect()->route('purchase-order.detail',$this->data->id);
    }
}
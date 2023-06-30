<?php

namespace App\Http\Livewire\PurchaseOrder;

use Livewire\Component;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\SupplierProduct;
use App\Models\SettingHarga;
use App\Models\ProductUom;
use App\Models\InvoicePoItem;
use Livewire\WithFileUploads;
use Auth;

class Detail extends Component
{
    use WithFileUploads;

    public $data,$pembelian = [],$no_po,$id_supplier,$supplier=[],$suppliers=[],$product_supplier=[],$product_po=[];
    public $data_product = [],$price, $price_akhir,$qty,$product_uom_id,$product_id,$tab_active='tab-supplier',$biaya_pengiriman=0,$total_pembayaran=0;
    public $alamat_penagihan,$purchase_order_date,$delivery_order_number,$delivery_order_date,$disc=0,$disc_p=0,$pajak=0,$catatan;
    protected $listeners = ['reload'=>'$refresh'];
    public $nama_product;

    public $payment_date, $payment_amount, $file_bukti_pembayaran, $metode_pembayaran;
    // public $data_invoice = [];
    public $data_invoice, $sisa_bayar_inv;
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
        $this->pajak = 0;//$data->ppn;
        $this->biaya_pengiriman = $data->biaya_pengiriman;
        $this->alamat_penagihan = $data->alamat_penagihan?$data->alamat_penagihan:get_setting('address');
        $this->purchase_order_date = $data->purchase_order_date;
        $this->delivery_order_number = $data->delivery_order_number;
        $this->delivery_order_date = $data->delivery_order_date;
        $this->suppliers = Supplier::orderBy('id','DESC')->get(); 
        $data_product = [];
        foreach(SupplierProduct::where('id_supplier', $this->id_supplier)->orderBy('id','DESC')->get() as $k => $item){
        // foreach(Product::get() as $k => $item){
            $data_product[$k]['id'] = $item->id;
            // $data_product[$k]['text'] = $item->kode_produksi;
            // $data_product[$k]['text'] .= $item->kode_produksi ? ' / '.$item->keterangan : $item->keterangan;

            $data_product[$k]['text'] = $item->barcode;
            $data_product[$k]['text'] .= $item->barcode ? ' / '.$item->nama_product : $item->nama_product;
        }
        $this->data_product = $data_product;// Product::select('id',\DB::raw("CONCAT(kode_produksi,' - ', keterangan) as text"))->get()->toArray();

        $this->data_invoice = InvoicePoItem::where('po_id', $data->id)->get();
        $this->sisa_bayar_inv = $data->total_pembayaran - \App\Models\InvoicePoItem::where('po_id', $this->data->id)->sum('amount');
        $this->payment_amount = $this->sisa_bayar_inv;
        
       
    }

    public function updated($propertyName)
    {

        if($this->id_supplier != $this->data->id_supplier){
            $delete_po_detail = PurchaseOrderDetail::where('id_po', $this->data->id)->delete();
            $this->emit('reload');
        }

        if($propertyName=='id_supplier'){
            $check_po_sup = PurchaseOrder::where('id_supplier', $this->id_supplier)->where('status', '0')->where('id_buyer', Auth::user()->id)->first();
            
            if($check_po_sup){
                // return route('purchase-order-administration.detail',$this->data->id);
                return redirect()->to('purchase-order/detail/'.$check_po_sup->id);
            }else{
                $this->data->id_supplier = $this->id_supplier;
                $this->data->save();

                return redirect(request()->header('Referer'));
            }
        }
        if($this->id_supplier){
            $this->product_supplier = SupplierProduct::where('id_supplier', $this->id_supplier)->orderBy('id','DESC')->get();
            $this->supplier = Supplier::find($this->id_supplier);
            $this->emit('reload');
        }

        if($this->product_id){
            $this->product_uom_id = @ProductUom::where('id', @SupplierProduct::where('id', $this->product_id)->first()->product_uom_id)->first()->name;
        }

        // if($this->qty && $this->product_id){
        if($this->qty){
            if(SettingHarga::where('supplier_id', $this->id_supplier)->where('product_id', $this->product_id)->get()){
                $qty_max = SettingHarga::where('product_id', $this->product_id)->max('qty');
                if($this->qty > $qty_max){
                    // $price_level_disc = @SettingHarga::where('supplier_id', $this->id_supplier)->where('product_id', $this->product_id)->where('qty', $this->qty)->first()->disc;
                    $price_level_disc = @SettingHarga::where('supplier_id', $this->id_supplier)->where('product_id', $this->product_id)->orderBy('qty', 'desc')->first()->disc;
                    
                }else{
                    $qty_min = SettingHarga::where('product_id', $this->product_id)->orderBy('qty', 'asc')->first()->qty;
                    if(SettingHarga::where('product_id', $this->product_id)->where('qty', $this->qty)->first()){
                        
                        $price_level_disc = SettingHarga::where('product_id', $this->product_id)
                                                        ->where('qty', $this->qty)
                                                        ->first()->disc;
                    }else{

                        if($this->qty < $qty_min){
                            $price_level_disc = 0;
                        }else{
                            
                            $qty_abv = SettingHarga::where('product_id', $this->product_id)
                                                ->where('qty', '>', $this->qty)
                                                ->first()->qty;

                            $qty_curr = SettingHarga::where('product_id', $this->product_id)
                                                    ->where('qty', '<', $qty_abv)
                                                    ->orderBy('qty', 'desc')
                                                    ->first()->qty;

                            // $qty_blw = SettingHarga::where('product_id', $this->product_id)
                            //                         ->where('qty', '<', $qty_curr)
                            //                         ->first();

                            // if($qty_blw){
                                // dd($qty_abv, $qty_curr, $qty_blw);

                            //     $price_level_disc   = @SettingHarga::where('product_id', $this->product_id)
                            //                                     ->where('qty', '>', $qty_blw->qty)
                            //                                     ->where('qty', '<', $qty_abv)
                            //                                     ->orderBy('qty', 'asc')
                            //                                     ->first()->disc;
                            // }else{
                            //     // dd('b', $qty_abv, $qty_curr);
                            //     $price_level_disc   = @SettingHarga::where('product_id', $this->product_id)
                            //                                     ->where('qty', '=', $qty_curr)
                            //                                     // ->where('qty', '<', $qty_abv)
                            //                                     ->orderBy('qty', 'asc')
                            //                                     ->first()->disc;
                            // }

                            $price_level_disc   = @SettingHarga::where('product_id', $this->product_id)
                                                                ->where('qty', '=', $qty_curr)
                                                                ->first()->disc;
                        }
                    }
                }
 

                $this->disc_p       = $price_level_disc; 
                $this->disc         = ($this->price*$price_level_disc)/100; 
                $this->price        = $this->price;
                $this->price_akhir  = ceil($this->price - (($this->price*$price_level_disc)/100));
            }else{
                $this->disc_p       = 0; 
                $this->disc         = 0; 
                $this->price        = $this->price;
                $this->price_akhir  = $this->price;
            }
          
             
        }elseif($this->product_id){
            
            $this->price        = @SupplierProduct::where('id', $this->product_id)->first()->price;
            $this->price_akhir  = @SupplierProduct::where('id', $this->product_id)->first()->price;
            // dd(SupplierProduct::where('id', $this->product_id)->first());
            $this->disc         = 0;
            $this->disc_p       = 0; 
        }else{
            $this->price        = 0;
            $this->price_akhir  = 0;
            $this->disc         = 0;
            $this->disc_p       = 0; 
        }

        foreach($this->data->details as $item){
            $this->total_pembayaran += $this->price_akhir * $item->qty;
        }

        if($propertyName=='product_id'){
            $product = SupplierProduct::where(['id_supplier'=>$this->id_supplier,'product_id'=>$this->product_id])->first();
            if($product){
                $this->price        = $product->price;
                $this->price_akhir  = $product->price;
            }
                
        }
    }

    public function addProductSupplier(SupplierProduct $data)
    {
        $detail = PurchaseOrderDetail::where(['id_po'=>$this->data->id,'product_id'=>$data->product_id])->first();
        if(!$detail){
            $detail                 = new PurchaseOrderDetail();
            $detail->qty            = 1;
            $detail->id_po          = $this->data->id;
            $detail->item           = $this->nama_product;
            $detail->product_id     = $data->product_id;
            $detail->product_uom_id = \App\Models\ProductUom::where('name', $data->product_uom_id)->first()->id;
            $detail->price          = $data->price;
            $detail->disc           = $this->disc_p;
            $detail->disc_harga     = $this->disc;
            $detail->total_harga    = $this->price_akhir;
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
            $detail                 = new PurchaseOrderDetail();
            $detail->id_po          = $this->data->id;
            $detail->product_id     = $this->product_id;
            $detail->product_uom_id = \App\Models\ProductUom::where('name', $this->product_uom_id)->first()->id;
            $detail->qty            = $this->qty;
            $detail->price          = $this->price;
            $detail->disc           = $this->disc_p;
            $detail->disc_harga     = $this->disc;
            $detail->total_price    = $this->price_akhir;

            $detail->save();
        }else{
            $detail->qty = $detail->qty + $this->qty;
            $detail->save();
        }

        $this->disc         = '';
        $this->disc_p       = '';
        $this->price        = '';
        $this->price_akhir  = '';
        $this->reset(['product_id','qty']);
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

        // $validate = [
        //     'payment_date' => 'required',
        //     'metode_pembayaran' => 'required'
        // ];

        if($this->file_bukti_pembayaran) $validate['file_bukti_pembayaran'] = 'file|mimes:xlsx,csv,xls,doc,docx,pdf,jpg,jpeg,png|max:51200'; //] 50MB Max
        
        // $this->validate($validate);

        if($this->data->status == 2){
            if(\App\Models\InvoicePoItem::where('po_id', $this->data->id)->get()){
                $sisa_bayar = $this->data->total_pembayaran - \App\Models\InvoicePoItem::where('po_id', $this->data->id)->sum('amount');
                $sisa_bayar = $sisa_bayar - $this->payment_amount;
                if($sisa_bayar == 0){
                    $this->data->status = 3;
                    $this->data->save();
                }
            }else{
                $sisa_bayar = $this->data->total_pembayaran - $this->payment_amount;
                if($sisa_bayar == 0){
                    $this->data->status = 3;
                    $this->data->save();
                }
            }
            
        }

        $payinvoice                         = new InvoicePoItem();
        // $payinvoice->no_invoice          = 'INV/'.$this->data->no_po;
        $payinvoice->po_id                 = $this->data->id;
        $payinvoice->amount                 = $this->payment_amount;
        // $payinvoice->metode_pembayaran      = $this->metode_pembayaran;
        $payinvoice->metode_pembayaran      = 9;
        if($this->file_bukti_pembayaran!="") {
            $name = $this->data->id.".".$this->file_bukti_pembayaran->extension();
            $this->file_bukti_pembayaran->storePubliclyAs("public/invoice-po-supplier/{$this->data->id}", $name);
            $payinvoice->file = "storage/invoice-po-supplier/{$this->data->id}/{$name}";
        }
        $payinvoice->created_at             = date('Y-m-d H:i:s');
        $payinvoice->updated_at             = date('Y-m-d H:i:s');
        $payinvoice->save();

        
        
        session()->flash('message-success',"Pembayaran dikirimkan ke Supplier");

        return redirect()->route('purchase-order.detail',$this->data->id);
    }

    public function sendinvoice(){
        $this->data->status = 2;
        $this->data->save();
        session()->flash('message-success',"Invoice berhasil dikirimkan ke Customer");

        return redirect()->route('purchase-order-supplier.detail',$this->data->id);
    }

    public function updateaspaid(){
        $this->data->status = 4;
        $this->data->save();

        // dd($this->data->details);
        foreach($this->data->details as $item){
            $cekproduk = Product::where('keterangan', $item->item)->first();
            // dd($cekproduk);
            if($cekproduk){
                $cekproduk->qty = isset($cekproduk->qty) ? $cekproduk->qty + $item->qty : $item->qty;
                $cekproduk->save();
                continue;
            }else{
                $insertproduk               = new Product();
                $insertproduk->keterangan   = $item->item;
                $insertproduk->harga        = $item->price;
                $insertproduk->qty          = $item->qty;
                $insertproduk->save();
                continue;
            }
            $this->total_pembayaran += $item->price * $item->qty;
        }

        session()->flash('message-success',"Pembayaran Purchase Order dikonfirmasi");

        return redirect()->route('purchase-order-supplier.detail',$this->data->id);
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

        $this->data->submitted_date = date('Y-m-d');
        $this->data->status = 1;
        $this->data->save();

        // foreach($this->data->details as $item){
            // $product_supplier = SupplierProduct::where(['id_supplier'=>$this->id_supplier,
            //                                             'product_uom_id'=>$item->product_uom_id,
            //                                             'product_id'=>$item->product_id
            //                                             ])->first();
            // if(!$product_supplier){
            //     $product_supplier = new SupplierProduct();
            //     $product_supplier->id_supplier = $this->id_supplier;
            //     $product_supplier->product_uom_id = $item->product_uom_id;
            //     $product_supplier->product_id = $item->product_id;
            //     $product_supplier->price = $item->price;
            //     $product_supplier->disc = $item->disc;
            // }else{
            //     $product_supplier->product_uom_id = $item->product_uom_id;
            //     $product_supplier->product_id = $item->product_id;
            //     $product_supplier->price = $item->price;
            //     $product_supplier->disc = $item->disc;
            // }

            // $product_supplier->save();
        // }

        session()->flash('message-success',"Purchase Order berhasil di submit");

        return redirect()->route('purchase-order.detail',$this->data->id);
    }
}
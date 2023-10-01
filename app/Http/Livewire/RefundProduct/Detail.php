<?php

namespace App\Http\Livewire\RefundProduct;

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
use App\Models\RefundProduct;
use Livewire\WithFileUploads;
use Auth;

class Detail extends Component
{
    use WithFileUploads;

    
    public $data_product = [],$price, $price_akhir,$qty,$product_uom_id,$product_id,$tab_active='tab-supplier',$biaya_pengiriman=0,$total_pembayaran=0;
    
    public $data;
    public $no_po, $qty_po, $qty_ref, $price_po, $price_ref, $image_ref, $image_ref2, $image_ref3, $status;
    protected $listeners = ['reload'=>'$refresh'];
    
    public function render()
    {

        return view('livewire.refund-product.detail');
    }

    public function mount(RefundProduct $data)
    {
        
        $this->data = $data;        
        $this->no_ref = $data->no_ref;
        $this->no_po = $data->no_po;
        $this->qty_po = @PurchaseOrderDetail::where('id', $data->id_po_detail)->first()->qty;
        $this->qty_ref = $data->qty_ref;
        $this->price_po = @PurchaseOrderDetail::where('id', $data->id_po_detail)->first()->price;
        $this->price_ref = $data->price_ref;
        $this->image_ref = $data->image_ref;
        $this->image_ref2 = $data->image_ref2;
        $this->image_ref3 = $data->image_ref3;
        $this->status = $data->status;
        
    }

    public function updated($propertyName)
    {
        $this->price_ref = 0;

        if($this->qty_ref){
            $this->price_ref = $this->qty_ref * ($this->price_po/$this->qty_po);
        }
        
    }

 

    public function save()
    {
        $insert = new RefundProduct();
        $insert->no_ref = '';
        $insert->no_po = '';
        $insert->qty_po = $this->qty_po;
        $insert->qty_ref = $this->qty_ref;
        $insert->price_po = $this->price_po;
        $insert->price_ref = $this->price_ref;

        if($this->image_ref!="") {
            $name = $this->data->id.".".$this->image_ref->extension();
            $this->image_ref->storePubliclyAs("public/refund-product/{$this->data->id}", $name);
            $insert->image_ref = "storage/refund-product/{$this->data->id}/{$name}";
        }

        if($this->image_ref2!="") {
            $name = $this->data->id.".".$this->image_ref2->extension();
            $this->image_ref2->storePubliclyAs("public/refund-product/{$this->data->id}", $name);
            $insert->image_ref2 = "storage/refund-product/{$this->data->id}/{$name}";
        }

        if($this->image_ref3!="") {
            $name = $this->data->id.".".$this->image_ref3->extension();
            $this->image_ref3->storePubliclyAs("public/refund-product/{$this->data->id}", $name);
            $insert->image_ref3 = "storage/refund-product/{$this->data->id}/{$name}";
        }

        // $insert->image_ref = $this->image_ref;
        // $insert->image_ref2 = $this->image_ref2;
        // $insert->image_ref3 = $this->image_ref3;
        $insert->status = 1;
        $insert->save();
        
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
        $this->data->biaya_pengiriman = $this->biaya_pengiriman;
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

    public function updateasdeliver(){
        $this->data->status = 4;
        $this->data->save();

        session()->flash('message-success',"Barang sudah dikirim");

        return redirect()->route('purchase-order-supplier.detail',$this->data->id);
    }

    public function updateasreceived(){
        $this->data->status = 5;
        $this->data->save();

        session()->flash('message-success',"Barang sudah diterima");

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